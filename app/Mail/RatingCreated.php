<?php

namespace App\Mail;

use App\Models\Rating\Rating;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RatingCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Rating $rating)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vous avez une nouvelle évaluation.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.new-rating',
            with: [
                'evaluated_name' => $this->rating->evaluated->user_display_name,
                'evaluator_name' => $this->rating->evaluator->user_display_name,
                'year' => $this->rating->phase->phase_year,
                'rating_id' => $this->rating->rating_id
            ]
        );
    }

}
