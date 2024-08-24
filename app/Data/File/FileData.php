<?php

declare(strict_types=1);

namespace App\Data\File;

use Illuminate\Support\Optional;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class FileData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $server_id,
        #[Nullable, StringType]
        public ?string $id,
        #[Nullable, StringType]
        public ?string $source,
        #[Nullable, IntegerType, Numeric]
        public null|Optional|int $file_id,
        #[Nullable]
        public ?FileOptionData $options = new FileOptionData('limbo'),
    ) {}
}
