<?php

namespace App\Services\Dashboard;

class Helper
{

    public static function filterTrainingsByPhaseAndOrgAndAsker($query, $phase_id, $org_id, $asked_by_evaluated, $asked_by_evaluator)
    {
        return $query->whereHas('rating', function ($query) use ($phase_id, $org_id) {
            $query->where('ratings.phase_id', '=', $phase_id)
                ->whereHas('evaluated', function ($query) use ($org_id) {
                    $query->whereHas('org', function ($query) use ($org_id) {
                        $query->where('organisations.org_id', '=', $org_id)
                            ->orWhere('organisations.parent_id', '=', $org_id);
                    });
                });
        })->where('asked_by_evaluator', '=', $asked_by_evaluator)->where('asked_by_evaluated', '=', $asked_by_evaluated);
    }

    public static function filterTrainingsByPhaseAndOrg($query, $phase_id, $org_id)
    {
        return $query->whereHas('rating', function ($query) use ($phase_id, $org_id) {
            $query->where('ratings.phase_id', '=', $phase_id)
                ->whereHas('evaluated', function ($query) use ($org_id) {
                    $query->whereHas('org', function ($query) use ($org_id) {
                        $query->where('organisations.org_id', '=', $org_id)
                            ->orWhere('organisations.parent_id', '=', $org_id);
                    });
                });
        });
    }

    public static function filterTrainingsByPhaseAndAsker($query, $phase_id, $asked_by_evaluated, $asked_by_evaluator)
    {
        return $query->whereHas('rating', function ($query) use ($phase_id) {
            $query->where('ratings.phase_id', '=', $phase_id);
        })->where('asked_by_evaluator', '=', $asked_by_evaluator)->where('asked_by_evaluated', '=', $asked_by_evaluated);
    }

    public static function filterTrainingsByPhase($query, $phase_id)
    {
        return $query->whereHas('rating', function ($query) use ($phase_id) {
            $query->where('ratings.phase_id', '=', $phase_id);
        });
    }


}
