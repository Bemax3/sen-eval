<?php

namespace App\Services\Dashboard;

use App\Models\Rating\Rating;

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
        })->where('asked_by_evaluator', $asked_by_evaluator)->where('asked_by_evaluated', $asked_by_evaluated);
    }

    public static function filterTrainingsByPhaseAndAsker($query, $phase_id, $asked_by_evaluated, $asked_by_evaluator)
    {
        return $query->whereHas('rating', function ($query) use ($phase_id) {
            $query->where('ratings.phase_id', '=', $phase_id);
        })->where('asked_by_evaluator', $asked_by_evaluator)->where('asked_by_evaluated', $asked_by_evaluated);
    }

    public static function getRatingsByPhaseAndOrgAndStatus($phase_id, $org_id, $status): \Illuminate\Database\Eloquent\Builder|Rating
    {
        return Rating::where('phase_id', '=', $phase_id)
            ->where('rating_is_validated', '=', $status)
            ->whereHas('evaluated', function ($query) use ($org_id) {
                $query->whereHas('org', function ($query) use ($org_id) {
                    $query->where('organisations.org_id', '=', $org_id)
                        ->orWhere('organisations.parent_id', '=', $org_id);
                });
            });
    }

    public static function getRatingsByPhaseAndOrg($phase_id, $org_id): \Illuminate\Database\Eloquent\Builder|Rating
    {
        return Rating::where('phase_id', '=', $phase_id)
            ->whereHas('evaluated', function ($query) use ($org_id) {
                $query->whereHas('org', function ($query) use ($org_id) {
                    $query->where('organisations.org_id', '=', $org_id)
                        ->orWhere('organisations.parent_id', '=', $org_id);
                });
            });
    }

    public static function getRatingsByPhase($phase_id): \Illuminate\Database\Eloquent\Builder|Rating
    {
        return Rating::where('phase_id', '=', $phase_id);
    }

    public static function getRatingsByPhaseAndStatus($phase_id, $status): \Illuminate\Database\Eloquent\Builder|Rating
    {
        return Rating::where('phase_id', '=', $phase_id)->where('rating_is_validated', '=', $status);
    }

    public static function filterMobilitiesByPhaseAndOrgAndAsker($query, $phase_id, $org_id, $by)
    {
        return $by === 0 ?
            $query->whereHas('rating', function ($query) use ($phase_id, $org_id) {
                $query->where('ratings.phase_id', '=', $phase_id)
                    ->whereColumn('ratings.evaluator_id', '=', 'rating_mobilities.asked_by')
                    ->whereHas('evaluated', function ($query) use ($org_id) {
                        $query->whereHas('org', function ($query) use ($org_id) {
                            $query->where('organisations.org_id', '=', $org_id)
                                ->orWhere('organisations.parent_id', '=', $org_id);
                        });
                    });
            })
            :
            $query->whereHas('rating', function ($query) use ($phase_id, $org_id) {
                $query->where('ratings.phase_id', '=', $phase_id)
                    ->whereColumn('ratings.evaluated_id', '=', 'rating_mobilities.asked_by')
                    ->whereHas('evaluated', function ($query) use ($org_id) {
                        $query->whereHas('org', function ($query) use ($org_id) {
                            $query->where('organisations.org_id', '=', $org_id)
                                ->orWhere('organisations.parent_id', '=', $org_id);
                        });
                    });
            });
    }

    public static function filterMobilitiesByPhaseAndAsker($query, $phase_id, $by)
    {
        return $by === 0 ?
            $query->whereHas('rating', function ($query) use ($phase_id) {
                $query->where('ratings.phase_id', '=', $phase_id)
                    ->whereColumn('ratings.evaluator_id', '=', 'rating_mobilities.asked_by');
            })
            :
            $query->whereHas('rating', function ($query) use ($phase_id) {
                $query->where('ratings.phase_id', '=', $phase_id)
                    ->whereColumn('ratings.evaluated_id', '=', 'rating_mobilities.asked_by');
            });
    }

    public static function filterByPhase($query, $phase_id)
    {
        return $query->whereHas('rating', function ($query) use ($phase_id) {
            $query->where('ratings.phase_id', '=', $phase_id);
        });
    }

    public static function filterByPhaseAndOrg($query, $phase_id, $org_id)
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


    public static function queryByPhaseAndOrg($query, $phase_id, $org_id)
    {
        return $query->where('ratings.phase_id', '=', $phase_id)
            ->whereHas('evaluated', function ($query) use ($org_id) {
                $query->whereHas('org', function ($query) use ($org_id) {
                    $query->where('organisations.org_id', '=', $org_id)
                        ->orWhere('organisations.parent_id', '=', $org_id);
                });
            });
    }

    public static function queryByPhase($query, $phase_id)
    {
        return $query->where('ratings.phase_id', '=', $phase_id);
    }


}
