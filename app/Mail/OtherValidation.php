<?php

namespace App\Mail;

use App\Models\Rating\Rating;
use App\Models\Rating\Validator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtherValidation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Rating $rating, public Validator $validator, public Validator $other)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle validation sur une évaluation de votre agent.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.other-validation',
            with: [
                'evaluated_name' => $this->rating->evaluated->user_display_name,
                'year' => $this->rating->phase->phase_year,
                'rating_id' => $this->rating->rating_id,
                'validator_name' => $this->validator->user->user_display_name,
                'validated_at' => $this->validator->validated_at,
                'other_validator_name' => $this->other->user->user_display_name,
                'evaluator_id' => $this->rating->evaluator->user_id,
                'evaluated_id' => $this->rating->evaluated->user_id,
                'other_validator_id' => $this->other->user->user_id,
            ]
        );
    }
}
