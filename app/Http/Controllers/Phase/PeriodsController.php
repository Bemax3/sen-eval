<?php

namespace App\Http\Controllers\Phase;

use App\Http\Controllers\Controller;
use App\Models\Phase\Phase;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PeriodsController extends Controller
{
    public function show(string $id)
    {
        $phase = Phase::findOrFail($id);
        return Inertia::render('Phase/PhasePeriods',[
            'phase' => $phase,
            'periods' => $phase->periods()->paginate(10)
        ]);
    }
}
