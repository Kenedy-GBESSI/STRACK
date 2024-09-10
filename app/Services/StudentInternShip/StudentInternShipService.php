<?php

declare(strict_types=1);

namespace App\Services\StudentInternShip;

use App\Models\StudentInternShip;
use App\Data\File\FileData;
use Illuminate\Support\Facades\Storage;
use Sopamo\LaravelFilepond\Filepond;

/**
 * Class StudentInternShipService
 */
class StudentInternShipService
{
     /**
     * Save or Update a picture of candidacy
     *
     * @return void
     */
    public function saveFile(StudentInternShip $studentInternShip, FileData $fileData, ?string $subStoragePath = null)
    {
        if (! is_null($fileData->file_id)) {
            return;
        }

        tap($studentInternShip->file_associated_path, function ($previous) use ($studentInternShip, $fileData, $subStoragePath) {

            $filepond = app(Filepond::class);
            $filePondPath = $filepond->getPathFromServerId($fileData->server_id);
            $filePondPath = str_replace('\\', '/', $filePondPath);
            $filePondPathParts = explode('/', $filePondPath);

            $fileName = $studentInternShip->createFileName(end($filePondPathParts));
            $path = $studentInternShip->createCustomPath($subStoragePath, $fileName);

            $studentInternShip->update([
                'file_associated_path' => $path,
                'file_associated_name' => $fileName,
                'file_associated_uuid' => $fileData->server_id,
            ]);

            $file = Storage::get($filePondPath);
            if (! empty($file)) {
                Storage::disk(StudentInternShip::relatedFileDisk())->put($path, $file);
            }

            if ($previous) {
                $this->destroyFileWithoutUpdateCompany($previous);
            }
        });
    }

    public function getFileData(StudentInternShip $studentInternShip): ?FileData
    {
        if (empty($studentInternShip->file_associated_name) || empty($studentInternShip->file_associated_uuid)) {
            return null;
        }

        return FileData::from([
            'file_id' => $studentInternShip->id,
            'source' => $studentInternShip->file_associated_name,
            'server_id' => $studentInternShip->file_associated_uuid,
        ]);
    }

    public function destroyFile(StudentInternShip $studentInternShip): void
    {
        $this->destroyFileWithoutUpdateCompany($studentInternShip->file_associated_path);

        $studentInternShip->update([
            'file_associated_path' => null,
            'file_associated_name' => null,
            'file_associated_uuid' => null,
        ]);

        $studentInternShip->ensureLeftEmptyDirectoriesAreDeleted();
    }

    public function destroyFileWithoutUpdateCompany(?string $path = null): void
    {
        $disk = StudentInternShip::relatedFileDisk();

        if (is_null($path)) {
            return;
        }
        Storage::disk($disk)->delete($path);
    }

}
