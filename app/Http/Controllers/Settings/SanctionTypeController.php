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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/Sanction/SaveSanction');
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Settings/Sanction/SaveSanction', [
            'sanction' => SanctionType::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveSanctionTypeRequest $request, string $id)
    {
        try {
            $sanction = SanctionType::findOrFail($id);
            $sanction->update($request->validated());
            alert_success('Type modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de ce type.');
        } finally {
            return redirect()->route('sanctionTypes.edit', ['sanctionType' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            SanctionType::findOrFail(intval($id))->delete();
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
