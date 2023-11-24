<?php

namespace App\Mail;

use App\Models\Rating\Rating;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ValidatedRating extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Rating $rating)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Validated Rating',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.validation',
            with: [
                'evaluated_name' => $this->rating->evaluated->user_display_name,
                'year' => $this->rating->phase->phase_year,
                'rating_id' => $this->rating->rating_id,
                'validated_at' => $this->rating->validated_at,
            ]
        );
    }


}
