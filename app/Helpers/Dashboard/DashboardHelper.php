<?php

use App\Models\User;
use App\Models\Rating\Claim;
use App\Models\Rating\Mobility;
use App\Models\Rating\Sanction;
use App\Models\Rating\Training;
use App\Models\Phase\PhaseSkill;
use App\Models\Rating\Promotion;
use App\Models\Rating\Validator;
use App\Models\Settings\ClaimType;
use App\Services\Dashboard\Helper;
use App\Models\Settings\MobilityType;
use App\Models\Settings\SanctionType;
use App\Models\Settings\TrainingType;
use App\Models\Settings\PromotionType;

if (!function_exists('getRatingsData')) {
    function getRatingsData($phase_id, $org_id): object
    {
        $data = (object)[];
        if (!isset($org_id) || $org_id == -1) {
            $users_count = User::where('role_id', '!=', 1)->count();
            $rated = Helper::getRatingsByPhaseAndStatus($phase_id, 1)->count();
            $not_validated = Helper::getRatingsByPhaseAndStatus($phase_id, 0)->count();
            $average = Helper::getRatingsByPhase($phase_id)->where('rating_is_validated', '=', 1)->avg('rating_mark');
            $top = Helper::getRatingsByPhase($phase_id)->orderBy('rating_mark', 'desc')->with(['evaluated', 'validators.user'])->limit(8)->get();
        } else {
            $users_count = User::where('role_id', '!=', 1)->whereHas('org', function ($query) use ($org_id) {
                $query->where('organisations.org_id', '=', $org_id)
                    ->orWhere('organisations.parent_id', '=', $org_id);
            })->count();
            $rated = Helper::getRatingsByPhaseAndOrgAndStatus($phase_id, $org_id, 1)->count();
            $not_validated = Helper::getRatingsByPhaseAndOrgAndStatus($phase_id, $org_id, 0)->count();
            $average = Helper::getRatingsByPhaseAndOrg($phase_id, $org_id)->where('rating_is_validated', '=', 1)->avg('rating_mark');
            $top = Helper::getRatingsByPhaseAndOrg($phase_id, $org_id)->orderBy('rating_mark', 'desc')->with(['evaluated', 'validators.user'])->limit(8)->get();
        }
        
        $data->average = $average;
        $data->users_count = $users_count;
        $data->rated = $rated;
        $data->not_validated = $not_validated;
        $data->top = $top;

        return $data;
    }
}

if (!function_exists('getRatingsInMarkOrder')) {
    function getRatingsInMarkOrder($phase_id, $org_id, $order): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $rated = Helper::getRatingsByPhase($phase_id)->with('evaluated', 'evaluator', 'phase')->orderBy('rating_mark', $order);
        } else {
            $rated = Helper::getRatingsByPhaseAndOrg($phase_id, $org_id,)->with('evaluated', 'evaluator', 'phase')->orderBy('rating_mark', $order);
        }
        return $rated;
    }
}

//if (!function_exists('getUsersWithRating')) {
//    function getUsersWithRating($phase_id, $org_id, $order): object
//    {
//        if (!isset($org_id) || $org_id == -1) {
//            $users = User::select('user_display_name')->join('ratings', 'ratings.evaluated_id', '=', 'users.user_id')
//                ->where('ratings.phase_id', '=', $phase_id)
//                ->orderBy('ratings.rating_mark', $order);
//        } else {
//            $users = User::select('user_display_name')->join('ratings', 'ratings.evaluated_id', '=', 'users.user_id')
//                ->where('ratings.phase_id', '=', $phase_id)
//                ->whereHas('org', function ($query) use ($org_id) {
//                    $query->where('organisations.org_id', '=', $org_id)
//                        ->orWhere('organisations.parent_id', '=', $org_id);
//                })
//                ->orderBy('ratings.rating_mark', $order);
//        }
//        return $users;
//    }
//}


if (!function_exists('getValidatedRatings')) {
    function getValidatedRatings($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $rated = Helper::getRatingsByPhaseAndStatus($phase_id, 1)->with('evaluated', 'evaluator', 'phase');
        } else {
            $rated = Helper::getRatingsByPhaseAndOrgAndStatus($phase_id, $org_id, 1)->with('evaluated', 'evaluator', 'phase');
        }

        return $rated;
    }
}

if (!function_exists('getPendingRatings')) {
    function getPendingRatings($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $rated = Helper::getRatingsByPhaseAndStatus($phase_id, 0)->with('evaluated', 'evaluator', 'phase', 'validators');
        } else {
            $rated = Helper::getRatingsByPhaseAndOrgAndStatus($phase_id, $org_id, 0)->with('evaluated', 'evaluator', 'phase', 'validators');
        }

        return $rated;
    }
}

if (!function_exists('getUnratedUsers')) {
    function getUnratedUsers($phase_id, $org_id)
    {
        if (!isset($org_id) || $org_id == -1) {
            $unrated = User::where('role_id', '!=', 1)->whereDoesntHave('ratings', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $unrated = User::where('role_id', '!=', 1)->whereDoesntHave('ratings', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            })->whereHas('org', function ($query) use ($org_id) {
                $query->where('organisations.org_id', '=', $org_id)
                    ->orWhere('organisations.parent_id', '=', $org_id);
            });
        }

        return $unrated;
    }
}

if (!function_exists('getAverageChart')) {
    function getAverageChart($average): object
    {
        $result = (object)[];
        $series = [number_format($average, 2)];
        $chartOptions = json_decode('{
            "chart":{
                "height": 350,
                "type": "radialBar"
            },
            "plotOptions": {
                "radialBar": {
                    "hollow": {
                        "size": "80%"
                    },
                    "dataLabels": {
                        "show": true,
                        "name": {
                            "offsetY": -10,
                            "show": true,
                            "fontSize": "25px"
                        },
                        "value": {
                            "fontSize": "40px",
                            "show": true,
                            "color": ""
                        }
                    }
                }
            },
            "colors":[
                "#118a9a"
            ],
            "tooltip": {
                "enabled": true,
                "theme": "dark"
            },
            "labels": ["Moyenne des notes"]
        }');
        $result->series = $series;
        $result->chartOptions = $chartOptions;

        return $result;
    }
}

if (!function_exists('getSkillsData')) {
    function getSkillsDataByType($phase_id, $org_id, $type): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $skills = PhaseSkill::where('phase_id', '=', $phase_id)->whereRelation('skill', 'skill_type_id', '=', $type)->withAvg(['rating_skills' => function ($query) use ($phase_id) {
                Helper::filterByPhase($query, $phase_id);
            }], 'rating_skill_mark')
                ->withMin(['rating_skills' => function ($query) use ($phase_id) {
                    Helper::filterByPhase($query, $phase_id);
                }], 'rating_skill_mark')
                ->withMax(['rating_skills' => function ($query) use ($phase_id) {
                    Helper::filterByPhase($query, $phase_id);
                }], 'rating_skill_mark')
                ->with('skill')->get();
        } else {
            $skills = PhaseSkill::where('phase_id', '=', $phase_id)->whereRelation('skill', 'skill_type_id', '=', $type)->withAvg(['rating_skills' => function ($query) use ($phase_id, $org_id) {
                Helper::filterByPhaseAndOrg($query, $phase_id, $org_id);
            }], 'rating_skill_mark')
                ->withMin(['rating_skills' => function ($query) use ($phase_id) {
                    Helper::filterByPhase($query, $phase_id);
                }], 'rating_skill_mark')
                ->withMax(['rating_skills' => function ($query) use ($phase_id) {
                    Helper::filterByPhase($query, $phase_id);
                }], 'rating_skill_mark')
                ->with('skill')->get();
        }
        return $skills;
    }
}

if (!function_exists('getTrainingsData')) {
    function getTrainingsData($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {

            $trainings = TrainingType::withCount(['trainings as trainings_by_evaluators' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, NULL, 1);
            }, 'trainings as trainings_by_evaluated' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, 1, NULL);
            }, 'trainings as asked_by_both' => function ($query) use ($phase_id) {
                Helper::filterTrainingsByPhaseAndAsker($query, $phase_id, 1, 1);
            }, 'trainings' => function ($query) use ($phase_id) {
                Helper::filterByPhase($query, $phase_id);
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
                Helper::filterByPhaseAndOrg($query, $phase_id, $org_id);
            }])
                ->orHaving('trainings_by_evaluators', '>', 0)
                ->orHaving('trainings_by_evaluated', '>', 0)
                ->orHaving('asked_by_both', '>', 0)
                ->get();
        }
        return $trainings;
    }
}

if (!function_exists('getTrainingsDetails')) {
    function getTrainingsDetails($phase_id, $org_id, $type): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $trainings = Training::where('training_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $trainings = Training::where('training_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $trainings;
    }
}

if (!function_exists('getAllTrainings')) {
    function getAllTrainings($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $trainings = Training::whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $trainings = Training::whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $trainings;
    }
}

if (!function_exists('getClaimsData')) {
    function getClaimsData($phase_id, $org_id): object
    {

        if (!isset($org_id) || $org_id == -1) {
            $claims = ClaimType::withCount(['claims' => function ($query) use ($phase_id) {
                Helper::filterByPhase($query, $phase_id);
            }])->orHaving('claims_count', '>', 0)
                ->get();
        } else {
            $claims = ClaimType::withCount(['claims' => function ($query) use ($phase_id, $org_id) {
                Helper::filterByPhaseAndOrg($query, $phase_id, $org_id);
            }])->orHaving('claims_count', '>', 0)
                ->get();
        }
        return $claims;

    }
}

if (!function_exists('getClaimsDetails')) {
    function getClaimsDetails($phase_id, $org_id, $type): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $claims = Claim::where('claim_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $claims = Claim::where('claim_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $claims;
    }
}

if (!function_exists('getAllClaims')) {
    function getAllClaims($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $claims = Claim::whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $claims = Claim::whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $claims;
    }
}

if (!function_exists('getMobilitiesData')) {
    function getMobilitiesData($phase_id, $org_id): object
    {

        if (!isset($org_id) || $org_id == -1) {
            $mobilities = MobilityType::withCount(['mobilities as mobilities_by_evaluators' => function ($query) use ($phase_id) {
                Helper::filterMobilitiesByPhaseAndAsker($query, $phase_id, 0);
            }, 'mobilities as mobilities_by_evaluated' => function ($query) use ($phase_id) {
                Helper::filterMobilitiesByPhaseAndAsker($query, $phase_id, 1);
            }])
                ->orHaving('mobilities_by_evaluators', '>', 0)
                ->orHaving('mobilities_by_evaluated', '>', 0)
                ->get();
        } else {
            $mobilities = MobilityType::withCount(['mobilities as mobilities_by_evaluators' => function ($query) use ($phase_id, $org_id) {
                Helper::filterMobilitiesByPhaseAndOrgAndAsker($query, $phase_id, $org_id, 0);
            }, 'mobilities as mobilities_by_evaluated' => function ($query) use ($phase_id, $org_id) {
                Helper::filterMobilitiesByPhaseAndOrgAndAsker($query, $phase_id, $org_id, 1);
            }])
                ->orHaving('mobilities_by_evaluators', '>', 0)
                ->orHaving('mobilities_by_evaluated', '>', 0)
                ->get();
        }
        return $mobilities;

    }
}

if (!function_exists('getMobilitiesDetails')) {
    function getMobilitiesDetails($phase_id, $org_id, $type): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $mobilities = Mobility::where('mobility_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $mobilities = Mobility::where('mobility_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $mobilities;
    }
}

if (!function_exists('getAllMobilities')) {
    function getAllMobilities($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $mobilities = Mobility::whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $mobilities = Mobility::whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $mobilities;
    }
}

if (!function_exists('getSanctionsData')) {
    function getSanctionsData($phase_id, $org_id): object
    {

        if (!isset($org_id) || $org_id == -1) {
            $sanctions = SanctionType::withCount(['sanctions' => function ($query) use ($phase_id) {
                Helper::filterByPhase($query, $phase_id);
            }])->orHaving('sanctions_count', '>', 0)
                ->get();
        } else {
            $sanctions = SanctionType::withCount(['sanctions' => function ($query) use ($phase_id, $org_id) {
                Helper::filterByPhaseAndOrg($query, $phase_id, $org_id);
            }])->orHaving('sanctions_count', '>', 0)
                ->get();
        }
        return $sanctions;

    }
}



if (!function_exists('getSanctionsDetails')) {
    function getSanctionsDetails($phase_id, $org_id, $type): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $sanctions = Sanction::where('sanction_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $sanctions = Sanction::where('sanction_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $sanctions;
    }
}



if (!function_exists('getAllSanctions')) {
    function getAllSanctions($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $sanctions = Sanction::whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $sanctions = Sanction::whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $sanctions;
    }
}

if (!function_exists('getPromotionsData')) {
    function getPromotionsData($phase_id, $org_id): object
    {

        if (!isset($org_id) || $org_id == -1) {
            $promotions = PromotionType::withCount([
                'promotions as eligible_and_proposed_count' => function ($query) use ($phase_id) {
                    Helper::filterByPhase($query, $phase_id)->where('rating_promotions.evaluated_is_eligible', '=', 1)->where('rating_promotions.is_proposed', '=', 1);
                }, 'promotions as eligible_and_not_proposed_count' => function ($query) use ($phase_id) {
                    Helper::filterByPhase($query, $phase_id)->where('rating_promotions.evaluated_is_eligible', '=', 1)->where('rating_promotions.is_proposed', '=', 0);
                }, 'promotions as not_eligible_and_proposed_count' => function ($query) use ($phase_id) {
                    Helper::filterByPhase($query, $phase_id)->where('rating_promotions.evaluated_is_eligible', '=', 0)->where('rating_promotions.is_proposed', '=', 1);
                }, 'promotions as not_eligible_and_not_proposed_count' => function ($query) use ($phase_id) {
                    Helper::filterByPhase($query, $phase_id)->where('rating_promotions.evaluated_is_eligible', '=', 0)->where('rating_promotions.is_proposed', '=', 0);
                },
            ])
                ->orHaving('eligible_and_proposed_count', '>', 0)
                ->orHaving('eligible_and_not_proposed_count', '>', 0)
                ->orHaving('not_eligible_and_proposed_count', '>', 0)
                ->orHaving('not_eligible_and_not_proposed_count', '>', 0)
                ->get();
        } else {
            $promotions = PromotionType::withCount([
                'promotions as eligible_and_proposed_count' => function ($query) use ($phase_id, $org_id) {
                    Helper::filterByPhaseAndOrg($query, $phase_id, $org_id)->where('rating_promotions.evaluated_is_eligible', '=', 1)->where('rating_promotions.is_proposed', '=', 1);
                }, 'promotions as eligible_and_not_proposed_count' => function ($query) use ($phase_id, $org_id) {
                    Helper::filterByPhaseAndOrg($query, $phase_id, $org_id)->where('rating_promotions.evaluated_is_eligible', '=', 1)->where('rating_promotions.is_proposed', '=', 0);
                }, 'promotions as not_eligible_and_proposed_count' => function ($query) use ($phase_id, $org_id) {
                    Helper::filterByPhaseAndOrg($query, $phase_id, $org_id)->where('rating_promotions.evaluated_is_eligible', '=', 0)->where('rating_promotions.is_proposed', '=', 1);
                }, 'promotions as not_eligible_and_not_proposed_count' => function ($query) use ($phase_id, $org_id) {
                    Helper::filterByPhaseAndOrg($query, $phase_id, $org_id)->where('rating_promotions.evaluated_is_eligible', '=', 0)->where('rating_promotions.is_proposed', '=', 0);
                },
            ])
                ->orHaving('eligible_and_proposed_count', '>', 0)
                ->orHaving('eligible_and_not_proposed_count', '>', 0)
                ->orHaving('not_eligible_and_proposed_count', '>', 0)
                ->orHaving('not_eligible_and_not_proposed_count', '>', 0)
                ->get();
        }
        return $promotions;

    }
}

if (!function_exists('getPromotionsDetails')) {
    function getPromotionsDetails($phase_id, $org_id, $type): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $promotions = Promotion::where('promotion_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $promotions = Promotion::where('promotion_type_id', '=', $type)->whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $promotions;
    }
}

if (!function_exists('getAllPromotions')) {
    function getAllPromotions($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $promotions = Promotion::whereHas('rating', function ($query) use ($phase_id) {
                Helper::queryByPhase($query, $phase_id);
            });
        } else {
            $promotions = Promotion::whereHas('rating', function ($query) use ($phase_id, $org_id) {
                Helper::queryByPhaseAndOrg($query, $phase_id, $org_id);
            });
        }
        return $promotions;
    }

}

if (!function_exists('getSkillsBarChart')) {
    function getSkillsBarChart($skills, $orientation = true, $reversed = false): object
    {
        $result = (object)[];
        $series = [];
        $series[] = (object)[
            'name' => 'Moyenne de la compétence.',
            'data' => array()
        ];
        foreach ($skills as $s) {
            $series[0]->data[] = (object)[
                'x' => $s->skill->skill_name,
                'y' => number_format($s->rating_skills_avg_rating_skill_mark, 2),
                'goals' => [(object)
                [
                    'name' => 'Barème',
                    'value' => $s->phase_skill_marking,
                    'strokeWidth' => 10,
                    'strokeHeight' => 0,
                    'strokeLineCap' => 'round',
                    'strokeColor' => '#775DD0'
                ], (object)
                [
                    'name' => 'Min',
                    'value' => $s->rating_skills_min_rating_skill_mark,
                    'strokeWidth' => 3,
                    'strokeDashArray' => 0,
                    'strokeColor' => '#dc2626'
                ], (object)
                [
                    'name' => 'Max',
                    'value' => $s->rating_skills_max_rating_skill_mark,
                    'strokeWidth' => 3,
                    'strokeDashArray' => 0,
                    'strokeColor' => '#0d9488'
                ]
                ]
            ];
        }
        $chartOptions = json_decode('{
               "chart":{
                  "type":"bar",
                  "stacked":false,
                  "toolbar":{
                     "show":true
                  }
               },
               "responsive": [{
                  "breakpoint": 480,
                  "options": {
                     "legend": {
                        "position": "bottom",
                        "offsetX": -10,
                        "offsetY": 0
                     }
                  }
               }],
               "tooltip": {
                    "enabled": true,
                    "theme": "dark"
               },
               "plotOptions":{
                  "bar":{
                     "horizontal":true,
                     "distributed":true
                  }
               },
               "colors":[],
               "dataLabels":{
                  "enabled":true
               },
               "yaxis":{
                  "reversed":true
               },
               "yaxis":{
                  "labels": {
                    "style" : {
                      "fontSize": "14px"
                    }
                  }
               },
               "legend":{
                  "show":false,
                  "markers":{
                     "fillColors":[
                        "#06B6D4FF"
                     ]
                  }
               }
            }');
        $chartOptions->plotOptions->bar->horizontal = $orientation;
        $chartOptions->yaxis->reversed = $reversed;
        $chartOptions = (object)$chartOptions;
        $result->series = $series;
        $result->chartOptions = $chartOptions;
        return $result;

    }
}

if (!function_exists('getTrainingsBarChart')) {
    function getTrainingsBarChart($trainings_data): object
    {
        $result = (object)[];
        $series = [];
        $series[] = (object)[
            'name' => 'Besoin exprimé par la hiérarchie.',
            'data' => array()
        ];
        $series[] = (object)[
            'name' => 'Besoin souhaité par les agents.',
            'data' => array()
        ];
        $series[] = (object)[
            'name' => 'Besoin Exprimé par les deux parties.',
            'data' => array()
        ];
        $xaxis = (object)[];
        $xaxis->type = 'string';
        $xaxis->categories = [];
        foreach ($trainings_data as $t) {
            $xaxis->categories[] = $t->training_type_name;
            $series[0]->data[] = $t->trainings_by_evaluators;
            $series[1]->data[] = $t->trainings_by_evaluated;
            $series[2]->data[] = $t->asked_by_both;
        }
        $chartOptions = json_decode('{
               "chart":{
                  "type":"bar",
                  "stacked":true,
                  "toolbar":{
                     "show":true
                  }
               },
               "responsive": [{
                  "breakpoint": 480,
                  "options": {
                     "legend": {
                        "position": "bottom",
                        "offsetX": -10,
                        "offsetY": 0
                     }
                  }
               }],
               "tooltip": {
                    "enabled": true,
                    "theme": "dark"
               },
               "plotOptions":{
                  "bar":{
                     "horizontal":false,
                     "borderRadius": 10,
                     "dataLabels": {
                        "total": {
                           "enabled": true,
                           "style": {
                              "color": "",
                              "fontSize": "13px",
                              "fontWeight": 900
                           }
                        }
                     }
                  }
               },
               "colors":[
                  "#155E75FF",
                  "#06B6D4FF",
                  "#67E8F9FF"
               ],
               "dataLabels":{
                  "enabled":false
               },
               "yaxis":{
                  "labels": {
                    "style" : {
                      "fontSize": "14px"
                    }
                  }
               },
               "xaxis":{
                  "labels": {
                    "style" : {
                      "fontSize": "16px"
                    }
                  }
               },
               "legend":{
                  "show":true,
                  "markers":{
                     "fillColors":[
                        "#155E75FF",
                        "#06B6D4FF",
                        "#67E8F9FF"
                     ]
                  }
               }
            }');
        $chartOptions = (object)$chartOptions;
        $chartOptions->xaxis = $xaxis;
        $result->series = $series;
        $result->chartOptions = $chartOptions;
        return $result;

    }
}

if (!function_exists('getMobilitiesBarChart')) {
    function getMobilitiesBarChart($mobilities_data): object
    {
        $result = (object)[];
        $series = [];
        $series[] = (object)[
            'name' => 'Besoin exprimé par la hiérarchie.',
            'data' => array()
        ];
        $series[] = (object)[
            'name' => 'Besoin souhaité par les agents.',
            'data' => array()
        ];
        $xaxis = (object)[];
        $xaxis->type = 'string';
        $xaxis->categories = [];
        foreach ($mobilities_data as $t) {
            $xaxis->categories[] = $t->mobility_type_name;
            $series[0]->data[] = $t->mobilities_by_evaluators;
            $series[1]->data[] = $t->mobilities_by_evaluated;
        }
        $chartOptions = json_decode('{
               "chart":{
                  "type":"bar",
                  "stacked":true,
                  "toolbar":{
                     "show":true
                  }
               },
               "responsive": [{
                  "breakpoint": 480,
                  "options": {
                     "legend": {
                        "position": "bottom",
                        "offsetX": -10,
                        "offsetY": 0
                     }
                  }
               }],
               "tooltip": {
                    "enabled": true,
                    "theme": "dark"
               },
                "yaxis":{
                  "labels": {
                    "style" : {
                      "fontSize": "14px"
                    }
                  }
               },
               "xaxis":{
                  "labels": {
                    "style" : {
                      "fontSize": "14px"
                    }
                  }
               },
               "plotOptions":{
                  "bar":{
                     "horizontal":false,
                     "borderRadius": 10,
                     "dataLabels": {
                        "total": {
                           "enabled": true,
                           "style": {
                              "color": "",
                              "fontSize": "13px",
                              "fontWeight": 900
                           }
                        }
                     }
                  }
               },
               "colors":[
                  "#155E75FF",
                  "#06B6D4FF"
               ],
               "dataLabels":{
                  "enabled":false
               },
               "legend":{
                  "show":true,
                  "markers":{
                     "fillColors":[
                        "#155E75FF",
                        "#06B6D4FF"
                     ]
                  }
               }
            }');
        $chartOptions = (object)$chartOptions;
        $chartOptions->xaxis = $xaxis;
        $result->series = $series;
        $result->chartOptions = $chartOptions;
        return $result;
    }
}

if (!function_exists('getClaimsPieChart')) {
    function getClaimsPieChart($claims_data): object
    {
        $result = (object)[];
        $data = [];
        $labels = [];

        foreach ($claims_data as $claim) {
            $labels[] = $claim->claim_type_name;
            $data[] = $claim->claims_count;
        }

        $chartOptions = json_decode('{
            "chart": {
                "width": 380,
                "type": "pie",
                "toolbar":{
                     "show":true
                }
            },
            "tooltip": {
                "enabled": true,
                "theme": "dark"
            },
            "legend": {
                "fontSize": "16px"
            },
            "labels": [],
            "colors":[
              "#175562",
              "#166674",
              "#118a9a",
              "#0aa0b0",
              "#09c8d1",
              "#25e5eb",
              "#69f5f7",
              "#a6fafb"
            ]
          }');
        $chartOptions->labels = $labels;
        $result->series = $data;
        $result->chartOptions = (object)$chartOptions;
        return $result;

    }
}

if (!function_exists('getSanctionsPieChart')) {
    function getSanctionsPieChart($sanctions_data): object
    {
        $result = (object)[];
        $data = [];
        $labels = [];

        foreach ($sanctions_data as $sanction) {
            $labels[] = $sanction->sanction_type_name;
            $data[] = $sanction->sanctions_count;
        }

        $chartOptions = json_decode('{
            "chart": {
                "width": 380,
                "type": "pie",
                "toolbar":{
                     "show":true
                }
            },
            "tooltip": {
                "enabled": true,
                "theme": "dark"
            },
            "legend": {
                "fontSize": "16px"
            },
            "labels": [],
            "colors":[
              "#166674",
              "#118a9a",
              "#0aa0b0",
              "#09c8d1",
              "#25e5eb",
              "#69f5f7",
              "#a6fafb"
            ]
          }');
        $chartOptions->labels = $labels;
        $result->series = $data;
        $result->chartOptions = (object)$chartOptions;
        return $result;

    }
}

if (!function_exists('getPromotionsPieChartByType')) {
    function getPromotionsPieChartByType($promotions_data, $type): object
    {
        $result = (object)[];
        $data = [];
        $labels = ['Éligibles et Proposés', 'Éligibles et Non Proposés', 'Non Éligibles et Proposés', 'Non Éligibles et Non Proposés'];
        foreach ($promotions_data as $promotion) {
            if ($promotion->promotion_type_id !== $type) continue;
            $data[] = $promotion->eligible_and_proposed_count;
            $data[] = $promotion->eligible_and_not_proposed_count;
            $data[] = $promotion->not_eligible_and_proposed_count;
            $data[] = $promotion->not_eligible_and_not_proposed_count;
        }

        $chartOptions = json_decode('{
            "chart": {
                "width": 380,
                "type": "pie",
                "toolbar":{
                     "show":true
                }
            },
            "tooltip": {
                "enabled": true,
                "theme": "dark"
            },
            "legend": {
                "fontSize": "16px"
            },
            "labels": [],
            "colors":[
              "#166674",
              "#118a9a",
              "#0aa0b0",
              "#09c8d1",
              "#25e5eb",
              "#69f5f7",
              "#a6fafb"
            ]
          }');
        $chartOptions->labels = $labels;
        $result->series = $data;
        $result->chartOptions = (object)$chartOptions;
//        dd($result);
        return $result;

    }
}
