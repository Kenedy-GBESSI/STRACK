<?php

namespace App\Data\Mail;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class MailjetEmailAttachmentData extends Data
{
    public function __construct(
        #[Required, StringType]
        public string $ContentType,
        #[Required, StringType]
        public string $Filename,
        #[Required, StringType]
        public string $Base64Content,
    ) {}
}
