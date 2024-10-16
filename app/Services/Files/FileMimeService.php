<?php

declare(strict_types=1);

namespace App\Services\Files;

use App\Data\File\FileData;
use App\Data\File\FileResponseHeadersData;
use Illuminate\Support\Str;
use Sopamo\LaravelFilepond\Filepond;

/**
 * Class FileMimeService
 */
class FileMimeService
{
    /**
     * @return array<string, string>
     */
    public static function mimeMap()
    {
        return [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
        ];
    }

    /**
     * Get appropriate mime for specified extension
     *
     * @param  mixed  $mime
     * @return string|false
     */
    public static function mime2ext($mime)
    {
        return self::mimeMap()[$mime] ?? false;
    }

    /**
     * Get response's headers
     *
     * @return null|FileResponseHeadersData
     */
    public static function getResponseHeaders(mixed $file)
    {
        $filepond = app(Filepond::class);
        $name = '';
        $path = '';

        if (isset($file->uuid)) {

            if (! $file->uuid || ! isset($file->name)) {
                return null;
            }
            $path = config('app.filepond_path_url') . $filepond->getPathFromServerId($file->uuid);
            $name = Str::slug($file->name);

        } else {

            if (empty($file->file_associated_name) || empty($file->file_associated_path)) {
                return null;
            }
            $path = $file->file_associated_path;
            $name = Str::slug($file->file_associated_name);
        }

        $tmp = explode('.', $path);
        $file_extension = end($tmp);

        return FileResponseHeadersData::from([
            'content_disposition' => 'inline; filename="' . $name . '"',
            'content_type' => self::mime2ext($file_extension),
        ]);

    }

    public function getPath(FileData $fileData): string
    {
        $filepond = app(Filepond::class);

        return $filepond->getPathFromServerId($fileData->server_id);
    }
}
