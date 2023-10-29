<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\Security\SaveUserRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\User;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Security/Users/UsersList', [
            'users' => User::with('role')->with('org')->whereRelation('role','role_code','!=','root')->paginate(10)
        ]);
    }

        /**
     * Show the form for editing the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('role')->with('org')->with('n1')->with('group')->findOrFail($id);
        return Inertia::render('Security/Users/UserProfile', [
            'user' => $user,
            'n1s' => User::where('user_id','!=',$user->user_id)->whereHas('org',function ($query) use ($user) {
                $query->where('organisations.org_id','=',$user->org->org_id)
                    ->orWhere('organisations.org_id','=',$user->org->parent_id)
                    ->orWhere('organisations.parent_id','=',$user->org->parent_id);
            })->get()
        ]);
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

//    /**
//     * Show the form for editing the specified resource.
//     */
//    public function edit(string $id)
//    {
//        return Inertia::render('Settings/Skill/SaveSkill', [
//            'skill' => Skill::with('type')->findOrFail($id),
//            'types' => SkillType::all()
//        ]);
//    }
//
    /**
     * Update the specified resource in storage.
     */
    public function update(SaveUserRequest $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());
            alert_success('Agent modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de cette agent.');
        } finally {
            return redirect()->back();
        }
    }
//
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
//            ray()->queries();
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(User::class, function  (ModelSearchAspect $aspect) use($data) {
                    foreach ($data['fields'] as $field) {
                        $aspect->addSearchableAttribute($field);
                    }
                    if(isset($data['org_id'])) {
                        $aspect->whereHas('org', function ($query) use ($data) {
                            $query->where('organisations.org_id', '=', $data['org_id'])->orWhere('organisations.parent_id','=',$data['org_id']);
                        });
                    }
                    $aspect->with('org');
//                    $aspect->with('role');
                })
                ->limitAspectResults(50)
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
