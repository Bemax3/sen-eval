<?php

namespace App\Http\Controllers\Phase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Phase\SavePhaseRequest;
use App\Http\Requests\Phase\SavePhaseSkillRequest;
use App\Http\Requests\Utilities\SearchRequest;
use App\Models\Phase\Phase;
use App\Models\Settings\Skill;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class PhaseSkillController extends Controller
{
    public function update(SavePhaseSkillRequest $request, string $id)
    {
        try {
            $phase = Phase::findOrFail($id);
            $data = $request->validated();
            $phase->skills()->updateExistingPivot($data['skill_id'],$request->only('phase_skill_is_active','phase_skill_marking'));
            $phase->save();
            alert_success('Phase modifié avec succès.');
        } catch (Exception) {
            alert_error('Erreur lors de la modification de cette phase.');
        } finally {
            return redirect()->back();
        }
    }

    public function search(SearchRequest $request)
    {
        try {
            $data = $request->validated();
            $searchResults = (new Search())
                ->registerModel(Skill::class, function  (ModelSearchAspect $aspect) use($data) {
                    foreach ($data['fields'] as $field) {
                        $aspect->addSearchableAttribute($field);
                    }
                    $aspect->whereHas('phases',function ($query) use ($data) {
                        $query->where('phases.phase_id','=',$data['phase_id']);
                    });

                    $aspect->with('phases',function ($query) use ($data) {
                        $query->where('phases.phase_id','=',$data['phase_id']);
                    });
                    $aspect->with('type');
                })
                ->search($data['keyword']);
            $result = [];
            foreach ($searchResults as $sr) {
                $sr->searchable['pivot'] = $sr->searchable->phases[0]->pivot;
                $result[] = $sr->searchable;
            }
            return response()->json($result);
        } catch (Exception) {
            return response()->json();
        }
    }
}
