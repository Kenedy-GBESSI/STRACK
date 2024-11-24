<?php

declare(strict_types=1);

namespace App\Services\Mail;

use App\Data\Mail\MailjetEmailBodyData;
use Illuminate\Support\Facades\Http;
use App\Models\Student;

/**
 * Class MailService
 */
class MailService
{
    /**
     * For MailJet driver
     */
    public function sendEmailsForCompanies($emailList = [], Student $student): bool
    {
        $student->load('user');

        if (empty($emailList)) {
            return false;
        }

        $body = new MailjetEmailBodyData(
            fromName: config('mail.from.name'),
            fromEmail: config('mail.from.address'),
            emails: $emailList,
            subject: "Réponse à l'offre de stage obtenue",
            htmlPart: view('emails.form-companies', ['student' => $student->user])->render(),
        );

        $response = Http::withBasicAuth(
            config('services.mailjet.key'),
            config('services.mailjet.secret')
        )->post('https://api.mailjet.com/v3.1/send', $body->toApiArray());

        return $response->successful();
    }

}
