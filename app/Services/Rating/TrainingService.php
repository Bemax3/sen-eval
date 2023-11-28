<?php

namespace App\Services\Rating;

use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Models\Rating\Rating;
use App\Models\Rating\Training;

class TrainingService
{
    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function create($validated, $rating_id): void
    {
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($rating_id))) throw new CantUpdateValidatedRatingException();
        $training = Training::where('training_type_id', '=', $validated['training_type_id'])->where('rating_id', '=', $rating_id)->first();
        if (!$training)
            $training = Training::create([
                'rating_id' => $rating_id,
                'training_type_id' => $validated['training_type_id'],
            ]);
        $this->updateExistingFields($training, $validated);

    }

    private function updateExistingFields($training, $data): void
    {
        if (isset($data['asked_by_evaluator'])) {
            $training->update(['asked_by_evaluator' => $data['asked_by_evaluator'] == 1 ? $data['asked_by_evaluator'] : NULL]);
            if (isset($data['comment'])) $training->update(['evaluator_comment' => $data['comment']]);
        }
        if (isset($data['asked_by_evaluated'])) {
            $training->update(['asked_by_evaluated' => $data['asked_by_evaluated'] == 1 ? $data['asked_by_evaluated'] : NULL]);
            if (isset($data['comment'])) $training->update(['evaluated_comment' => $data['comment']]);
        }
    }

    /**
     * @throws CantUpdateValidatedRatingException
     */
    public function update($validated, $training_id): void
    {
        $training = Training::findOrFail($training_id);
        if ((new ValidatorService())->checkForAllValidation(Rating::findOrFail($training->rating_id))) throw new CantUpdateValidatedRatingException();
        $this->updateExistingFields($training, $validated);
        if (!$training->asked_by_evaluator) $training->update(['evaluator_comment' => '']);
        if (!$training->asked_by_evaluated) $training->update(['evaluated_comment' => '']);
        if (!$training->asked_by_evaluated && !$training->asked_by_evaluator) $training->delete();
    }
}
