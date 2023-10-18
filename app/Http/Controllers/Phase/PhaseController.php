<?php

namespace App\Http\Controllers\Phase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Phase\SavePhaseRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase;
use Carbon\Carbon;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Phase/PhasesList', [
            'phases' => Phase::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Phase/SavePhase');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePhaseRequest $request)
    {
        try {
            $data = $request->validated();
            Phase::create([
                'phase_name' => $data['phase_name'],
                'phase_year' => strval(Carbon::createFromDate($data['phase1'][0])->year),
                'phase_first_eval_start' => Carbon::createFromDate($data['phase1'][0])->toDateTimeString(),
                'phase_first_eval_end' => Carbon::createFromDate($data['phase1'][1])->toDateTimeString(),
                'phase_second_eval_start' => Carbon::createFromDate($data['phase2'][0])->toDateTimeString(),
                'phase_second_eval_end' => Carbon::createFromDate($data['phase2'][1])->toDateTimeString(),
            ]);
            alert_success('Phase crée avec succès.');
        } catch (Exception $e) {
            alert_error('Erreur lors de la création de cette phase.');
        } finally {
            return redirect()->route('phases.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Phase/SavePhase', [
            'phase' => Phase::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePhaseRequest $request, string $id)
    {
        try {
            $phase = Phase::findOrFail($id);
            $data = $request->validated();
            $phase->update([
                'phase_name' => $data['phase_name'],
                'phase_year' => strval(Carbon::createFromDate($data['phase1'][0])->year),
                'phase_first_eval_start' => Carbon::createFromDate($data['phase1'][0])->toDateTimeString(),
                'phase_first_eval_end' => Carbon::createFromDate($data['phase1'][1])->toDateTimeString(),
                'phase_second_eval_start' => Carbon::createFromDate($data['phase2'][0])->toDateTimeString(),
                'phase_second_eval_end' => Carbon::createFromDate($data['phase2'][1])->toDateTimeString()
            ]);
            alert_success('Phase modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de cette phase.');
        } finally {
            return redirect()->route('phases.edit', ['phase' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Phase::findOrFail(intval($id))->delete();
            alert_success('Phase supprimée avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la suppression de cette phase.');
        } finally {
            redirect()->route('phases.index');
        }
    }


    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(Phase::class, $data['fields'])
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
