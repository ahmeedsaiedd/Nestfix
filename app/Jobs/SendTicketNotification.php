<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\SendReminderEmail;

class SendTicketNotification implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @param array $details
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Send the email
        Mail::to('Ahmeedsaiedd@gmail.com')->send(new SendReminderEmail($this->details));
    }
}
