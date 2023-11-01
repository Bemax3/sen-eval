<?php

namespace App\Http\Controllers\Evaluation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluation\SaveEvaluationRequest;
use App\Models\Evaluation\Evaluation;
use App\Models\Evaluation\EvaluationSkill;
use App\Models\Evaluation\Goal;
use App\Models\Phase\Phase;
use App\Models\User;
use App\Services\Evaluation\EvaluationService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use SebastianBergmann\CodeCoverage\Exception;

class EvaluationController extends Controller
{
    public function __construct(private readonly EvaluationService $evaluationService){}

    public function index(string $id) {
        return Inertia::render('Evaluation/Evaluation/EvalsList',[
            'agent' => User::with('org')->findOrFail($id),
            'evals' => Evaluation::where('evaluator_id','=',\Auth::id())->where('evaluated_id','=',$id)->with('evaluator','phase','evaluated')->paginate(10)
        ]);
    }

    public function create(string $id) {
        return Inertia::render('Evaluation/Evaluation/SaveEvaluation',[
            'agent' => User::with('org')->findOrFail($id),
            'phases' => Phase::all(),
        ]);
    }

    public function show(string $id,string $evaluation_id) {
        $evaluation = Evaluation::with('phase','evaluator')->withSum('specific_skills','evaluation_skill_mark')->withSum('general_skills','evaluation_skill_mark')->findOrFail($evaluation_id);
        $agent = User::with('org')->findOrFail($id);
        return Inertia::render('Evaluation/Evaluation/EvaluationSkills',[
            'evaluation' => $evaluation,
            'agent' => $agent,
            'specific_skill_types' => $evaluation->phase->specific_skills()->get(),
            'specific_skills' => $evaluation->specific_skills()->get(),
            'skills' => $evaluation->general_skills()->get(),
            'goals' => Goal::where('phase_id',$evaluation->phase_id)->where('evaluated_id',$evaluation->evaluated_id)->with('period','phase')->get(),
        ]);
    }

    public function store(SaveEvaluationRequest $request, string $id) {
        try {
            $evaluation = $this->evaluationService->create($request->validated());
            alert_success('Evaluation crée avec succès.');
            return redirect()->route('evaluation.show',['evaluation' => $evaluation->evaluation_id,'agent' => $id]);
        }catch (Exception) {
            alert_error('Erreur lors de la création de l\'évaluation.');
            return redirect()->back();
        }
    }
}
