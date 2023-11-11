<?php

namespace App\Services\Rating;

use App\Models\Rating\Mobility;

class MobilityService
{
    public function create($validated, $rating_id): void
    {
        $mobility = Mobility::create([
            'rating_id' => $rating_id,
            'mobility_type_id' => $validated['mobility_type_id'],
            'rating_mobility_title' => $validated['rating_mobility_title'],
            'rating_mobility_comment' => $validated['rating_mobility_comment'],
            'asked_by' => $validated['asked_by']
        ]);
    }

    public function update($validated, $mobility_id): void
    {
        $mobility = Mobility::findOrFail($mobility_id);
        $mobility->update([
            'mobility_type_id' => $validated['mobility_type_id'],
            'rating_mobility_title' => $validated['rating_mobility_title'],
            'rating_mobility_comment' => $validated['rating_mobility_comment'],
        ]);
    }

    public function delete(string $mobility_id): void
    {
        Mobility::findOrFail($mobility_id)->delete();
    }
}
