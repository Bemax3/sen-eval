<?php

namespace App\Http\Controllers\Phase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Phase\SavePhaseRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase\Phase;
use App\Models\Settings\PeriodType;
use App\Services\Phase\PhaseService;
use Carbon\Carbon;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class PhaseController extends Controller
{

    public function __construct(private readonly PhaseService $phaseService){}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Inertia::render('Phase/PhasesList', [
                'phases' => Phase::paginate(10)
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return Inertia::render('Phase/SavePhase',[
                'types' => PeriodType::all()
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SavePhaseRequest $request)
    {
        try {
            $this->phaseService->create($request->validated());
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
        try {
            return Inertia::render('Phase/SavePhase', [
                'phase' => Phase::findOrFail($id),
                'types' => PeriodType::all()
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePhaseRequest $request, string $id)
    {
        try {
            $this->phaseService->update(intval($id),$request->validated());
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
            $this->phaseService->destroy(intval($id));
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
