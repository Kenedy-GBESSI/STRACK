<?php

declare(strict_types=1);

namespace App\Services\InternShips;

use App\Data\File\FileData;
use App\Models\InternShip;
use App\Models\Parameter;
use App\Models\StorageSite;
use App\Models\Supplier;
use App\Services\Files\FtpConfigService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Sopamo\LaravelFilepond\Filepond;

/**
 * Class InternShipService
 */
class InternShipService
{
    /**
     * Save or Update a picture of internShip
     *
     * @return void
     */
    public function saveFile(InternShip $internShip, FileData $fileData, ?string $subStoragePath = null)
    {
        if (! is_null($fileData->file_id)) {
            return;
        }

        tap($internShip->file_associated_path, function ($previous) use ($internShip, $fileData, $subStoragePath) {

            $filepond = app(Filepond::class);
            $filePondPath = $filepond->getPathFromServerId($fileData->server_id);
            $filePondPath = str_replace('\\', '/', $filePondPath);
            $filePondPathParts = explode('/', $filePondPath);

            $fileName = $internShip->createFileName(end($filePondPathParts));
            $path = $internShip->createCustomPath($subStoragePath, $fileName);

            $internShip->update([
                'file_associated_path' => $path,
                'file_associated_name' => $fileName,
                'file_associated_uuid' => $fileData->server_id,
            ]);

            $file = Storage::get($filePondPath);
            if (! empty($file)) {
                Storage::disk(InternShip::relatedFileDisk())->put($path, $file);
            }

            if ($previous) {
                $this->destroyFileWithoutUpdateCompany($previous);
            }
        });
    }

    public function getFileData(InternShip $internShip): ?FileData
    {
        if (empty($internShip->file_associated_name) || empty($internShip->file_associated_uuid)) {
            return null;
        }

        return FileData::from([
            'file_id' => $internShip->id,
            'source' => $internShip->file_associated_name,
            'server_id' => $internShip->file_associated_uuid,
        ]);
    }

    public function destroyFile(InternShip $internShip): void
    {
        $this->destroyFileWithoutUpdateCompany($internShip->file_associated_path);

        $internShip->update([
            'file_associated_path' => null,
            'file_associated_name' => null,
            'file_associated_uuid' => null,
        ]);

        $internShip->ensureLeftEmptyDirectoriesAreDeleted();
    }

    public function destroyFileWithoutUpdateCompany(?string $path = null): void
    {
        $disk = InternShip::relatedFileDisk();

        if (is_null($path)) {
            return;
        }
        Storage::disk($disk)->delete($path);
    }

    /**
     * @return array<string, mixed>
     */
    public function loadForDisplay(InternShip $internShip)
    {
        $FileData = $this->getFileData($internShip);

        return array_merge(
            $internShip->toArray(),
            [
                'fileData' => $FileData ? [$FileData] : [],
            ]
        );
    }
}
