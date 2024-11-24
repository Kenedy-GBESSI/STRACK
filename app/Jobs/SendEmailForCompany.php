<?php

namespace App\Jobs;

use App\Models\Student;
use App\Services\Mail\MailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailForCompany implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Student $student;
    public $emailList = [];

    /**
     * Create a new job instance.
     */
    public function __construct(
        Student $student,
        $emailList = []
    ) {
        $this->student = $student->withoutRelations();
        $this->emailList = $emailList;
    }

    /**
     * Execute the job.
     */
    public function handle(MailService $mailService): void
    {
        $mailService->sendEmailsForCompanies($this->emailList, $this->student);
    }
}
