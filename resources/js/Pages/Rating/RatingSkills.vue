<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {computed, ref, watch} from "vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid/index.js";
import Tabs from "@/Components/Rating/Tabs.vue";
import Title from "@/Components/Rating/Title.vue";
import SectionMark from "@/Components/Rating/SectionMark.vue";
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

const pages = [
    { name: 'Mes Evaluations', href: route('ratings.index'), current: false },
    { name: 'Rating', href: '#', current: true },
]

const goalsTotal = computed(() => {
    let total = 0;
    props.goals.forEach(goal => total += goal.goal_mark)
    return total;
})

const commentForm = useForm({
    evaluated_comment: props.rating.evaluated_comment || '',
})

const submitEval = () => {
    commentForm.put(route('ratings.update',{
        agent: props.agent.user_id,
        rating: props.rating.rating_id
    }),{
        onError: err => {
            usePage().props.flash.notify = {type: 'error',message: err.phase_skill_id}
        },
    })
}

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profil"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <Title :agent="agent" :rating="rating" />
            <Tabs :rating_id="rating.rating_id" :agent_id="agent.user_id" :evaluated="true"/>
            <div role="list">
                <div class="px-4 py-4 sm:px-0">
                    <SectionMark title="Compétences Spécifiques (Savoir, Savoir Faire, Savoir Être)" :mark="rating.specific_skills_sum_rating_skill_mark" :marking="marking.specific"/>
                    <ul role="list" class="divide-y divide-gray-100">
                        <li v-for="skill in specific_skills " :key="skill.rating_skill_id" class="flex items-center justify-between gap-x-6 py-5">
                            <div class="min-w-0">
                                <div class="flex items-start gap-x-3">
                                    <p class="text-base font-bold leading-6 text-gray-900">{{ skill.phase_skill.skill.skill_name }}</p>
                                    <p v-if="skill.rating_skill_mark_is_claimed" class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">Contesté</p>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
                                    <p class="whitespace-break-spaces">
                                        {{ skill.phase_skill.skill.skill_desc }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-none items-center gap-x-4">
                                <div class="flex items-center justify-center space-x-4">
                                    <p class="ml-0.5 font-bold"> {{ skill.rating_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }} </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="px-4 py-4 sm:px-0">
                    <SectionMark title="Compétences Générales" :mark="rating.general_skills_sum_rating_skill_mark" :marking="marking.general"/>
                    <ul role="list" class="divide-y divide-gray-100">
                        <li v-for="skill in skills " :key="skill.rating_skill_id" class="flex items-center justify-between gap-x-6 py-5">
                            <div class="min-w-0">
                                <div class="flex items-start gap-x-3">
                                    <p class="text-base font-bold leading-6 text-gray-900">{{ skill.phase_skill.skill.skill_name }}</p>
                                    <p v-if="skill.rating_skill_mark_is_claimed" class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">Contesté</p>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
                                    <p class="whitespace-break-spaces">
                                        {{ skill.phase_skill.skill.skill_desc }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex flex-none items-center gap-x-4">
                                <div class="flex items-center justify-center space-x-4">
                                    <p class="ml-0.5 font-bold"> {{ skill.rating_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }} </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="px-4 py-4 sm:px-0">
                    <SectionMark title="Performances" :mark="goalsTotal" :marking="marking.perf"/>
                    <ul role="list" class="divide-y divide-gray-100">
                        <li v-for="goal in goals " :key="goal.goal_id" class="flex items-center justify-between gap-x-6 py-5">
                            <div class="min-w-0">
                                <div class="flex items-start gap-x-3">
                                    <p class="text-base font-bold leading-6 text-gray-900">{{ goal.goal_name }}</p>
                                    <p  class="text-gray-700 bg-gray-50 ring-gray-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
                                        {{ goal.period.evaluation_period_name }}
                                    </p>
                                    <p v-if="goal.goal_mark_is_claimed" class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
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
                </div>
            </div>
            <div class="px-4 py-4 sm:px-0">
                <SectionMark title="Commentaires" />
                <form class="mt-8 bg-white shadow sm:rounded-lg" @submit.prevent="submitEval">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Commentaire Évaluateur</h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>Commentaire de {{rating.evaluator.user_display_name}} </p>
                            </div>
                            <div class="mt-5 sm:flex sm:items-center">
                                <div class="w-full sm:max-w-xl">
                                    <div class="col-span-full">
                                        <InputLabel for="start_date"></InputLabel>
                                        <div class="relative mt-2">
                                            <TextArea :disabled="true" v-model="evaluatorComment" />
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Commentaire Évalué</h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>Ajouter un commentaire. </p>
                            </div>
                            <div class="mt-5 sm:flex sm:items-center">
                                <div class="w-full sm:max-w-xl">
                                    <div class="col-span-full">
                                        <InputLabel for="start_date"></InputLabel>
                                        <div class=" mt-2">
                                            <TextArea v-model="commentForm.evaluated_comment" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications />
                        <SubmitButton type="submit" class="mt-3 sm:ml-3 sm:mt-0 sm:w-auto">Enregistrer</SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
