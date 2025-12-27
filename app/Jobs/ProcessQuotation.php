<?php

namespace App\Jobs;

use App\Mail\QuotationCreated;
use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessQuotation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $quotationData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $quotationData)
    {
        $this->quotationData = $quotationData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $inquiry = Inquiry::findOrFail($this->quotationData['inquiry_id']);

        $userEmail = $inquiry->customerUser->email;
        Mail::to($userEmail)->send(new QuotationCreated($inquiry));
    }
}