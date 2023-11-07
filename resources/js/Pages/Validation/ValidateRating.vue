<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {computed} from "vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid/index.js";
import Tabs from "@/Components/Rating/Tabs.vue";
import Title from "@/Components/Rating/Title.vue";
import SectionMark from "@/Components/Rating/SectionMark.vue";
import {hasData} from "@/helpers/helper.js";
import EmptyState from "@/Components/Common/EmptyState.vue";

const props = defineProps({
    rating: {
        type: Object,
    },
    agent: {
        type: Object,
    },
    marking: {},
    specific_skills: {
        type: Object,
    },
    skills: {
        type: Object
    },
    goals: {
        type: Object
    }
})

const evaluatorComment = props.rating.evaluator_comment || '';
const evaluatedComment = props.rating.evaluated_comment || '';

const pages = [
    {name: 'Mes Evaluations', href: route('ratings.index'), current: false},
    {name: 'Rating', href: '#', current: true},
]

const goalsTotal = computed(() => {
    let total = 0;
    props.goals.forEach(goal => total += goal.goal_mark)
    return total;
})

const validation = useForm({
    validated_by_n2: props.rating.validated_by_n2 === 1,
})

const validateRating = () => {
    validation.put(route('ratings.update', {
        rating: props.rating.rating_id
    }), {
        onError: err => console.log(err)
    })
}

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profil"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <Title :agent="agent" :rating="rating"/>
            <Tabs :agent_id="agent.user_id" :rating_id="rating.rating_id" :validator="true"/>
            <div role="list">
                <div class="px-4 py-4 sm:px-0">
                    <SectionMark :mark="rating.specific_skills_sum_rating_skill_mark"
                                 :marking="marking.specific"
                                 title="Compétences Spécifiques (Savoir, Savoir Faire, Savoir Être)"/>
                    <ul v-if="hasData(specific_skills)" class="divide-y divide-gray-100" role="list">
                        <li v-for="skill in specific_skills " :key="skill.rating_skill_id"
                            class="flex items-center justify-between gap-x-6 py-5">
                            <div class="min-w-0">
                                <div class="flex items-start gap-x-3">
                                    <p class="text-base font-bold leading-6 text-gray-900">
                                        {{ skill.phase_skill.skill.skill_name }}
                                    </p>
                                    <p v-if="skill.rating_skill_mark_is_claimed"
                                       class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
                                        Contesté</p>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
                                    <p class="whitespace-break-spaces">
                                        {{ skill.phase_skill.skill.skill_desc }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-none items-center gap-x-4">
                                <div class="flex items-center justify-center space-x-4">
                                    <p class="ml-0.5 font-bold">
                                        {{ skill.rating_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <EmptyState v-else message="Les compétences évaluées s'afficheront ici."
                                title="Pas encore de compétences évaluées."/>
                </div>
                <div class="px-4 py-4 sm:px-0">
                    <SectionMark :mark="rating.general_skills_sum_rating_skill_mark" :marking="marking.general"
                                 title="Compétences Générales"/>
                    <ul class="divide-y divide-gray-100" role="list">
                        <li v-for="skill in skills " :key="skill.rating_skill_id"
                            class="flex items-center justify-between gap-x-6 py-5">
                            <div class="min-w-0">
                                <div class="flex items-start gap-x-3">
                                    <p class="text-base font-bold leading-6 text-gray-900">
                                        {{ skill.phase_skill.skill.skill_name }}
                                    </p>
                                    <p v-if="skill.rating_skill_mark_is_claimed"
                                       class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
                                        Contesté</p>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
                                    <p class="whitespace-break-spaces">
                                        {{ skill.phase_skill.skill.skill_desc }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-none items-center gap-x-4">
                                <div class="flex items-center justify-center space-x-4">
                                    <p class="ml-0.5 font-bold">
                                        {{ skill.rating_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="px-4 py-4 sm:px-0">
                    <SectionMark :mark="goalsTotal" :marking="marking.perf" title="Performances"/>
                    <ul v-if="hasData(goals)" class="divide-y divide-gray-100" role="list">
                        <li v-for="goal in goals " :key="goal.goal_id"
                            class="flex items-center justify-between gap-x-6 py-5">
                            <div class="min-w-0">
                                <div class="flex items-start gap-x-3">
                                    <p class="text-base font-bold leading-6 text-gray-900">{{ goal.goal_name }}</p>
                                    <p class="text-gray-700 bg-gray-50 ring-gray-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
                                        {{ goal.period.evaluation_period_name }}
                                    </p>
                                    <p v-if="goal.goal_mark_is_claimed"
                                       class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
                                        Contesté
                                    </p>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
                                    <p class="whitespace-break-spaces">
                                        {{ goal.goal_expected_result }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-none items-center gap-x-4">
                                <div class="flex items-center justify-center space-x-4">
                                    <p class="ml-0.5 font-bold"> {{ goal.goal_mark }} / {{ goal.goal_marking }} </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <EmptyState v-else
                                message="Les objectifs que l'évaluateur aura crée pour l'évalué s'afficherons automatiquement ici."
                                title="Pas encore d'objectif."/>
                </div>
            </div>
            <div class="px-4 py-4 sm:px-0">
                <SectionMark title="Commentaires"/>
                <form class="mt-8 bg-white shadow sm:rounded-lg">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Commentaire Évaluateur</h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>Commentaire de {{ rating.evaluator.user_display_name }} </p>
                            </div>
                            <div class="mt-5 sm:flex sm:items-center">
                                <div class="w-full sm:max-w-xl">
                                    <div class="col-span-full">
                                        <InputLabel for="start_date"></InputLabel>
                                        <div class="relative mt-2">
                                            <TextArea v-model="evaluatorComment" :disabled="true"/>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Commentaire Évalué</h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>Commentaire de {{ rating.evaluated.user_display_name }}</p>
                            </div>
                            <div class="mt-5 sm:flex sm:items-center">
                                <div class="w-full sm:max-w-xl">
                                    <div class="col-span-full">
                                        <InputLabel for="start_date"></InputLabel>
                                        <div class="relative mt-2">
                                            <TextArea v-model="evaluatedComment" :disabled="true"/>
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="px-4 py-4 sm:px-0">
                <SectionMark title="Validation"/>
                <form class="mt-8 bg-white shadow-xl sm:rounded-lg" @submit.prevent="validateRating">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="px-4 py-5 sm:p-6">
                            <div class=" mt-3 flex items-center">
                                <input id="remember-n1" v-model="validation.validated_by_n2"
                                       class="h-4 w-4 rounded border-gray-300 text-cyan-600 focus:ring-cyan-600"
                                       name="remember-n1"
                                       type="checkbox"/>
                                <label class="ml-3 block text-sm leading-6 text-gray-900" for="remember-n1">Valider
                                    l'évaluation</label>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications/>
                        <SubmitButton class="mt-3 sm:ml-3 sm:mt-0 sm:w-auto" type="submit">Enregistrer</SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
