<?php

namespace App\Http\Controllers\Phase;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Phase\PhaseAlreadyExistException;
use App\Exceptions\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Phase\SavePhaseRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase\Phase;
use App\Models\Settings\PeriodType;
use App\Services\Phase\PhaseService;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class PhaseController extends Controller
{

    public function __construct(private readonly PhaseService $phaseService)
    {
    }

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
     * Store a newly created resource in storage.
     */
    public function store(SavePhaseRequest $request)
    {
        try {
            $this->phaseService->create($request->validated());
            alert_success('Phase crée avec succès.');
        } catch (PhaseAlreadyExistException|UnknownException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->route('phases.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Phase/SavePhase', [
            'types' => PeriodType::all()
        ]);
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
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SavePhaseRequest $request, string $id)
    {
        try {
            $this->phaseService->update(intval($id), $request->validated());
            alert_success('Phase modifié avec succès.');
        } catch (PhaseAlreadyExistException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->route('phases.edit', ['phase' => $id]);
        }
    }

    public function updateStatus(SavePhaseRequest $request, string $id)
    {
        try {
            $this->phaseService->updateStatus(intval($id), $request->validated());
            alert_success('Phase modifié avec succès.');
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
            $this->phaseService->destroy(intval($id));
            alert_success('Phase supprimée avec succès.');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
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
