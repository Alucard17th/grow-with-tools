<?php

namespace App\Console\Commands;

use App\Models\Lead;
use App\Services\EmailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailsToLeads extends Command
{
    protected $signature = 'leads:send-emails';
    protected $description = 'Send emails to all leads';

    private $emailService;

    public function __construct(EmailService $emailService)
    {
        parent::__construct();
        $this->emailService = $emailService;
    }

    public function handle()
    {
        $leads = Lead::where('status', 'queued')->get(); // Get all leads with status 'queued'

        foreach ($leads as $lead) {
            $emailContent = $this->emailService->generateEmailContent($lead);

            try {
                // Send the email using Laravel's Mail facade
                Mail::raw($emailContent['content'], function ($message) use ($lead, $emailContent) {
                    $message->to($lead->email)
                            ->subject($emailContent['subject']);
                });

                // Update the lead status to 'sent'
                $lead->update(['status' => 'sent']);

                $this->info("Email sent to {$lead->email}");

                sleep(2); // wait 2 seconds between sends
            } catch (\Exception $e) {
                // If an error occurs, update the lead status and store the error message
                $lead->update(['status' => 'failed', 'error' => $e->getMessage()]);
                $this->error("Failed to send email to {$lead->email}: {$e->getMessage()}");
            }
        }

        $this->info('Emails sent to all leads!');
    }
}

