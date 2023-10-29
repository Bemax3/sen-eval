<?php

use App\Http\Controllers\Evaluation\SaveAsMyAgentController;
use App\Http\Controllers\Evaluation\AgentsController;
use App\Http\Controllers\Evaluation\AgentsGoalsController;
use App\Http\Controllers\Evaluation\GoalsController;
use App\Http\Controllers\Phase\PeriodsController;
use App\Http\Controllers\Phase\PhaseController;
use App\Http\Controllers\Phase\PhaseSkillController;
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
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Home/Index');
})->middleware('auth')->name('home');

Route::group(['middleware' => ['auth']],function () {
    Route::resources([
        'profile' => ProfileController::class,
        'goals' => GoalsController::class,
        'agents' => AgentsController::class,
        'agent/{agent}/agent-goals' => AgentsGoalsController::class
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
    Route::post('/agents/search', [AgentsController::class, 'search'])->name('agents.search');
    Route::post('/agent/{agent}/agent-goals/search', [AgentsGoalsController::class, 'search'])->name('agent-goals.search');
});

Route::group(['middleware' => ['auth', 'root']], function () {
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

require __DIR__ . '/auth.php';
