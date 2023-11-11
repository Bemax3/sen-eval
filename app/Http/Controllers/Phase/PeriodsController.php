<?php

namespace App\Http\Controllers\Phase;

use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Phase\SavePhasePeriodRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase\EvaluationPeriod;
use App\Models\Phase\Phase;
use App\Services\Phase\PeriodService;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class PeriodsController extends Controller
{
    public function __construct(private readonly PeriodService $periodService)
    {
    }

    public function show(string $id)
    {
        try {
            $phase = Phase::findOrFail($id);
            return Inertia::render('Phase/PhasePeriods', [
                'phase' => $phase,
                'periods' => $phase->periods()->paginate(10)
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePhasePeriodRequest $request)
    {
        try {
            $this->periodService->create($request->validated());
            alert_success('Période ajoutée avec succès.');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            return Inertia::render('Phase/SavePhasePeriod', [
                'phase' => Phase::findOrFail($request->get('phase')),
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $period = EvaluationPeriod::findOrFail($id);
            return Inertia::render('Phase/SavePhasePeriod', [
                'phase' => Phase::findOrFail($period->phase_id),
                'period' => $period
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePhasePeriodRequest $request, string $id)
    {
        try {
            $this->periodService->update($request->validated(), $id);
            alert_success('Période modifié avec succès.');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {

            $this->periodService->delete($id);
            alert_success('Période supprimée avec succès.');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
        } finally {
            redirect()->back();
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(EvaluationPeriod::class, function (ModelSearchAspect $aspect) use ($data) {
                    foreach ($data['fields'] as $field) {
                        $aspect->addSearchableAttribute($field);
                    }
                    $aspect->whereRelation('phase', 'phase_id', '=', $data['phase_id']);
                })
                ->search($data['keyword']);
            $result = [];
            foreach ($searchResults as $sr) {
                $result[] = $sr->searchable;
            }
            return response()->json($result);
        } catch (Exception) {
            return response()->json();
        }
    }
}
