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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/Training/SaveTraining');
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Settings/Training/SaveTraining', [
            'training' => TrainingType::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveTrainingTypeRequest $request, string $id)
    {
        try {
            $training = TrainingType::findOrFail($id);
            $training->update($request->validated());
            alert_success('Type modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de ce type.');
        } finally {
            return redirect()->route('trainingTypes.edit', ['trainingType' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            TrainingType::findOrFail(intval($id))->delete();
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
