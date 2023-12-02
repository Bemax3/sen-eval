<?php

use App\Models\Phase\PhaseSkill;
use App\Models\Settings\ClaimType;
use App\Models\Settings\MobilityType;
use App\Models\Settings\PromotionType;
use App\Models\Settings\SanctionType;
use App\Models\Settings\TrainingType;
use App\Models\User;
use App\Services\Dashboard\Helper;

if (!function_exists('getRatingsData')) {
    function getRatingsData($phase_id, $org_id): object
    {
        $data = (object)[];
        if (!isset($org_id) || $org_id == -1) {
            $users_count = User::where('role_id', '!=', 1)->count();
            $rated = Helper::getRatingsByPhaseAndStatus($phase_id, 1)->count();
            $not_validated = Helper::getRatingsByPhaseAndStatus($phase_id, 0)->count();
            $average = Helper::getRatingsByPhase($phase_id)->avg('rating_mark');
            $top = Helper::getRatingsByPhase($phase_id)->orderBy('rating_mark', 'desc')->with('evaluated')->limit(8)->get();
        } else {
            $users_count = User::where('role_id', '!=', 1)->whereHas('org', function ($query) use ($org_id) {
                $query->where('organisations.org_id', '=', $org_id)
                    ->orWhere('organisations.parent_id', '=', $org_id);
            })->count();
            $rated = Helper::getRatingsByPhaseAndOrgAndStatus($phase_id, $org_id, 1)->count();
            $not_validated = Helper::getRatingsByPhaseAndOrgAndStatus($phase_id, $org_id, 0)->count();
            $average = Helper::getRatingsByPhaseAndOrg($phase_id, $org_id)->avg('rating_mark');
            $top = Helper::getRatingsByPhaseAndOrg($phase_id, $org_id)->orderBy('rating_mark', 'desc')->with('evaluated')->limit(8)->get();
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
    function getRatingsInMarkOrder($phase_id, $org_id): object
    {
        if (!isset($org_id) || $org_id == -1) {
            $rated = Helper::getRatingsByPhase($phase_id)->with('evaluated', 'evaluator', 'phase')->orderBy('rating_mark', 'desc');
        } else {
            $rated = Helper::getRatingsByPhaseAndOrg($phase_id, $org_id,)->with('evaluated', 'evaluator', 'phase')->orderBy('rating_mark', 'desc');
        }
        return $rated;
    }
}

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
            $rated = Helper::getRatingsByPhaseAndStatus($phase_id, 0)->with('evaluated', 'evaluator', 'phase');
        } else {
            $rated = Helper::getRatingsByPhaseAndOrgAndStatus($phase_id, $org_id, 0)->with('evaluated', 'evaluator', 'phase');
        }

        return $rated;
    }
}

if (!function_exists('getUnratedUsers')) {
    function getUnratedUsers($phase_id, $org_id)
    {
        if (!isset($org_id) || $org_id == -1) {
            $unrated = User::where('role_id', '!=', 1)->whereDoesntHave('ratings', function ($query) use ($phase_id) {
                $query->where('ratings.phase_id', '=', $phase_id);
            });
        } else {
            $unrated = User::where('role_id', '!=', 1)->whereDoesntHave('ratings', function ($query) use ($phase_id) {
                $query->where('ratings.phase_id', '=', $phase_id);
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
                        "size": "70%"
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
            "labels": ["Moyenne"]
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
            }], 'rating_skill_mark')->with('skill')->get();
        } else {
            $skills = PhaseSkill::where('phase_id', '=', $phase_id)->whereRelation('skill', 'skill_type_id', '=', $type)->withAvg(['rating_skills' => function ($query) use ($phase_id, $org_id) {
                Helper::filterByPhaseAndOrg($query, $phase_id, $org_id);
            }], 'rating_skill_mark')->with('skill')->get();
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

if (!function_exists('getPromotionsData')) {
    function getPromotionsData($phase_id, $org_id): object
    {

        if (!isset($org_id) || $org_id == -1) {
            $promotions = PromotionType::withCount(['promotions as eligible_count' => function ($query) use ($phase_id) {
                Helper::filterByPhase($query, $phase_id)->where('rating_promotions.evaluated_is_eligible', '=', 1);
            }, 'promotions as others' => function ($query) use ($phase_id) {
                Helper::filterByPhase($query, $phase_id)->where('rating_promotions.evaluated_is_eligible', '=', 0);
            }])
                ->orHaving('eligible_count', '>', 0)
                ->orHaving('others', '>', 0)
                ->get();
        } else {
            $promotions = PromotionType::withCount(['promotions as eligible_count' => function ($query) use ($phase_id, $org_id) {
                Helper::filterByPhaseAndOrg($query, $phase_id, $org_id)->where('rating_promotions.evaluated_is_eligible', '=', 1);
            }, 'promotions as others' => function ($query) use ($phase_id, $org_id) {
                Helper::filterByPhaseAndOrg($query, $phase_id, $org_id)->where('rating_promotions.evaluated_is_eligible', '=', 0);
            }
            ])
                ->orHaving('eligible_count', '>', 0)
                ->orHaving('others', '>', 0)
                ->get();
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
                    'strokeWidth' => 3,
                    'strokeDashArray' => 0,
                    'strokeColor' => '#775DD0'
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
                     "horizontal":true
                  }
               },
               "colors":[
                  "#06B6D4FF"
               ],
               "dataLabels":{
                  "enabled":true
               },
               "yaxis":{
                  "reversed":true
               },
               "legend":{
                  "show":true,
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
        $labels = ['Éligibles', 'Non Éligibles'];
        foreach ($promotions_data as $promotion) {
            if ($promotion->promotion_type_id !== $type) continue;
            $data[] = $promotion->eligible_count;
            $data[] = $promotion->others;
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
