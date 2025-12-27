<?php

namespace App\Listeners;

use App\Events\InquiryCreated;
use App\Mail\InquiryNotification;
use App\Jobs\SendInquiryNotification as SendInquiryNotificationJob;
use App\Models\Setting;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInquiryNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InquiryCreated $event): void
    {
        $inquiry = $event->inquiry;

        // Dispatch the job
        SendInquiryNotificationJob::dispatch($inquiry);

    }
}
