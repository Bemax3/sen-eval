<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SaveSanctionTypeRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Settings\SanctionType;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class SanctionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Settings/Sanction/SanctionsList', [
            'sanctions' => SanctionType::paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveSanctionTypeRequest $request)
    {
        try {
            SanctionType::create($request->validated());
            alert_success('Type crée avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la création de ce type.');
        } finally {
            return redirect()->route('sanctionTypes.create');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/Sanction/SaveSanction');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SanctionType $sanctionType)
    {
        try {
            return Inertia::render('Settings/Sanction/SaveSanction', [
                'sanction' => $sanctionType
            ]);
        } catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveSanctionTypeRequest $request, SanctionType $sanctionType)
    {
        try {
            $sanctionType->update($request->validated());
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
    public function destroy(SanctionType $sanctionType)
    {
        try {
            $sanctionType->delete();
            alert_success('Type supprimé avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la suppression de ce type.');
        } finally {
            redirect()->route('sanctionTypes.index');
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(SanctionType::class, $data['fields'])
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
