<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    
    /**
     * Create a new message instance.
     */
    public function __construct($inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        $subject = "Your inquiry {$this->inquiry->referenceNo->reference_no} has been created";
        
        return $this->subject($subject)
                    ->markdown('mail.inquirygenerated');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
