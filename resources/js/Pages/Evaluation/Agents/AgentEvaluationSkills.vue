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
    bareme: {
        type: Object
    },
    agent: {
        type: Object,
    },
    specific_skill_types: {},
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

console.log(props.bareme);

// const isEvaluated = computed(() => {
//     return props.user_id === props.evaluation.evaluated_id;
// })

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

const form = useForm({
    evaluation_id: props.evaluation.evaluation_id,
    phase_skill_id: props.specific_skill_types[0].pivot.phase_skill_id,
})

const goalsTotal = computed(() => {
    let total = 0;
    props.goals.forEach(goal => total += goal.goal_mark)
    return total;
})

const edits = ref([]);
const inputs = ref([]);

const setupEdits = () => {
    edits.value = [];
    props.skills.forEach(item => edits.value.push({id: item.evaluation_skill_id,edit: item.evaluation_skill_mark <= 0 }))
    props.goals.forEach(item => edits.value.push({id: 'goal_' + item.goal_id,edit: item.goal_mark <= 0 }))
    props.specific_skills.forEach(item => edits.value.push({id: item.evaluation_skill_id,edit: item.evaluation_skill_mark <= 0 }))
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
            onSuccess: () => setupEdits(),
            onError: err => {
                setupEdits();
                console.log(err)
                usePage().props.flash.notify = {type: 'error',message: err.evaluation_skill_mark}
            },
            preserveScroll: true
        }
    );

}
const updateGoal = (id,marking) => {
    const input = inputs.value['goal_' + id];
    edits.value.find(s => s.id === ('goal_' + id)).edit = false;

    router.put(
        route('goals.update-mark',{goal: id}),
        {goal_mark : input.value, goal_marking: marking,evaluation_id: props.evaluation.evaluation_id},
        {
            onSuccess: () => setupEdits(),
            onError: err => {
                setupEdits();
                // console.log(err)
                usePage().props.flash.notify = {type: 'error',message: err.goal_mark}
            },
            preserveScroll: true
        }
    );
}

const addSpecificSkill = () => {
    form.post(route('evaluationSkill.store'),{
        onError: err => {
            setupEdits();
            usePage().props.flash.notify = {type: 'error',message: err.phase_skill_id}
        },
        onSuccess: () => setupEdits(),
        preserveScroll: true
    })
}

watch(() => props.specific_skills, function (next) {
    setupEdits();
},{immediate: true})

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
                        Evaluation de {{agent.user_display_name}}. Matricule : {{agent.user_matricule}}
                        Année : {{evaluation.phase.phase_year}}
                    </h1>
                    <span class="flex-shrink-0">
                        <span class="flex h-20 w-20 items-center justify-center rounded-full border-4 border-cyan-600">
                            <span class="text-cyan-600 text-2xl font-bold">{{ evaluation.evaluation_mark }}</span>
                        </span>
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-700">
                    Evaluteur: {{evaluation.evaluator.user_display_name}}. Matricule : {{evaluation.evaluator.user_matricule}}.
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
                <div class="pr-4 py-5 sm:pr-6">
                    <InputLabel>Ajouter une compétence spécifique á évaluer</InputLabel>
                    <form class="mt-5 sm:flex sm:items-center" @submit.prevent="addSpecificSkill">
                        <div class="w-full sm:max-w-xl">
                            <Listbox as="div" v-model="form.phase_skill_id">
                                <div class="relative">
                                    <ListboxButton class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6">
                                        <span class="block truncate">{{ specific_skill_types.filter((type) => type.pivot.phase_skill_id === form.phase_skill_id)[0].skill_name }}</span>
                                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                    <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                                </span>
                                    </ListboxButton>
                                    <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <ListboxOptions class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                            <ListboxOption as="template" v-for="type in specific_skill_types" :key="type.skill_id" :value="type.pivot.phase_skill_id" v-slot="{ active, selected }">
                                                <li :class="[active ? 'bg-cyan-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                    <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.skill_name }}</span>
                                                    <span v-if="selected" :class="[active ? 'text-white' : 'text-cyan-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                            </span>
                                                </li>
                                            </ListboxOption>
                                        </ListboxOptions>
                                    </transition>
                                </div>
                            </Listbox>
                        </div>
                        <SubmitButton type="submit" class="mt-2 sm:ml-3 sm:mt-0 sm:w-auto">Ajouter</SubmitButton>
                    </form>
                </div>
                <div class="border-b border-cyan-600 bg-white pr-4 py-2 sm:pr-6 flex justify-between items-center">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900">
                        Compétences Spécifiques
                    </h3>
                    <div class="flex space-x-2">
                        <span class="flex-shrink-0">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                <span class="text-cyan-600">{{ evaluation.specific_skills_sum_evaluation_skill_mark }}</span>
                            </span>
                        </span>
                        <span class="text-3xl">
                        /
                        </span>
                        <span class="flex-shrink-0">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                <span class="text-cyan-600">{{ bareme.specific }}</span>
                            </span>
                        </span>
                    </div>
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
                                <!--						        <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">-->
                                <!--							        <circle cx="1" cy="1" r="1" />-->
                                <!--						        </svg>-->
                                <!--                                <p class="truncate">Created by {{ project.createdBy }}</p>-->
                            </div>
                        </div>
                        <div class="flex flex-none items-center gap-x-4">
                            <div class="flex items-center justify-center space-x-4">
                                <template v-if="!editMark(skill.evaluation_skill_id)">
                                    {{ skill.evaluation_skill_mark }}
                                </template>
                                <template v-else>
                                    <input :ref="el => {inputs[skill.evaluation_skill_id] = el}" maxlength="2" type="text" :value="skill.evaluation_skill_mark" class=" w-10 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" />
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
                                <button @click="router.delete(route('evaluationSkill.destroy',{evaluationSkill: skill.evaluation_skill_id}))" type="button" class="rounded-full bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                    <TrashIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="px-4 py-4 sm:px-0">
                <div class="border-b border-cyan-600 bg-white pr-4 py-2 sm:pr-6 flex justify-between">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900">Compétences Générales</h3>
                    <div class="flex space-x-2">
                        <span class="flex-shrink-0">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                <span class="text-cyan-600">{{ evaluation.general_skills_sum_evaluation_skill_mark }}</span>
                            </span>
                        </span>
                        <span class="text-3xl">
                            /
                            </span>
                        <span class="flex-shrink-0">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                <span class="text-cyan-600">{{ bareme.general }}</span>
                            </span>
                        </span>
                    </div>
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
                                <!--                                <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">-->
                                <!--                                    <circle cx="1" cy="1" r="1" />-->
                                <!--                                </svg>-->
                                <!--                                <p class="truncate">Created by {{ project.createdBy }}</p>-->
                            </div>
                        </div>
                        <div class="flex flex-none items-center gap-x-4">
                            <div class="flex items-center justify-center space-x-4">
                                <template v-if="!editMark(skill.evaluation_skill_id)">
                                    {{ skill.evaluation_skill_mark }}
                                </template>
                                <template v-else>
                                    <input :ref="el => {inputs[skill.evaluation_skill_id] = el}" maxlength="2" type="text" :value="skill.evaluation_skill_mark" class=" w-10 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" />
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
                <div class="border-b border-cyan-600 bg-white pr-4 py-2 sm:pr-6 flex justify-between">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900">Performances</h3>
                    <div class="flex space-x-2">
                        <span class="flex-shrink-0">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                <span class="text-cyan-600">{{ goalsTotal }}</span>
                            </span>
                        </span>
                        <span class="text-3xl">
                            /
                        </span>
                        <span class="flex-shrink-0">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                <span class="text-cyan-600">{{ bareme.perf }}</span>
                            </span>
                        </span>
                    </div>
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
                                <!--                                <p v-if="goal.evaluation_skill_mark_is_claimed" class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">Contesté</p>-->
                            </div>
                            <div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
                                <p class="whitespace-break-spaces">
                                    {{ goal.goal_expected_result }}
                                </p>
                                <!--                                <svg viewBox="0 0 2 2" class="h-0.5 w-0.5 fill-current">-->
                                <!--                                    <circle cx="1" cy="1" r="1" />-->
                                <!--                                </svg>-->
                                <!--                                <p class="truncate">Created by {{ project.createdBy }}</p>-->
                            </div>
                        </div>
                        <div class="flex flex-none items-center gap-x-4">
                            <div class="flex items-center justify-center space-x-4">
                                <template v-if="!editMark('goal_' + goal.goal_id)">
                                    {{ goal.goal_mark }}
                                </template>
                                <template v-else>
                                    <input :ref="el => {inputs['goal_' + goal.goal_id] = el}" maxlength="2" type="text" :value="goal.goal_mark" class=" w-10 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" />
                                </template>
                                <p class="ml-0.5 font-bold">
                                    / {{ goal.goal_marking }}
                                </p>
                                <template v-if="!editMark('goal_' + goal.goal_id)">
                                    <button @click="edits.find(s => s.id === ('goal_' + goal.goal_id)).edit = true" type="button" class="rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                        <PencilSquareIcon class="h-5 w-5" aria-hidden="true" />
                                    </button>
                                </template>
                                <template v-else>
                                    <button @click="updateGoal(goal.goal_id,goal.goal_marking)" type="button" class="rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                        <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                                    </button>
                                </template>
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
