<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\Phase\Phase;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        $phases = Phase::get();
        if (!isset($phase_id)) $phase_id = $phases[0]->phase_id;
        $ratings = getRatingsData($phase_id, $org_id);
        $trainings = getTrainingsData($phase_id, $org_id);
        return Inertia::render('Dashboards/AdminDashboard', [
            'users' => $ratings->users_count,
            'rated' => $ratings->rated,
            'not_validated' => $ratings->not_validated,
            'not_rated' => $ratings->users_count - $ratings->rated - $ratings->not_validated,
            'orgs' => Organisation::where('org_type', '=', 'DIR')->orWhere('org_type', '=', 'DIRP')->get(),
            'phases' => $phases,
            'phase' => $phase_id,
            'org' => $org_id,
            'trainings' => $trainings->trainings
        ]);
    }
}
