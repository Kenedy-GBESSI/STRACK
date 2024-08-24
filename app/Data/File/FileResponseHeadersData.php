<?php

declare(strict_types=1);

namespace App\Data\File;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class FileResponseHeadersData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $content_disposition,
        #[Required, StringType]
        public string $content_type,
        #[Required, StringType]
        public string $connection = 'Keep-Alive',
        #[Required, StringType]
        public string $access_control_expose_headers = 'Content-Disposition, Content-Length, X-Content-Transfer-Id'
    ) {}

    public function toArray(): array
    {
        return [
            'Access-Control-Expose-Headers' => $this->access_control_expose_headers,
            'Content-Disposition' => $this->content_disposition,
            'Content-Type' => $this->content_type,
            'Connection' => $this->connection,
        ];
    }
}
