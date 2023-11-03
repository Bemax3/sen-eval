<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Models\Evaluation\Evaluation;
use App\Models\Evaluation\Goal;
use App\Models\Settings\SkillType;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserEvaluationController extends Controller
{
    public function index() {
        return Inertia::render('Evaluation/Evaluation/EvalsList',[
            'user' => User::with('org')->findOrFail(\Auth::id()),
            'evals' => Evaluation::where('evaluated_id','=',\Auth::id())->with('evaluator','phase','evaluated')->paginate(10)
        ]);
    }
    public function show(string $evaluation_id) {
        $evaluation = Evaluation::with('phase','evaluator')->withSum('specific_skills','evaluation_skill_mark')->withSum('general_skills','evaluation_skill_mark')->findOrFail($evaluation_id);
        $agent = User::with('org')->findOrFail(\Auth::id());
        return Inertia::render('Evaluation/Evaluation/EvaluationSkills',[
            'evaluation' => $evaluation,
            'agent' => $agent,
            'bareme' => ['specific' => SkillType::SPECIFIC_MARKING,'general' => SkillType::GENERAL_MARKING,'perf' => SkillType::GOALS_MARKING],
            'specific_skills' => $evaluation->specific_skills()->get(),
            'skills' => $evaluation->general_skills()->get(),
            'goals' => Goal::where('phase_id',$evaluation->phase_id)->where('evaluated_id',$evaluation->evaluated_id)->with('period','phase')->get(),
        ]);
    }
}
