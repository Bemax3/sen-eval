<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Organisation;
use App\Models\Phase\Phase;
use App\Models\Settings\ClaimType;
use App\Models\Settings\MobilityType;
use App\Models\Settings\PromotionType;
use App\Models\Settings\SanctionType;
use App\Models\Settings\TrainingType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);

        $ratings = getRatingsData($phase_id, $org_id);

        // Get Skills Data
        $specific_skills = getSkillsDataByType($phase_id, $org_id, 1);
        $skills = getSkillsDataByType($phase_id, $org_id, 2);
        $skillsAvgBarChart = getSkillsBarChart($skills, reversed: true);
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

    public static function getFilters($request)
    {
        $org_id = $request->get('org_id') ?? -1;
        $phase_id = $request->get('phase_id');
        $phases = Phase::get();
        if (!isset($phase_id)) $phase_id = $phases[0]->phase_id;

        return [$phase_id, $org_id, $phases];
    }

    public function rated(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $ratings = getValidatedRatings($phase_id, $org_id);
        return Inertia::render('Dashboards/RatedDetails', [
            'ratings' => $ratings->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1
        ]);
    }

    public function leaderboard(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $ratings = getRatingsInMarkOrder($phase_id, $org_id);
        return Inertia::render('Dashboards/LeaderBoard', [
            'ratings' => $ratings->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1
        ]);
    }

    public function pending(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $ratings = getPendingRatings($phase_id, $org_id);
        return Inertia::render('Dashboards/PendingDetails', [
            'ratings' => $ratings->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1
        ]);
    }

    public function unrated(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $users = getUnratedUsers($phase_id, $org_id);

        return Inertia::render('Dashboards/UnratedDetails', [
            'users' => $users->with('org')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1
        ]);
    }

    public function trainingsDetails(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $type = $request->get('type');
        $trainings = getTrainingsDetails($phase_id, $org_id, $type);
        return Inertia::render('Dashboards/TrainingsDetails', [
            'trainings' => $trainings->with('rating', 'rating.evaluator', 'rating.evaluated')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
            'type' => TrainingType::findOrFail($type)
        ]);
    }

    public function claimsDetails(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $type = $request->get('type');
        $claims = getClaimsDetails($phase_id, $org_id, $type);
        return Inertia::render('Dashboards/ClaimsDetails', [
            'claims' => $claims->with('rating', 'rating.evaluator', 'rating.evaluated')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
            'type' => ClaimType::findOrFail($type)
        ]);
    }

    public function mobilitiesDetails(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $type = $request->get('type');
        $mobilities = getMobilitiesDetails($phase_id, $org_id, $type);
        return Inertia::render('Dashboards/MobilitiesDetails', [
            'mobilities' => $mobilities->with('rating', 'rating.evaluator', 'rating.evaluated', 'asked_by')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
            'type' => MobilityType::findOrFail($type)
        ]);
    }

    public function sanctionsDetails(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $type = $request->get('type');
        $sanctions = getSanctionsDetails($phase_id, $org_id, $type);
        return Inertia::render('Dashboards/SanctionsDetails', [
            'sanctions' => $sanctions->with('rating', 'rating.evaluator', 'rating.evaluated')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
            'type' => SanctionType::findOrFail($type)
        ]);
    }

    public function promotionsDetails(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $type = $request->get('type');
        $promotions = getPromotionsDetails($phase_id, $org_id, $type);
        return Inertia::render('Dashboards/PromotionsDetails', [
            'promotions' => $promotions->with('rating', 'rating.evaluator', 'rating.evaluated')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
            'type' => PromotionType::findOrFail($type)
        ]);
    }

    public function allPromotions(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $promotions = getAllPromotions($phase_id, $org_id);
        return Inertia::render('Dashboards/PromotionsList', [
            'promotions' => $promotions->with('rating', 'rating.evaluator', 'rating.evaluated', 'type')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
        ]);
    }

    public function allSanctions(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $sanctions = getAllSanctions($phase_id, $org_id);
        return Inertia::render('Dashboards/SanctionsList', [
            'sanctions' => $sanctions->with('rating', 'rating.evaluator', 'rating.evaluated', 'type')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
        ]);
    }

    public function allMobilities(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $mobilities = getAllMobilities($phase_id, $org_id);
        return Inertia::render('Dashboards/MobilitiesList', [
            'mobilities' => $mobilities->with('rating', 'rating.evaluator', 'rating.evaluated', 'type')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
        ]);
    }

    public function allClaims(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $claims = getAllClaims($phase_id, $org_id);
        return Inertia::render('Dashboards/ClaimsList', [
            'claims' => $claims->with('rating', 'rating.evaluator', 'rating.evaluated', 'type')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
        ]);
    }

    public function allTrainings(Request $request)
    {
        [$phase_id, $org_id, $phases] = self::getFilters($request);
        $trainings = getAllTrainings($phase_id, $org_id);
        return Inertia::render('Dashboards/TrainingsList', [
            'trainings' => $trainings->with('rating', 'rating.evaluator', 'rating.evaluated', 'type')->paginate(15)->withQueryString(),
            'phase' => $phases->where('phase_id', '=', $phase_id)->first(),
            'org' => Organisation::where('org_id', '=', $org_id)->first() ?? -1,
        ]);
    }

}
