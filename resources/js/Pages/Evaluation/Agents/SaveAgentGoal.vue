<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Separator from "@/Components/LayoutParts/Separator.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import InputError from "@/Components/Forms/InputError.vue";
import {isEmpty} from "@/helpers/helper.js";
import RangePicker from "@/Components/Forms/RangePicker.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import Switch from "@/Components/Forms/Switch.vue";
import DatePicker from "@/Components/Forms/DatePicker.vue";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import {CheckIcon, ChevronDoubleRightIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid/index.js";
import NumberInput from "@/Components/Forms/NumberInput.vue";
import {ref, watch} from "vue";

const props = defineProps({
    agent: {
        type: Object,
    },
    phases: {
        type: Object,
    },
    goal: {
        type: Object,
        required:false,
        default: {}
    },
})

const pages = [
    { name: 'Objectifs', href: route('agent-goals.index',{agent: props.agent.user_id}), current: false },
    { name: isEmpty(props.goal) ? 'Nouveau' : 'Modifier', href: '#', current: true },
]

let form;
const setForm = () => {
    form = useForm(
        isEmpty(props.goal)
            ? {
                goal_name: '',
                goal_means_available: 1,
                goal_expected_date: new Date(),
                goal_expected_result: '',
                goal_marking: 5,
                phase_id: props.phases[0].phase_id,
                evaluation_period_id: props.phases[0].periods[0].evaluation_period_id
            }
            : {
                goal_name: props.goal.goal_name,
                goal_means_available: props.goal.goal_means_available,
                goal_expected_date: new Date(props.goal.goal_expected_date),
                goal_expected_result: props.goal.goal_expected_result,
                goal_marking: props.goal.goal_marking,
                phase_id: props.goal.phase_id,
                evaluation_period_id: props.goal.evaluation_period_id
            }
    );
}

setForm();

const periods = ref();

watch(() => form.phase_id,function (next) {
    periods.value = props.phases.filter(p => p.phase_id === next)[0].periods;
    form.evaluation_period_id = periods.value[0].evaluation_period_id
},{immediate: true})

const submit = () => {
    if (isEmpty(props.goal))
        form.post(route('agent-goals.store',{agent: props.agent.user_id}), {
            onSuccess: () => setForm(),
        });
    else
        form.put(route('agent-goals.update', {agent: props.agent.user_id,agent_goal: props.goal.goal_id}), {
            onSuccess: () => setForm(),
        });
}
const title = isEmpty(props.goal) ? 'Nouvel objectif' : 'Modifier l\'objectif';
const desc = isEmpty(props.goal) ? 'Fixer un objectif a cet agent' : 'Modifier un objectif pour cet agent';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Paramètre de Phase"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Objectifs de {{agent.user_display_name}}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Objectifs de l'agent.
                    </p>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('evaluation.index',{agent: agent.user_id})"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        as="button">
                        Evaluations
                        <ChevronDoubleRightIcon class="-mr-0.5 h-5 w-5"/>
                    </Link>
                </div>
            </div>
            <Separator title="Objectifs" />
            <SectionTitle :title="title" :desc="desc"/>
            <div class="mt-8 flow-root">
                <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Libelle</InputLabel>
                                <div class="mt-2">
                                    <TextInput v-model="form.goal_name" :invalid="form.errors.goal_name !== undefined"/>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.goal_name"/>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Valeur Cible</InputLabel>
                                <div class="mt-2">
                                    <TextArea v-model="form.goal_expected_result" :invalid="form.errors.goal_expected_result !== undefined"/>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.goal_expected_result"/>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <div class="mt-2">
                                    <Switch v-model="form.goal_means_available" label="Disponibilité des moyens" desc="Les moyens pour accomplir cette objectif sont t-il disponible ?"/>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Échéance</InputLabel>
                                <div class="mt-2">
                                    <DatePicker v-model="form.goal_expected_date" :invalid="form.errors.goal_expected_date !== undefined"/>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.goal_expected_date"/>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <InputLabel>Année d'évaluation</InputLabel>
                                <div class="mt-2">
                                    <Listbox as="div" v-model="form.phase_id">
                                        <div class="relative mt-2">
                                            <ListboxButton class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6">
                                                <span class="block truncate">{{ phases.filter((type) => type.phase_id === form.phase_id)[0].phase_year }}</span>
                                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                            </span>
                                            </ListboxButton>
                                            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <ListboxOptions class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                    <ListboxOption as="template" v-for="type in phases" :key="type.phase_id" :value="type.phase_id" v-slot="{ active, selected }">
                                                        <li :class="[active ? 'bg-cyan-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.phase_year }}</span>
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
                            </div>
                            <div class="sm:col-span-3">
                                <InputLabel>Période</InputLabel>
                                <div class="mt-2">
                                    <Listbox as="div" v-model="form.evaluation_period_id">
                                        <div class="relative mt-2">
                                            <ListboxButton class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6">
                                                <span class="block truncate">{{ periods.filter(p => p.evaluation_period_id === form.evaluation_period_id)[0].evaluation_period_name }}</span>
                                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                            </span>
                                            </ListboxButton>
                                            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <ListboxOptions class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                    <ListboxOption as="template" v-for="type in periods" :key="type.evaluation_period_id" :value="type.evaluation_period_id" v-slot="{ active, selected }">
                                                        <li :class="[active ? 'bg-cyan-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.evaluation_period_name }}</span>
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
                            </div>

                        <div class="col-span-full">
                            <InputLabel for="start_date" required>Barème</InputLabel>
                            <div class="mt-2">
                                <NumberInput maxlength="2" v-model="form.goal_marking" :invalid="form.errors.goal_marking !== undefined"/>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <InputError :message="form.errors.goal_marking"/>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications />
                        <SubmitButton :disabled="form.processing"> Enregistrer </SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
