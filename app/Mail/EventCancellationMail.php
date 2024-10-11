<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventCancellationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $cancellationMesssage;
    public $subject;
    public $eventDetails;
    public function __construct($subject, $cancellationMesssage, $event)
    {
        $this->subject = $subject;
        $this->cancellationMesssage = $cancellationMesssage;
        $this->eventDetails = $event;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject ?? 'Event Cancellation Notice',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.event-cancellation-template',
        );
    }
    public function build()
    {
        return $this->subject($this->subject)
            ->view('mail.event-cancellation-template') // Ensure you have a corresponding view
            ->with([
                'cancellationMesssage' => $this->cancellationMesssage,
                'programDetails' => $this->eventDetails
            ]);
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
