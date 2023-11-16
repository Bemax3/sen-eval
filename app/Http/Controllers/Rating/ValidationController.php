<?php

namespace App\Http\Controllers\Rating;

use App\Exceptions\Goal\NotEnoughGoalsException;
use App\Exceptions\ModelNotFoundException;
use App\Exceptions\Rating\CantUpdateValidatedRatingException;
use App\Exceptions\Rating\EvaluatedHasNotValidatedException;
use App\Exceptions\Rating\NotEnoughSpecificSkillsException;
use App\Exceptions\Rating\NotRatedCorrectlyException;
use App\Exceptions\Rating\ValidatorAlreadyExistException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\SaveValidatorRequest;
use App\Models\Rating\Goal;
use App\Models\Rating\Rating;
use App\Models\Settings\SkillType;
use App\Models\User;
use App\Services\Rating\ValidatorService;
use App\Services\Security\UserService;
use Inertia\Inertia;

class ValidationController extends Controller
{
    public function __construct(private readonly ValidatorService $validatorService)
    {
    }

    public function index()
    {
        $id = \Auth::id();
        return Inertia::render('Validation/RatingsList', [
            'ratings' => Rating::whereHas('validators', function ($query) use ($id) {
                $query->where('validator_id', '=', $id);
            })->where('evaluated_id', '!=', $id)
                ->where('evaluator_id', '!=', $id)
                ->with('evaluator', 'phase', 'evaluated')->paginate(10)
        ]);
    }

    public function show(string $rating_id)
    {
        $user = User::with('n1')->findOrFail(\Auth::id());
        $rating = Rating::with('phase', 'evaluator')->withSum('specific_skills', 'rating_skill_mark')->withSum('general_skills', 'rating_skill_mark')->findOrFail($rating_id);
        return Inertia::render('Validation/ValidateRating', [
            'rating' => $rating,
            'agent' => $rating->evaluated,
            'marking' => ['specific' => SkillType::SPECIFIC_MARKING, 'general' => SkillType::GENERAL_MARKING, 'perf' => SkillType::GOALS_MARKING],
            'specific_skills' => $rating->specific_skills()->get(),
            'skills' => $rating->general_skills()->get(),
            'validators' => $rating->validators()->with('user')->get(),
            'others' => $user->org_id ? (new UserService())->findSameOrgUsers($user) : [],
            'n1' => $user->n1,
            'goals' => Goal::where('phase_id', $rating->phase_id)->where('evaluated_id', $rating->evaluated_id)->with('period', 'phase')->get(),
        ]);
    }

    public function update(SaveValidatorRequest $request, string $validation)
    {
        try {
            $this->validatorService->update($validation, $request->validated());
            alert_success('Évaluation enregistrée.');
        } catch (ModelNotFoundException|EvaluatedHasNotValidatedException|NotEnoughGoalsException|NotEnoughSpecificSkillsException|NotRatedCorrectlyException|CantUpdateValidatedRatingException $e) {
            alert_error($e->getMessage());
        } catch (ValidatorAlreadyExistException $e) {
            alert_success('Commentaire enregistré avec succès. ' . $e->getMessage());
        } finally {
            return redirect()->back();
        }
    }
}
