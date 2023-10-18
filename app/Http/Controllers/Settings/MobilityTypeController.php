<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SaveMobilityTypeRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Settings\MobilityType;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class MobilityTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Settings/Mobility/MobilitiesList', [
            'mobilities' => MobilityType::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/Mobility/SaveMobility');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveMobilityTypeRequest $request)
    {
        try {
            MobilityType::create($request->validated());
            alert_success('Type crée avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la création de ce type.');
        } finally {
            return redirect()->route('mobilityTypes.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Settings/Mobility/SaveMobility', [
            'mobility' => MobilityType::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveMobilityTypeRequest $request, string $id)
    {
        try {
            $mobility = MobilityType::findOrFail($id);
            $mobility->update($request->validated());
            alert_success('Type modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de ce type.');
        } finally {
            return redirect()->route('mobilityTypes.edit', ['mobilityType' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            MobilityType::findOrFail(intval($id))->delete();
            alert_success('Type supprimé avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la suppression de ce type.');
        } finally {
            redirect()->route('mobilityTypes.index');
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(MobilityType::class, $data['fields'])
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
