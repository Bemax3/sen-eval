<?php

namespace App\Mail;

use App\Models\Rating\Rating;
use App\Models\Rating\Validator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RatingValidatedBy extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Rating $rating, public Validator $validator)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle validation sur votre évaluation.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.new-validation',
            with: [
                'evaluated_name' => $this->rating->evaluated->user_display_name,
                'year' => $this->rating->phase->phase_year,
                'rating_id' => $this->rating->rating_id,
                'validator_name' => $this->validator->user->user_display_name,
                'validated_at' => $this->validator->validated_at,
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
