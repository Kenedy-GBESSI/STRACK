<?php

namespace App\Data\Company;

use App\Enums\PartnershipStatus;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CompanyData extends Data
{
    public string $partnership_status;

    public function __construct(
        public readonly int|Optional $id,
        #[Required, Max(255), StringType]
        public readonly string $company_name,
        #[Nullable, StringType]
        public readonly string|Optional|null $phone_number,
        #[Required, Max(255), StringType]
        public readonly ?string $address,
        #[Nullable, Max(255), StringType]
        public readonly ?string $website,
        #[Nullable, StringType]
        public readonly ?string $description,
        #[Nullable, StringType]
        public readonly ?string $service,
    ) {
        $this->partnership_status = PartnershipStatus::NEW_PARTNERSHIP->value;
    }
}
