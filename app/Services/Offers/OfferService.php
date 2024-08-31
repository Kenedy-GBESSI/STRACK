<?php

declare(strict_types=1);

namespace App\Services\Offers;

use App\Data\File\FileData;
use App\Models\Offer;
use Illuminate\Support\Facades\Storage;
use Sopamo\LaravelFilepond\Filepond;

/**
 * Class OfferService
 */
class OfferService
{
      /**
     * Save or Update a picture of offer
     *
     * @return void
     */
    public function saveFile(Offer $offer, FileData $fileData, ?string $subStoragePath = null)
    {
        if (! is_null($fileData->file_id)) {
            return;
        }

        tap($offer->file_associated_path, function ($previous) use ($offer, $fileData, $subStoragePath) {

            $filepond = app(Filepond::class);
            $filePondPath = $filepond->getPathFromServerId($fileData->server_id);
            $filePondPath = str_replace('\\', '/', $filePondPath);
            $filePondPathParts = explode('/', $filePondPath);

            $fileName = $offer->createFileName(end($filePondPathParts));
            $path = $offer->createCustomPath($subStoragePath, $fileName);

            $offer->update([
                'file_associated_path' => $path,
                'file_associated_name' => $fileName,
                'file_associated_uuid' => $fileData->server_id,
            ]);

            $file = Storage::get($filePondPath);
            if (! empty($file)) {
                Storage::disk(Offer::relatedFileDisk())->put($path, $file);
            }

            if ($previous) {
                $this->destroyFileWithoutUpdateCompany($previous);
            }
        });
    }

    public function getFileData(Offer $offer): ?FileData
    {
        if (empty($offer->file_associated_name) || empty($offer->file_associated_uuid)) {
            return null;
        }

        return FileData::from([
            'file_id' => $offer->id,
            'source' => $offer->file_associated_name,
            'server_id' => $offer->file_associated_uuid,
        ]);
    }

    public function destroyFile(Offer $offer): void
    {
        $this->destroyFileWithoutUpdateCompany($offer->file_associated_path);

        $offer->update([
            'file_associated_path' => null,
            'file_associated_name' => null,
            'file_associated_uuid' => null,
        ]);

        $offer->ensureLeftEmptyDirectoriesAreDeleted();
    }

    public function destroyFileWithoutUpdateCompany(?string $path = null): void
    {
        $disk = Offer::relatedFileDisk();

        if (is_null($path)) {
            return;
        }
        Storage::disk($disk)->delete($path);
    }

    /**
     * @return array<string, mixed>
     */
    public function loadForDisplay(Offer $offer)
    {
        $offer->loadMissing('internShip');
        
        $FileData = $this->getFileData($offer);

        return array_merge(
            $offer->toArray(),
            [
                'fileData' => $FileData ? [$FileData] : [],
                'intern_ship' => $offer->internShip,
            ]
        );
    }

}
