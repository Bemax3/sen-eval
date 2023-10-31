<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, usePage} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {CheckIcon, ChevronDoubleRightIcon, PencilSquareIcon} from "@heroicons/vue/20/solid/index.js";
import {ref} from "vue";

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
    }
})

const pages = [
    { name: 'Mes Agents', href: route('agents.index'), current: false },
    { name: 'Evaluations', href: route('evaluation.index',{agent: props.agent.user_id}), current: false },
    { name: 'Evaluation', href: '#', current: true },
]

const tabs = [
    { name: 'Compétences', href: '#', current: true },
    { name: 'Réclamations', href: '#', current: false },
    { name: 'Formations', href: '#', current: false },
    { name: 'Mobilités', href: '#', current: false },
    { name: 'Sanctions', href: '#', current: false },
]


const edits = ref([]);
const inputs = ref([]);

const setupEdits = () => {
    props.skills.forEach(item => edits.value.push({id: item.evaluation_skill_id,edit: item.evaluation_skill_mark <= 0 }))
}

setupEdits();
const editMark = (id) => {
    return edits.value.filter(s => s.id === id)[0].edit
}

const updateMark = (id,marking) => {
    const input = inputs.value[id];
    edits.value.find(s => s.id === id).edit = false;
    router.put(
        route('evaluationSkill.update',{evaluationSkill: id}),
        {evaluation_skill_mark : input.value, evaluation_skill_marking: marking},
        {
            onError: err => {
                usePage().props.flash.notify = {type: 'error',message: err.evaluation_skill_mark}
            },
            onSuccess: () => search.keyword = ''
        }
    );

}


</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profil"/>
        <Breadcrumbs :pages="pages"/>
	    <div class="sm:flex sm:items-center">
		    <div class="sm:flex-auto">
			    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Evaluation de {{agent.user_first_name + ' ' + agent.user_last_name}}. Année : {{evaluation.phase.phase_year}}</h1>
			    <p class="mt-2 text-sm text-gray-700">
				    Evaluation de {{agent.user_first_name + ' ' + agent.user_last_name}}. Matricule : {{agent.user_matricule}}. Année : {{evaluation.phase.phase_year}}
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
	    <div class="px-4 sm:px-6 lg:px-8">
        <div role="list" class="divide-y divide-cyan-600">
	        <div class="px-4 py-4 sm:px-0">
		        <div class="border-b border-cyan-600 bg-white px-4 py-5 sm:px-6">
			        <h3 class="text-base font-semibold leading-6 text-gray-900">Compétences Spécifiques</h3>
		        </div>
		        <ul role="list" class="divide-y divide-gray-100">
			        <li v-for="skill in specific_skills " :key="skill.evaluation_skill_id" class="flex items-center justify-between gap-x-6 py-5">
				        <div class="min-w-0">
					        <div class="flex items-start gap-x-3">
						        <p class="text-lg font-bold leading-6 text-gray-900">{{ skill.phase_skill.skill.skill_name }}</p>
						        <!--                                <p :class="[statuses[project.status], 'rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset']">{{ project.status }}</p>-->
					        </div>
					        <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
						        <p class="whitespace-break-spaces">
							        {{ skill.phase_skill.skill.skill_desc }}
						        </p>
						        <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
							        <circle cx="1" cy="1" r="1" />
						        </svg>
						        <!--                                <p class="truncate">Created by {{ project.createdBy }}</p>-->
					        </div>
				        </div>
				        <div class="flex flex-none items-center gap-x-4">
					        <div class="flex items-center justify-center space-x-4">
						        <template v-if="!editMark(skill.evaluation_skill_id)">
							        {{ skill.evaluation_skill_mark }}
						        </template>
						        <template v-else>
							        <input :ref="el => {inputs[skill.evaluation_skill_id] = el}" type="text" :value="skill.evaluation_skill_mark" class=" w-10 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" />
						        </template>
						        <p class="ml-0.5 font-bold">
							        / {{ skill.phase_skill.phase_skill_marking }}
						        </p>
						        <template v-if="!editMark(skill.evaluation_skill_id)">
							        <button @click="edits.find(s => s.id === skill.evaluation_skill_id).edit = true" type="button" class="rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
								        <PencilSquareIcon class="h-5 w-5" aria-hidden="true" />
							        </button>
						        </template>
						        <template v-else>
							        <button @click="updateMark(skill.evaluation_skill_id,skill.phase_skill.phase_skill_marking)" type="button" class="rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
								        <CheckIcon class="h-5 w-5" aria-hidden="true"/>
							        </button>
						        </template>
					        </div>
				        </div>
			        </li>
		        </ul>
	        </div>
            <div class="px-4 py-4 sm:px-0">
                <div class="border-b border-cyan-600 bg-white px-4 py-5 sm:px-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Compétences Générales</h3>
                </div>
                <ul role="list" class="divide-y divide-gray-100">
                    <li v-for="skill in skills " :key="skill.evaluation_skill_id" class="flex items-center justify-between gap-x-6 py-5">
                        <div class="min-w-0">
                            <div class="flex items-start gap-x-3">
                                <p class="text-lg font-bold leading-6 text-gray-900">{{ skill.phase_skill.skill.skill_name }}</p>
<!--                                <p :class="[statuses[project.status], 'rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset']">{{ project.status }}</p>-->
                            </div>
                            <div class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                <p class="whitespace-break-spaces">
                                    {{ skill.phase_skill.skill.skill_desc }}
                                </p>
                                <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">
                                    <circle cx="1" cy="1" r="1" />
                                </svg>
<!--                                <p class="truncate">Created by {{ project.createdBy }}</p>-->
                            </div>
                        </div>
                        <div class="flex flex-none items-center gap-x-4">
                            <div class="flex items-center justify-center space-x-4">
                                <template v-if="!editMark(skill.evaluation_skill_id)">
                                    {{ skill.evaluation_skill_mark }}
                                </template>
                                <template v-else>
                                    <input :ref="el => {inputs[skill.evaluation_skill_id] = el}" type="text" :value="skill.evaluation_skill_mark" class=" w-10 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" />
                                </template>
                                <p class="ml-0.5 font-bold">
                                    / {{ skill.phase_skill.phase_skill_marking }}
                                </p>
                                <template v-if="!editMark(skill.evaluation_skill_id)">
                                    <button @click="edits.find(s => s.id === skill.evaluation_skill_id).edit = true" type="button" class="rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                        <PencilSquareIcon class="h-5 w-5" aria-hidden="true" />
                                    </button>
                                </template>
                                <template v-else>
                                    <button @click="updateMark(skill.evaluation_skill_id,skill.phase_skill.phase_skill_marking)" type="button" class="rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                        <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="px-4 py-4 sm:px-0">
                <!-- Your content -->
            </div>
        </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
