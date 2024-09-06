<?php

declare(strict_types=1);

namespace App\Services\Candidacy;

use App\Models\Candidacy;
use App\Data\File\FileData;
use Illuminate\Support\Facades\Storage;
use Sopamo\LaravelFilepond\Filepond;

/**
 * Class CandidacyService
 */
class CandidacyService
{
      /**
     * Save or Update a picture of candidacy
     *
     * @return void
     */
    public function saveFile(Candidacy $candidacy, FileData $fileData, ?string $subStoragePath = null)
    {
        if (! is_null($fileData->file_id)) {
            return;
        }

        tap($candidacy->file_associated_path, function ($previous) use ($candidacy, $fileData, $subStoragePath) {

            $filepond = app(Filepond::class);
            $filePondPath = $filepond->getPathFromServerId($fileData->server_id);
            $filePondPath = str_replace('\\', '/', $filePondPath);
            $filePondPathParts = explode('/', $filePondPath);

            $fileName = $candidacy->createFileName(end($filePondPathParts));
            $path = $candidacy->createCustomPath($subStoragePath, $fileName);

            $candidacy->update([
                'file_associated_path' => $path,
                'file_associated_name' => $fileName,
                'file_associated_uuid' => $fileData->server_id,
            ]);

            $file = Storage::get($filePondPath);
            if (! empty($file)) {
                Storage::disk(Candidacy::relatedFileDisk())->put($path, $file);
            }

            if ($previous) {
                $this->destroyFileWithoutUpdateCompany($previous);
            }
        });
    }

    public function getFileData(Candidacy $candidacy): ?FileData
    {
        if (empty($offer->file_associated_name) || empty($offer->file_associated_uuid)) {
            return null;
        }

        return FileData::from([
            'file_id' => $candidacy->id,
            'source' => $candidacy->file_associated_name,
            'server_id' => $candidacy->file_associated_uuid,
        ]);
    }

    public function destroyFile(Candidacy $candidacy): void
    {
        $this->destroyFileWithoutUpdateCompany($candidacy->file_associated_path);

        $candidacy->update([
            'file_associated_path' => null,
            'file_associated_name' => null,
            'file_associated_uuid' => null,
        ]);

        $candidacy->ensureLeftEmptyDirectoriesAreDeleted();
    }

    public function destroyFileWithoutUpdateCompany(?string $path = null): void
    {
        $disk = Candidacy::relatedFileDisk();

        if (is_null($path)) {
            return;
        }
        Storage::disk($disk)->delete($path);
    }

}
