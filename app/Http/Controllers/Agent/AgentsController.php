<?php

namespace App\Http\Controllers\Agent;

use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\UserCantEvaluateHimselfException;
use App\Exceptions\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveAgentRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Organisation;
use App\Models\User;
use App\Services\Security\UserService;
use Exception;
use Inertia\Inertia;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class AgentsController extends Controller
{
    public function index()
    {
        try {
            $user = User::findOrFail(\Auth::id());
            return Inertia::render('Agents/AgentsList', [
                'agents' => $user->agents()->with('org')->paginate(10),
                'others' => $user->org_id ? (new UserService())->findSameOrgUsers($user) : []
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::with('role', 'org', 'n1', 'group')->findOrFail($id);
            return Inertia::render('Security/Profile/Profile', [
                'user' => $user,
                'n1s' => $user->org_id ? (new UserService())->findSameOrgUsers($user) : [],
                'orgs' => Organisation::limit(100)->get()
            ]);
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
            return redirect()->back();
        }
    }

    public function store(SaveAgentRequest $request)
    {
        try {
            (new UserService())->setUserN1($request->validated(), \Auth::id());
            alert_success('Agents Enregistré avec succès.');
        } catch (UserCantEvaluateHimselfException|UnknownException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->route('agents.index');
        }
    }

    public function update(SaveAgentRequest $request, string $agent_id)
    {
        try {
            (new UserService())->unsetUserN1($agent_id);
            alert_success('Agent retiré avec succès.');
        } catch (ModelNotFoundException $e) {
            alert_error($e->getMessage());
        } finally {
            return redirect()->route('agents.index');
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(User::class, function (ModelSearchAspect $aspect) use ($data) {
                    foreach ($data['fields'] as $field) {
                        $aspect->addSearchableAttribute($field);
                    }
                    $aspect->where('n1_id', '=', \Auth::id());
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
