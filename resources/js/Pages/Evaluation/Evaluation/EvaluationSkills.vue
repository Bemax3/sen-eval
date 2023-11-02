<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {CheckIcon, ChevronDoubleRightIcon, ChevronUpDownIcon, PencilSquareIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import {computed, ref, watch} from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";

const props = defineProps({
    evaluation: {
        type: Object,
    },
    agent: {
        type: Object,
    },
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

// const isEvaluated = computed(() => {
//     return props.user_id === props.evaluation.evaluated_id;
// })

const pages = [
    { name: 'Mes Evaluations', href: route('rating.index'), current: false },
    { name: 'Evaluation', href: '#', current: true },
]

const tabs = [
    { name: 'Compétences', href: '#', current: true },
    { name: 'Réclamations', href: '#', current: false },
    { name: 'Formations', href: '#', current: false },
    { name: 'Mobilités', href: '#', current: false },
    { name: 'Sanctions', href: '#', current: false },
]

const goalsTotal = computed(() => {
    let total = 0;
    props.goals.forEach(goal => total += goal.goal_mark)
    return total;
})

// const edits = ref([]);
// const inputs = ref([]);
//
// const setupEdits = () => {
// 	edits.value = [];
//     props.skills.forEach(item => edits.value.push({id: item.evaluation_skill_id,edit: item.evaluation_skill_mark <= 0 }))
//     props.goals.forEach(item => edits.value.push({id: 'goal_' + item.goal_id,edit: item.goal_mark <= 0 }))
//     props.specific_skills.forEach(item => edits.value.push({id: item.evaluation_skill_id,edit: item.evaluation_skill_mark <= 0 }))
// }
//
// setupEdits();
// const editMark = (id) => {
//     return edits.value.filter(s => s.id === id)[0].edit
// }

// const updateMark = (id,marking) => {
//     const input = inputs.value[id];
//     edits.value.find(s => s.id === id).edit = false;
//
//     router.put(
//         route('evaluationSkill.update',{evaluationSkill: id}),
//         {evaluation_skill_mark : input.value, evaluation_skill_marking: marking},
//         {
// 			onSuccess: () => setupEdits(),
//             onError: err => {
// 				setupEdits();
// 				console.log(err)
//                 usePage().props.flash.notify = {type: 'error',message: err.evaluation_skill_mark}
//             },
//             preserveScroll: true
//         }
//     );
//
// }

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profil"/>
        <div class="px-4 sm:px-6 lg:px-8">
        <Breadcrumbs :pages="pages"/>
	    <div class="sm:flex sm:items-center">
		    <div class="sm:flex-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">
                        Evaluation de {{agent.user_display_name}}. Année : {{evaluation.phase.phase_year}}
                    </h1>
                    <span class="flex-shrink-0">
                        <span class="flex h-20 w-20 items-center justify-center rounded-full border-4 border-cyan-600">
                            <span class="text-cyan-600 text-2xl font-bold">{{ evaluation.evaluation_mark }}</span>
                        </span>
                    </span>
                </div>
			    <p class="mt-2 text-sm text-gray-700">
				    Evalué par {{evaluation.evaluator.user_display_name}}. Matricule : {{evaluation.evaluator.user_matricule}}.
			    </p>
		    </div>
	    </div>
        <div class="border-b border-gray-200 pb-5 sm:pb-0">
            <div class="mt-3 sm:mt-4">
                <div class="sm:hidden">
                    <label for="current-tab" class="sr-only">Select a tab</label>
                    <select id="current-tab" name="current-tab" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-cyan-500 focus:outline-none focus:ring-cyan-500 sm:text-sm">
                        <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav class="-mb-px flex space-x-8">
                        <Link v-for="tab in tabs" :key="tab.name" :href="tab.href" :class="[tab.current ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium']" :aria-current="tab.current ? 'page' : undefined">{{ tab.name }}</Link>
                    </nav>
                </div>
            </div>
        </div>
        <div role="list">
	        <div class="px-4 py-4 sm:px-0">
		        <div class="border-b border-cyan-600 bg-white pr-4 py-2 sm:pr-6 flex justify-between items-center">
			        <h3 class="text-lg font-semibold leading-6 text-gray-900">
                        Compétences Spécifiques
                    </h3>
			        <span class="flex-shrink-0">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                            <span class="text-cyan-600">{{ evaluation.specific_skills_sum_evaluation_skill_mark }}</span>
                        </span>
                    </span>
		        </div>
		        <ul role="list" class="divide-y divide-gray-100">
			        <li v-for="skill in specific_skills " :key="skill.evaluation_skill_id" class="flex items-center justify-between gap-x-6 py-5">
				        <div class="min-w-0">
					        <div class="flex items-start gap-x-3">
						        <p class="text-base font-bold leading-6 text-gray-900">{{ skill.phase_skill.skill.skill_name }}</p>
						        <p v-if="skill.evaluation_skill_mark_is_claimed" class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">Contesté</p>
					        </div>
					        <div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
						        <p class="whitespace-break-spaces">
							        {{ skill.phase_skill.skill.skill_desc }}
						        </p>
					        </div>
				        </div>
				        <div class="flex flex-none items-center gap-x-4">
					        <div class="flex items-center justify-center space-x-4">
                                <p class="ml-0.5 font-bold"> {{ skill.evaluation_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }} </p>
					        </div>
				        </div>
			        </li>
		        </ul>
	        </div>
            <div class="px-4 py-4 sm:px-0">
                <div class="border-b border-cyan-600 bg-white pr-4 py-2 sm:pr-6 flex justify-between">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900">Compétences Générales</h3>
	                <span class="flex-shrink-0">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                            <span class="text-cyan-600">{{ evaluation.general_skills_sum_evaluation_skill_mark }}</span>
                        </span>
                    </span>
                </div>
                <ul role="list" class="divide-y divide-gray-100">
                    <li v-for="skill in skills " :key="skill.evaluation_skill_id" class="flex items-center justify-between gap-x-6 py-5">
                        <div class="min-w-0">
                            <div class="flex items-start gap-x-3">
                                <p class="text-base font-bold leading-6 text-gray-900">{{ skill.phase_skill.skill.skill_name }}</p>
                                <p v-if="skill.evaluation_skill_mark_is_claimed" class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">Contesté</p>
                            </div>
                            <div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
                                <p class="whitespace-break-spaces">
                                    {{ skill.phase_skill.skill.skill_desc }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-none items-center gap-x-4">
                            <div class="flex items-center justify-center space-x-4">
                                <p class="ml-0.5 font-bold"> {{ skill.evaluation_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }} </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="px-4 py-4 sm:px-0">
                <div class="border-b border-cyan-600 bg-white pr-4 py-2 sm:pr-6 flex justify-between">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900">Performances</h3>
                    <span class="flex-shrink-0">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                            <span class="text-cyan-600">{{ goalsTotal }}</span>
                        </span>
                    </span>
                </div>
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
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
