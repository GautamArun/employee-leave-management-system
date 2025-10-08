<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveStatusChange extends Mailable
{
    use Queueable, SerializesModels;

    protected $leave;

    /**
     * Create a new message instance.
     */
    public function __construct($leave)
    {
        $this->leave = $leave;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address("gautam.ad321@gmail.com", "Gautam"),
            subject: 'Leave Status',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mails.LeaveFormat',
            with: [
                'start_date' => $this->leave['start_date'],
                'end_date' => $this->leave['end_date'],
                'leave_status' => $this->leave['status'],
            ]
        );
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
