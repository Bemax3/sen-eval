<?php

use App\Http\Controllers\Agent\AgentGoalsController;
use App\Http\Controllers\Agent\AgentRatingsController;
use App\Http\Controllers\Agent\AgentsController;
use App\Http\Controllers\Dashboards\AdminDashboardController;
use App\Http\Controllers\Dashboards\DownloadController;
use App\Http\Controllers\Goal\GoalsController;
use App\Http\Controllers\Phase\PeriodsController;
use App\Http\Controllers\Phase\PhaseController;
use App\Http\Controllers\Phase\PhaseSkillController;
use App\Http\Controllers\Rating\RatingClaimsController;
use App\Http\Controllers\Rating\RatingMobilitiesController;
use App\Http\Controllers\Rating\RatingPromotionController;
use App\Http\Controllers\Rating\RatingSanctionsController;
use App\Http\Controllers\Rating\RatingsController;
use App\Http\Controllers\Rating\RatingSkillsController;
use App\Http\Controllers\Rating\RatingTrainingsController;
use App\Http\Controllers\Rating\ValidationController;
use App\Http\Controllers\Security\OrgController;
use App\Http\Controllers\Security\ProfileController;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\UserController;
use App\Http\Controllers\Settings\ClaimTypeController;
use App\Http\Controllers\Settings\MobilityTypeController;
use App\Http\Controllers\Settings\SanctionTypeController;
use App\Http\Controllers\Settings\SkillController;
use App\Http\Controllers\Settings\SkillTypeController;
use App\Http\Controllers\Settings\TrainingTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/mailable', function () {
//    $rating = \App\Models\Rating\Rating::where('rating_id', '=', 4)->first();
////    Mail::to('st_massamba.niang@senelec.sn')->send(new App\Mail\ValidatedRating($rating));
////    return new App\Mail\RatingValidatedBy($rating, $rating->validators()->offset(1)->first());
//    return new App\Mail\RatingCreated($rating);
////    return new App\Mail\OtherValidation($rating, $rating->validators()->where('rating_validator_id', '=', 9)->first(), $rating->validators()->where('rating_validator_id', '=', 8)->first());
//});

Route::get('/', [AdminDashboardController::class, 'index'])->middleware('auth', 'viewer')->name('home');
Route::group(['middleware' => ['auth']], function () {
    Route::put('/goals/{goal}/updateMark', [GoalsController::class, 'updateMark'])->name('goals.update-mark');
    Route::post('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::resources([
        'profile' => ProfileController::class,
        'goals' => GoalsController::class,
        'ratings' => RatingsController::class,
        'validations' => ValidationController::class,
        'rating/rating-skills' => RatingSkillsController::class,

        'agents' => AgentsController::class,
        'agent/{agent}/agent-goals' => AgentGoalsController::class,
        'agent/{agent}/agent-ratings' => AgentRatingsController::class,

        'rating/{rating}/rating-trainings' => RatingTrainingsController::class,
        'rating/{rating}/rating-mobilities' => RatingMobilitiesController::class,
        'rating/{rating}/rating-sanctions' => RatingSanctionsController::class,
        'rating/{rating}/rating-claims' => RatingClaimsController::class,
        'rating/{rating}/rating-promotions' => RatingPromotionController::class
    ]);

    Route::post('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::post('/claimTypes/search', [ClaimTypeController::class, 'search'])->name('claimTypes.search');
    Route::post('/mobilityTypes/search', [MobilityTypeController::class, 'search'])->name('mobilityTypes.search');
    Route::post('/sanctionTypes/search', [SanctionTypeController::class, 'search'])->name('sanctionTypes.search');
    Route::post('/skillTypes/search', [SkillTypeController::class, 'search'])->name('skillTypes.search');
    Route::post('/trainingTypes/search', [TrainingTypeController::class, 'search'])->name('trainingTypes.search');
    Route::post('/skills/search', [SkillController::class, 'search'])->name('skills.search');
    Route::post('/phases/search', [PhaseController::class, 'search'])->name('phases.search');
    Route::post('/roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::post('/phaseSkills/search', [PhaseSkillController::class, 'search'])->name('phaseSkills.search');
    Route::post('/periods/search', [PeriodsController::class, 'search'])->name('periods.search');
    Route::post('/orgs/search', [OrgController::class, 'search'])->name('orgs.search');
    Route::post('/goals/search', [GoalsController::class, 'search'])->name('goals.search');
    Route::post('/agents/search', [AgentsController::class, 'search'])->name('agents.search');
    Route::post('/agent/{agent}/agent-goals/search', [AgentGoalsController::class, 'search'])->name('agent-goals.search');
});

Route::group(['middleware' => ['auth', 'root']], function () {
    Route::put('/phases/{phase}/updateStatus', [PhaseController::class, 'updateStatus'])->name('phases.update-status');
    Route::resources([
        'claimTypes' => ClaimTypeController::class,
        'mobilityTypes' => MobilityTypeController::class,
        'sanctionTypes' => SanctionTypeController::class,
        'skillTypes' => SkillTypeController::class,
        'trainingTypes' => TrainingTypeController::class,
        'skills' => SkillController::class,
        'phases' => PhaseController::class,
        'users' => UserController::class,
        'roles' => RoleController::class,
        'phaseSkills' => PhaseSkillController::class,
        'periods' => PeriodsController::class,
        'orgs' => OrgController::class
    ]);
});
Route::group(['middleware' => ['auth', 'viewer']], function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard.index');
    Route::get('/dashboard/rated', [AdminDashboardController::class, 'rated'])->name('admin-dashboard.rated');
    Route::get('/dashboard/pending', [AdminDashboardController::class, 'pending'])->name('admin-dashboard.pending');
    Route::get('/dashboard/unrated', [AdminDashboardController::class, 'unrated'])->name('admin-dashboard.unrated');
    Route::get('/dashboard/leaderboard', [AdminDashboardController::class, 'leaderboard'])->name('admin-dashboard.leaderboard');
    Route::get('/dashboard/download-trainings', [DownloadController::class, 'downloadTrainings'])->name('admin-dashboard.download-trainings');
    Route::get('/dashboard/download-claims', [DownloadController::class, 'downloadClaims'])->name('admin-dashboard.download-claims');
    Route::get('/dashboard/download-sanctions', [DownloadController::class, 'downloadSanctions'])->name('admin-dashboard.download-sanctions');
    Route::get('/dashboard/download-mobilities', [DownloadController::class, 'downloadMobilities'])->name('admin-dashboard.download-mobilities');
    Route::get('/dashboard/download-promotions', [DownloadController::class, 'downloadPromotions'])->name('admin-dashboard.download-promotions');
    Route::get('/dashboard/download-pending', [DownloadController::class, 'downloadPending'])->name('admin-dashboard.download-pending');
});

require __DIR__ . '/auth.php';
