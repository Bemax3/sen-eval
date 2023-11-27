<?php

use App\Models\Rating\Rating;
use App\Models\Settings\MobilityType;
use App\Models\Settings\TrainingType;
use App\Models\User;
use App\Services\Dashboard\Helper;

if (!function_exists('getRatingsData')) {

    function getRatingsData($phase_id, $org_id): object
    {
        $data = (object)[];
        if (!isset($org_id) || $org_id == -1) {
            $users_count = User::where('role_id', '!=', 1)->count();
            $rated = Rating::where('phase_id', '=', $phase_id)->where('rating_is_validated', '=', 1)->count();
            $not_validated = Rating::where('phase_id', '=', $phase_id)->where('rating_is_validated', '=', 0)->count();
        } else {
            $users_count = User::where('role_id', '!=', 1)->whereHas('org', function ($query) use ($org_id) {
                $query->where('organisations.org_id', '=', $org_id)
                    ->orWhere('organisations.parent_id', '=', $org_id);
            })->count();
            $rated = Helper::getRatingsCountByPhaseAndOrgAndStatus($phase_id, $org_id, 1);
            $not_validated = Helper::getRatingsCountByPhaseAndOrgAndStatus($phase_id, $org_id, 0);
        }
        $data->users_count = $users_count;
        $data->rated = $rated;
        $data->not_validated = $not_validated;

        return $data;
    }
}


if (!function_exists('getTrainingsData')) {
    function getTrainingsData($phase_id, $org_id): object
    {

        $data = (object)[];

        if (!isset($org_id) || $org_id == -1) {

            $trainings = TrainingType::withCount(['trainings as trainings_by_evaluators' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, NULL, 1);
            }, 'trainings as trainings_by_evaluated' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, 1, NULL);
            }, 'trainings as asked_by_both' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, 1, 1);
            }, 'trainings' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhase($query, $phase_id);
            }])
                ->orHaving('trainings_by_evaluators', '>', 0)
                ->orHaving('trainings_by_evaluated', '>', 0)
                ->orHaving('asked_by_both', '>', 0)
                ->get();
        } else {

            $trainings = TrainingType::withCount(['trainings as trainings_by_evaluators' => function ($query) use ($phase_id, $org_id) {
                Helper::filterTrainingsByPhaseAndOrgAndAsker($query, $phase_id, $org_id, NULL, 1);
            }, 'trainings as trainings_by_evaluated' => function ($query) use ($phase_id, $org_id) {
                Helper::filterTrainingsByPhaseAndOrgAndAsker($query, $phase_id, $org_id, 1, NULL);
            }, 'trainings as asked_by_both' => function ($query) use ($phase_id, $org_id) {
                Helper::filterTrainingsByPhaseAndOrgAndAsker($query, $phase_id, $org_id, 1, 1);
            }, 'trainings' => function ($query) use ($phase_id, $org_id) {
                Helper::filterTrainingsByPhaseAndOrg($query, $phase_id, $org_id);
            }])
                ->orHaving('trainings_by_evaluators', '>', 0)
                ->orHaving('trainings_by_evaluated', '>', 0)
                ->orHaving('asked_by_both', '>', 0)
                ->get();
        }


        $data->trainings = $trainings;
        return $data;
    }
}


if (!function_exists('getMobilitiesData')) {
    function getMobilitiesData($phase_id, $org_id): object
    {
        $data = (object)[];

        if (!isset($org_id) || $org_id == -1) {
            $mobilities = MobilityType::withCount(['mobilities' => function ($query) use ($phase_id, $org_id) {
                Helper::filterMobilitiesByPhaseAndOrgAndAsker($query, $phase_id, $org_id);
            }])->get();
        }


    }
}
