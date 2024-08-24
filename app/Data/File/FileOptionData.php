<?php

declare(strict_types=1);

namespace App\Data\File;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class FileOptionData extends Data
{
    public function __construct(
        #[Required, StringType, Max(255)]
        public string $type = 'limbo',
    ) {}
}
