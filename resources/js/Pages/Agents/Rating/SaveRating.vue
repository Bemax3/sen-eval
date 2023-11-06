<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Separator from "@/Components/LayoutParts/Separator.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import InputError from "@/Components/Forms/InputError.vue";
import {hasData, isEmpty} from "@/helpers/helper.js";
import RangePicker from "@/Components/Forms/RangePicker.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import Switch from "@/Components/Forms/Switch.vue";
import DatePicker from "@/Components/Forms/DatePicker.vue";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import {CheckIcon, ChevronDoubleRightIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    agent: {
        type: Object,
    },
    phases: {
        type: Object,
    },
    evaluation: {
        type: Object,
        required:false,
        default: {}
    },
})

const pages = [
    { name: 'Evaluations', href: route('agent-ratings.index',{agent: props.agent.user_id}), current: false },
    { name: isEmpty(props.evaluation) ? 'Nouvelle' : 'Modifier', href: '#', current: true },
]

let form;
const setForm = () => {
    form = useForm(
        isEmpty(props.evaluation)
            ? {
                phase_id: hasData(props.phases) ? props.phases[0].phase_id : null,
                evaluated_id: props.agent.user_id
            }
            : {
                phase_id: props.evaluation.phase_id,
                evaluated_id: props.agent.user_id
            }
    );
}

setForm();


const submit = () => {
    if (isEmpty(props.evaluation))
        form.post(route('agent-ratings.store',{agent: props.agent.user_id}), {
            onSuccess: () => setForm(),
            onError: err => usePage().props.flash.notify = {type: 'error',message: err.phase_id}
        });
    else
        form.put(route('agent-ratings.update', {agent: props.agent.user_id,rating: props.rating.rating_id}), {
            onSuccess: () => setForm(),
        });
}
const title = isEmpty(props.evaluation) ? 'Nouvelle evaluation' : 'Modifier l\'evaluation';
const desc = isEmpty(props.evaluation) ? 'Créer une evaluation pour cet agent' : 'Modifier une evaluation pour cet agent';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Paramètre de Phase"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Evaluations de {{agent.user_first_name + ' ' + agent.user_last_name}}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Liste des evaluations de {{agent.user_first_name + ' ' + agent.user_last_name}}. Matricule : {{agent.user_matricule}}
                    </p>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('agent-goals.index',{agent: agent.user_id})"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        as="button">
                        Objectif
                        <ChevronDoubleRightIcon class="-mr-0.5 h-5 w-5"/>
                    </Link>
                </div>
            </div>
            <Separator title="Evaluations" />
            <SectionTitle :title="title" :desc="desc"/>
            <div class="mt-8 flow-root">
                <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <InputLabel required>Année d'évaluation</InputLabel>
                                <div class="mt-2">
                                    <Listbox as="div" v-model="form.phase_id">
                                        <div class="relative mt-2">
                                            <ListboxButton class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6" :class="form.errors.phase_id ? 'ring-red-300':'ring-gray-300'">
                                                <span v-if="hasData(phases)" class="block truncate">{{ phases.filter((type) => type.phase_id === form.phase_id)[0].phase_year }}</span>
                                                <span v-else class="block truncate">Aucune année disponible pour l'instant.</span>
                                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                    <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                                </span>
                                            </ListboxButton>
                                            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <ListboxOptions v-if="hasData(phases)" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
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
                                <InputError :message="form.errors.phase_id"/>
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
