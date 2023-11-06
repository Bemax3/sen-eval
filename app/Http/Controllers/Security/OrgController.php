<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\SaveOrgRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Organisation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class OrgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return Inertia::render('Security/Organisations/OrgList', [
                'orgs' => Organisation::with('parent')->paginate(10)
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    public function show(string $id) {
        try {
            return Inertia::render('Security/Organisations/Org',[
                'org' => Organisation::with('children')->findOrFail($id),
                'agents' => User::with('org')->whereRelation('org','org_id','=',$id)->orWhereRelation('org','parent_id','=',$id)->paginate(10)
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }
//    /**
//     * Show the form for creating a new resource.
//     */
//    public function create()
//    {
//        return Inertia::render('Settings/Skill/SaveSkill',[
//            'types' => SkillType::all()
//        ]);
//    }

//    /**
//     * Store a newly created resource in storage.
//     */
//    public function store(SaveSkillRequest $request)
//    {
//        try {
//            Skill::create($request->validated());
//            alert_success('Compétence crée avec succès.');
//        } catch (Exception) {
//            alert_error('Erreur lors de la création de cette compétence.');
//        } finally {
//            return redirect()->route('skills.create');
//        }
//    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            return Inertia::render('Security/Organisations/SaveOrg', [
                'org' => Organisation::with('parent')->findOrFail($id),
                'parents' => Organisation::all()
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveOrgRequest $request, string $id)
    {
        try {
            $org = Organisation::findOrFail($id);
            $org->update($request->validated());
            alert_success('Organisation enregistré avec succès.');
        }catch (Exception) {
            alert_error('Erreur lors de la sauvegarde de l\'organisation');
        } finally {
            return redirect()->back();
        }
    }

//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(string $id)
//    {
//        try {
//            Skill::findOrFail(intval($id))->delete();
//            alert_success('Compétence supprimé avec succès.');
//        } catch (Exception) {
//            alert_error('Erreur lors de la suppression de cette compétence.');
//        } finally {
//            redirect()->route('skills.index');
//        }
//    }
//

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(Organisation::class, function  (ModelSearchAspect $aspect) use($data) {
                    foreach ($data['fields'] as $field) {
                        $aspect->addSearchableAttribute($field);
                    }
                    $aspect->with('parent');
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
