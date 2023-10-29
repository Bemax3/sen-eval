<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SaveSkillTypeRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Settings\SkillType;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\Search;

class SkillTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Settings/SkillTypes/SkillTypesList', [
            'skills' => SkillType::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Settings/SkillTypes/SaveSkillType');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveSkillTypeRequest $request)
    {
        try {
            SkillType::create($request->validated());
            alert_success('Type crée avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la création de ce type.');
        } finally {
            return redirect()->route('skillTypes.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            return Inertia::render('Settings/SkillTypes/SaveSkillType', [
                'skill' => SkillType::findOrFail($id)
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveSkillTypeRequest $request, string $id)
    {
        try {
            $skill = SkillType::findOrFail($id);
            $skill->update($request->validated());
            alert_success('Type modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de ce type.');
        } finally {
            return redirect()->route('skillTypes.edit', ['skillType' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            SkillType::findOrFail(intval($id))->delete();
            alert_success('Type supprimé avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la suppression de ce type.');
        } finally {
            redirect()->route('skillTypes.index');
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(SkillType::class, $data['fields'])
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
