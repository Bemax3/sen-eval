<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\Phase\Phase;
use App\Models\Rating\Rating;
use App\Models\Settings\TrainingType;
use App\Models\User;
use App\Services\Dashboard\Helper;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $org_id = $request->get('org_id');
        $phase_id = $request->get('phase_id');
        $phases = Phase::get();
        if (!isset($phase_id)) $phase_id = $phases[0]->phase_id;
        if (!isset($org_id) || $org_id == -1) {
            $users_count = User::where('role_id', '!=', 1)->count();
            $rated = Rating::where('phase_id', '=', $phase_id)->count();
            $trainings = TrainingType::withCount(['trainings as trainings_by_evaluators' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, 0, 1);
            }, 'trainings as trainings_by_evaluated' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, 1, 0);
            }, 'trainings as asked_by_both' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, 1, 1);
            }, 'trainings' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhase($query, $phase_id);
            }])->get();
        } else {
            $users_count = User::where('role_id', '!=', 1)->whereHas('org', function ($query) use ($org_id) {
                $query->where('organisations.org_id', '=', $org_id)
                    ->orWhere('organisations.parent_id', '=', $org_id);
            })->count();
            $rated = Rating::where('phase_id', '=', $phase_id)
                ->where('validated_by_n1', '=', 1)
                ->where('validated_by_n2', '=', 1)
                ->whereHas('evaluated', function ($query) use ($org_id) {
                    $query->whereHas('org', function ($query) use ($org_id) {
                        $query->where('organisations.org_id', '=', $org_id)
                            ->orWhere('organisations.parent_id', '=', $org_id);
                    });
                })->count();

            $trainings = TrainingType::withCount(['trainings as trainings_by_evaluators' => function ($query) use ($phase_id, $org_id) {
                Helper::filterTrainingsByPhaseAndOrgAndAsker($query, $phase_id, $org_id, 0, 1);
            }, 'trainings as trainings_by_evaluated' => function ($query) use ($phase_id, $org_id) {
                Helper::filterTrainingsByPhaseAndOrgAndAsker($query, $phase_id, $org_id, 1, 0);
            }, 'trainings as asked_by_both' => function ($query) use ($phase_id, $org_id) {
                Helper::filterTrainingsByPhaseAndOrgAndAsker($query, $phase_id, $org_id, 1, 1);
            }, 'trainings' => function ($query) use ($phase_id, $org_id) {
                Helper::filterTrainingsByPhaseAndOrg($query, $phase_id, $org_id);
            }])->get();
        }

//        alert_success('Filtered');
        return Inertia::render('Dashboards/AdminDashboard', [
            'users' => $users_count,
            'rated' => $rated,
            'not_rated' => $users_count - $rated,
            'orgs' => Organisation::where('org_type', '=', 'DIR')->orWhere('org_type', '=', 'DIRP')->get(),
            'phases' => $phases,
            'phase' => $phase_id,
            'org' => $org_id,
            'trainings' => $trainings
        ]);
    }
}
