<?php

namespace App\Http\Controllers\Phase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Phase\SavePhasePeriodRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase\EvaluationPeriod;
use App\Models\Phase\Phase;
use App\Models\Settings\PeriodType;
use App\Models\Settings\Skill;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class PeriodsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('Phase/SavePhasePeriod',[
            'phase' => Phase::findOrFail($request->get('phase')),
        ]);
    }

    public function show(string $id)
    {
        $phase = Phase::findOrFail($id);
        return Inertia::render('Phase/PhasePeriods',[
            'phase' => $phase,
            'periods' => $phase->periods()->paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePhasePeriodRequest $request)
    {
        try {
            $data = $request->validated();
            $phase = Phase::findOrFail($data['phase_id']);
            $phase->periods()->create([
                'evaluation_period_start' => Carbon::createFromDate($data['evaluation_period_start'])->toDateTimeString(),
                'evaluation_period_end' => Carbon::createFromDate($data['evaluation_period_end'])->toDateTimeString()
            ]);
            alert_success('Période ajoutée avec succès.');
        }catch (Exception) {
            alert_error('Erreur lors de l\'enregistrement de la période');
        } finally {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $period = EvaluationPeriod::findOrFail($id);
        return Inertia::render('Phase/SavePhasePeriod', [
            'phase' => Phase::findOrFail($period->phase_id),
            'period' => $period
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePhasePeriodRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $phase = Phase::findOrFail($data['phase_id']);
            $phase->periods()->findOrFail(intval($id))
                ->update([
                'evaluation_period_start' => Carbon::createFromDate($data['evaluation_period_start'])->toDateTimeString(),
                'evaluation_period_end' => Carbon::createFromDate($data['evaluation_period_end'])->toDateTimeString(),
                'updated_by' => $data['updated_by']
            ]);
            alert_success('Période modifié avec succès.');
        }catch (Exception) {
            alert_error('Erreur lors de l\'enregistrement de la période');
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
            EvaluationPeriod::findOrFail(intval($id))->delete();
            alert_success('Période supprimée avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la suppression de cette période.');
        } finally {
            redirect()->back();
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(EvaluationPeriod::class, function  (ModelSearchAspect $aspect) use($data) {
                    foreach ($data['fields'] as $field) {
                        $aspect->addSearchableAttribute($field);
                    }
                    $aspect->whereRelation('phase','phase_id','=',$data['phase_id']);
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
