<?php

use App\Http\Controllers\Phase\PhaseController;
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


Route::group(['middleware' => ['auth', 'root']], function () {
    Route::post('/claimTypes/search', [ClaimTypeController::class, 'search'])->name('claimTypes.search');
    Route::post('/mobilityTypes/search', [MobilityTypeController::class, 'search'])->name('mobilityTypes.search');
    Route::post('/sanctionTypes/search', [SanctionTypeController::class, 'search'])->name('sanctionTypes.search');
    Route::post('/skillTypes/search', [SkillTypeController::class, 'search'])->name('skillTypes.search');
    Route::post('/trainingTypes/search', [TrainingTypeController::class, 'search'])->name('trainingTypes.search');
    Route::post('/skills/search', [SkillController::class, 'search'])->name('skills.search');
    Route::post('/phases/search', [PhaseController::class, 'search'])->name('phases.search');
    Route::resources([
        'claimTypes' => ClaimTypeController::class,
        'mobilityTypes' => MobilityTypeController::class,
        'sanctionTypes' => SanctionTypeController::class,
        'skillTypes' => SkillTypeController::class,
        'trainingTypes' => TrainingTypeController::class,
        'skills' => SkillController::class,
        'phases' => PhaseController::class
    ]);
});


require __DIR__ . '/auth.php';
