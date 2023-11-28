<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SaveTrainingTypeRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Settings\TrainingType;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\Search;


class TrainingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Settings/Training/TrainingsList', [
            'trainings' => TrainingType::paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveTrainingTypeRequest $request)
    {
        try {
            TrainingType::create($request->validated());
            alert_success('Type crée avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la création de ce type.');
        } finally {
            return redirect()->route('trainingTypes.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/Training/SaveTraining');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingType $trainingType)
    {
        try {
            return Inertia::render('Settings/Training/SaveTraining', [
                'training' => $trainingType
            ]);
        } catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveTrainingTypeRequest $request, TrainingType $trainingType)
    {
        try {
            $trainingType->update($request->validated());
            alert_success('Type modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de ce type.');
        } finally {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingType $trainingType)
    {
        try {
            $trainingType->delete();
            alert_success('Type supprimé avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la suppression de ce type.');
        } finally {
            redirect()->route('trainingTypes.index');
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(TrainingType::class, $data['fields'])
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
