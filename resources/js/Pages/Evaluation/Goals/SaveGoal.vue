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
import {capitalized, isEmpty, moment} from "@/helpers/helper.js";
import RangePicker from "@/Components/Forms/RangePicker.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import Switch from "@/Components/Forms/Switch.vue";
import DatePicker from "@/Components/Forms/DatePicker.vue";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import {CheckIcon, ChevronUpDownIcon, LockClosedIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    goal: {
        type: Object,
        default: {}
    },
})

const pages = [
    { name: 'Mes Objectifs', href: route('goals.index'), current: false },
    { name: 'Modifier', href: '#', current: true },
]

let form;
const setForm = () => {
    form = useForm({goal_is_accepted: 1});
}

setForm();


const submit = () => {
    form.put(route('goals.update', {goal: props.goal.goal_id}), {
        onSuccess: () => setForm(),
    });
}
const title = 'Modifier l\'objectif.';
const desc = 'Accepter ou Contester un objectif.';
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Paramètre de Phase"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Objectif</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Details de l'Objectif
                    </p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Libelle</InputLabel>
                                <div class="relative mt-2">
                                    <TextInput v-model="goal.goal_name" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Valeur Cible</InputLabel>
                                <div class="relative mt-2">
                                    <TextArea v-model="goal.goal_expected_result" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <div class="mt-2">
                                    <Switch :disabled="true"  v-model="goal.goal_means_available" label="Disponibilité des moyens" desc="Les moyens pour accomplir cette objectif sont t-il disponible ?"/>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Échéance</InputLabel>
                                <div class="relative mt-2">
                                    <input :value="capitalized(moment(goal.goal_expected_date).format('DD MMMM YYYY'))" :disabled="true" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset  sm:text-sm sm:leading-6"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="sm:col-span-4">
                                <InputLabel>Année d'évaluation</InputLabel>
                                <div class="relative mt-2">
                                    <TextInput v-model="goal.phase.phase_year" :disabled="true" />
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications />
                        <SubmitButton :disabled="form.processing">Accepter cet objectif</SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
