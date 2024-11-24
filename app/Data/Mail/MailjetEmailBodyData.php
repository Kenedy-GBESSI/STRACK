<?php

namespace App\Data\Mail;

use Spatie\LaravelData\Data;

class MailjetEmailBodyData extends Data
{
      /**
     * @param  array<int,null|string>  $emails
     * @param  array<MailjetEmailAttachmentData>  $attachments
     */
    public function __construct(
        public string $fromEmail = '',
        public string $fromName = '',
        public array $emails = [],
        public string $subject = '',
        public string $textPart = '',
        public string $htmlPart = '',
        public array $attachments = [],
    ) {}

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $data = [
            'Recipients' => collect($this->emails)
                ->map(fn ($email) => ['Email' => $email])
                ->toArray(),
            'Subject' => $this->subject,
            'Text-part' => $this->textPart,
            'Html-part' => $this->htmlPart,
        ];

        if (! empty($this->fromEmail)) {
            $data['FromEmail'] = $this->fromEmail;
        }

        if (! empty($this->fromName)) {
            $data['FromName'] = $this->fromName;
        }

        if (! empty($this->attachments)) {
            $data['attachments'] = collect($this->attachments)->map(fn ($attachmentData) => $attachmentData->toArray())->toArray();
        }

        return ['body' => $data];
    }

    /**
     * @return array<string,mixed>
     */
    public function toApiArray(): array
    {
        $data = [
            'To' => collect($this->emails)
                ->map(fn ($email) => ['Email' => $email])
                ->toArray(),
            'From' => [
                'Email' => $this->fromEmail,
                'Name' => $this->fromName,
            ],
            'Subject' => $this->subject,
            'TextPart' => $this->textPart,
            'HtmlPart' => $this->htmlPart,
        ];

        if (! empty($this->attachments)) {
            $data['Attachments'] = collect($this->attachments)->map(fn ($attachmentData) => $attachmentData->toArray())->toArray();
        }

        return ['Messages' => [$data]];
    }
}
