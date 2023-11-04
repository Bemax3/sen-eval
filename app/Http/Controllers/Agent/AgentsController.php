<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveAgentRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\User;
use App\Services\Security\UserService;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class AgentsController extends Controller
{
    public function index() {
        try {
            $user = User::findOrFail(\Auth::id());
            return Inertia::render('Agents/AgentsList',[
                'agents' => $user->agents()->paginate(10),
                'others' => $user->org_id ? (new UserService())->findSameOrgUsers($user) : []
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::with('role')->with('org')->with('n1')->with('group')->findOrFail($id);
            return Inertia::render('Security/Profile/Profile', [
                'user' => $user,
                'n1s' => $user->org_id ? (new UserService())->findSameOrgUsers($user) : []
            ]);
        }catch (Exception) {
            alert_error('Resource Introuvable.');
            return redirect()->back();
        }
    }

    public function store(SaveAgentRequest $request) {
        try {
            if($request->get('agent_id') == \Auth::id()) {
                alert_error('Ahh Nonn! Vous ne pouver pas vous evaluer quand même.');
                return redirect()->back();
            }
            (new UserService())->setUserN1($request->validated(),\Auth::id());
            alert_success('Agents Enregistré avec succès.');
        }catch (Exception $e) {
            ray($e);
            alert_error('Erreur lors de l\'enregistrement de l\'agent.');
        } finally {
            return redirect()->route('agents.index');
        }
//        ray($request->validated());
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
