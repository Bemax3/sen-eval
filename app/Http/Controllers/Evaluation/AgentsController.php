<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class AgentsController extends Controller
{
    public function index() {
        $user = User::findOrFail(\Auth::id());
        return Inertia::render('Evaluation/Agents/AgentsList',[
            'agents' => $user->agents()->with('org')->paginate(10),
            'others' => User::where('user_id','!=',$user->user_id)->whereHas('org',function ($query) use ($user) {
                $query->where('organisations.org_id','=',$user->org->org_id)
                    ->orWhere('organisations.org_id','=',$user->org->parent_id)
                    ->orWhere('organisations.parent_id','=',$user->org->parent_id);
                })->limit(30)->get()
        ]);
    }

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
                    $aspect->where('n1_id','=',\Auth::id());
                    $aspect->with('org');
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
