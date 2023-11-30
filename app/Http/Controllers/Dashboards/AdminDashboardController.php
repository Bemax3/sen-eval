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

        // Get Skills Data
        $specific_skills = getSkillsDataByType($phase_id, $org_id, 1);
        $skills = getSkillsDataByType($phase_id, $org_id, 2);
        $skillsAvgBarChart = getSkillsBarChart($skills);
        $specificSkillsAvgBarChart = getSkillsBarChart($specific_skills);

        // Get Trainings Data
        $trainings = getTrainingsData($phase_id, $org_id);
        $trainingsBarChart = getTrainingsBarChart($trainings);

        // Get Mobilities Data
        $mobilities = getMobilitiesData($phase_id, $org_id);
        $mobilitiesBarChart = getMobilitiesBarChart($mobilities);

        // Get Claims Data
        $claims = getClaimsData($phase_id, $org_id);
        $claimsPieChart = getClaimsPieChart($claims);

        // Get Sanctions Data
        $sanctions = getSanctionsData($phase_id, $org_id);
        $sanctionsPieChart = getSanctionsPieChart($sanctions);

        // Get Promotions Data
        $promotions = getPromotionsData($phase_id, $org_id);
        $promotionsPieChart = getPromotionsPieChartByType($promotions, 1);
        $advancementsPieChart = getPromotionsPieChartByType($promotions, 2);

        return Inertia::render('Dashboards/AdminDashboard', [
            'users' => $ratings->users_count,
            'rated' => $ratings->rated,
            'not_validated' => $ratings->not_validated,
            'not_rated' => $ratings->users_count - $ratings->rated - $ratings->not_validated,
            'average' => getAverageChart($ratings->average),
            'skills' => $skills,
            'skillsChart' => $skillsAvgBarChart,
            'tops' => $ratings->top,
            'specificSkillsChart' => $specificSkillsAvgBarChart,
            'orgs' => Organisation::where('org_type', '=', 'DIR')->orWhere('org_type', '=', 'DIRP')->get(),
            'phases' => $phases,
            'phase' => $phase_id,
            'org' => $org_id,
            'trainings' => $trainings,
            'trainingsChart' => $trainingsBarChart,
            'mobilities' => $mobilities,
            'mobilitiesChart' => $mobilitiesBarChart,
            'claims' => $claims,
            'claimsChart' => $claimsPieChart,
            'sanctions' => $sanctions,
            'sanctionsChart' => $sanctionsPieChart,
            'promotions' => $promotions,
            'promotionsChart' => $promotionsPieChart,
            'advancementsChart' => $advancementsPieChart,
            'selected' => $request->get('selected') ?? 0
        ]);
    }
}
