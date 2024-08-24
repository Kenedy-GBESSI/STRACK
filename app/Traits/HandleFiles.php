<?php

namespace App\Traits;

use App\Data\File\FileData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use League\Flysystem\WhitespacePathNormalizer;
use ReflectionClass;
use Sopamo\LaravelFilepond\Filepond;

trait HandleFiles
{
    abstract public static function getRelatedFilesSubFolder();

    abstract public static function relatedFileDisk();

    /**
     * @param  array<mixed, mixed>  $files
     * @return void
     */
    public function saveFiles(array $files, ?string $subStoragePath = null)
    {
        foreach ($files as $file) {
            $this->insertFile($file, $subStoragePath);
        }
    }

    /**
     * @return \Illuminate\Support\Collection<int, mixed>.
     */
    public function getFilesForFilepond()
    {
        // @phpstan-ignore-next-line
        return $this->files->map(function ($file) {
            return FileData::from([
                'server_id' => $file['uuid'],
                'file_id' => $file['id'],
                'source' => $file['name'],
            ])->toArray();
        });
    }

    /**
     * @param  array<mixed, mixed>  $files
     * @return void
     */
    public function updateFiles(array $files, ?string $subStoragePath = null)
    {
        $this->deleteUnusedFiles($files, $subStoragePath);

        foreach ($files as $file) {
            if (! array_key_exists('file_id', $file)) {
                $this->insertFile($file, $subStoragePath);
            }
        }
    }

    public function deleteFiles(?string $subStoragePath = null): void
    {
        $klass = $this->getKlass();

        $allFiles = DB::table($klass . '_files')->where([
            $klass . '_id' => $this->id,
        ])->get();

        foreach ($allFiles as $file) {
            $this->deleteOneFile($file->path, $file->id);
        }

        $this->ensureLeftEmptyDirectoriesAreDeleted($subStoragePath);
    }

    /**
     * @param  array<mixed, mixed>  $file
     */
    public function insertFile(array $file, ?string $subStoragePath = null): void
    {
        $klass = $this->getKlass();
        $path = $this->getFilePondPath($file['server_id']);
        $values = explode('/', $path);

        $fileName = $this->createFileName(end($values));
        $realPath = $this->createCustomPath($subStoragePath, $fileName);

        DB::table($klass . '_files')->insert([
            $klass . '_id' => $this->id,
            'path' => $realPath,
            'uuid' => $file['server_id'],
            'small_uuid' => $values[1],
            'name' => $fileName,
        ]);

        $contents = Storage::get($path);
        if (! empty($contents)) {
            Storage::disk(static::relatedFileDisk())->put($realPath, $contents);
        }

    }

    public function getKlass(): string
    {
        $klass = (new ReflectionClass($this))->getShortName();

        return Str::snake($klass);
    }

    /**
     * @param  array<mixed, mixed>  $filesToKeep
     */
    public function deleteUnusedFiles(array $filesToKeep, ?string $subStoragePath = null): void
    {
        $fileIds = [];

        foreach ($filesToKeep as $file) {
            if (array_key_exists('file_id', $file)) {
                array_push($fileIds, $file['file_id']);
            }
        }

        $klass = $this->getKlass();

        $allFilesToDelete = DB::table($klass . '_files')->where([
            $klass . '_id' => $this->id,
        ])->whereNotIn('id', $fileIds)->get();

        foreach ($allFilesToDelete as $file) {
            $this->deleteOneFile($file->path, $file->id);
        }

        $this->ensureLeftEmptyDirectoriesAreDeleted($subStoragePath);
    }

    public function getFilePondPath(string $serverId): string
    {
        $filepond = app(Filepond::class);

        $filePondPath = $filepond->getPathFromServerId($serverId);

        return str_replace('\\', '/', $filePondPath);
    }

    public function deleteOneFile(string $path, int $id): void
    {
        $disk = static::relatedFileDisk();
        $klass = $this->getKlass();

        Storage::disk($disk)->delete($path);

        DB::table($klass . '_files')->where([
            'id' => $id,
        ])->delete();
    }

    public function ensureLeftEmptyDirectoriesAreDeleted(?string $subStoragePath = null): void
    {
        $fileDirectory = $this->makeRelatedFileDirectoryName($subStoragePath);

        $disk = static::relatedFileDisk();

        $anyOtherPhotoDirectoryFiles = Storage::disk($disk)->allFiles($fileDirectory);
        $subDirectories = Storage::disk($disk)->allDirectories($fileDirectory);

        // delete the photo directory if it's empty
        if (collect($anyOtherPhotoDirectoryFiles)->isEmpty() && collect($subDirectories)->isEmpty()) {
            Storage::disk($disk)->deleteDirectory($fileDirectory);
        }
    }

    /**
     * @throws InvalidArgumentException
     */
    public function createFileName(string $fileName): string
    {
        $fileNameParts = explode('.', $fileName);
        $extension = end($fileNameParts);

        $name = Str::of($fileName)->before($extension)->value();

        if (! $name) {
            throw new InvalidArgumentException('The provided name, to create the file\'s name, cannot be blank.');
        }

        return Str::random(40) . '-'
            . Str::slug((new WhitespacePathNormalizer)->normalizePath($name)) . '.'
            . $extension;
    }

    public function createSubFolderName(?string $subStoragePath = null): string
    {
        if (is_null($subStoragePath)) {
            $subStoragePath = static::getRelatedFilesSubFolder();
        }

        if (! Str::endsWith($subStoragePath, '/')) {
            $subStoragePath .= '/';
        }

        return $subStoragePath;
    }

    public function createCustomPath(?string $subStoragePath, string $fileName): string
    {
        return $this->makeRelatedFileDirectoryName($subStoragePath) . '/' . $fileName;
    }

    public function makeRelatedFileDirectoryName(?string $subStoragePath): string
    {
        return $this->createSubFolderName($subStoragePath) . $this->id;
    }
}
