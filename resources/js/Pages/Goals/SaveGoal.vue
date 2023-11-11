<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {capitalized, isEmpty, moment} from "@/helpers/helper.js";
import TextInput from "@/Components/Forms/TextInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import Switch from "@/Components/Forms/Switch.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    goal: {
        type: Object,
        default: {}
    },
})

const title = 'Modifier l\'objectif.';
const desc = 'Accepter ou Contester un objectif.';
const pages = [
    {name: 'Mes Objectifs', href: route('goals.index'), current: false},
    {name: 'Modifier', href: '#', current: true},
]

let form;
const setForm = () => {
    form = useForm(isEmpty(props.goal) ? {goal_is_accepted: 1, goal_comment: ''} : {
        goal_is_accepted: props.goal.goal_is_accepted,
        goal_comment: props.goal.goal_comment || ''
    });
}
const submit = () => {
    form.put(route('goals.update', {goal: props.goal.goal_id}), {
        onSuccess: () => setForm(),
    });
}

setForm();
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
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Valeur Cible</InputLabel>
                                <div class="relative mt-2">
                                    <TextArea v-model="goal.goal_expected_result" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <div class="mt-2">
                                    <Switch v-model="goal.goal_means_available" :disabled="true" desc="Les moyens pour accomplir cette objectif sont t-il disponible ?"
                                            label="Disponibilité des moyens"/>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Échéance</InputLabel>
                                <div class="relative mt-2">
                                    <input :disabled="true" :value="capitalized(moment(goal.goal_expected_date).format('DD MMMM YYYY'))"
                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset  sm:text-sm sm:leading-6"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="sm:col-span-4">
                                <InputLabel>Année d'évaluation</InputLabel>
                                <div class="relative mt-2">
                                    <TextInput v-model="goal.phase.phase_year" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <div class="mt-2">
                                    <Switch v-model="form.goal_is_accepted" desc="Accepter cette objectif ou le contesté ?" label="Contester / Accepter"/>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date">Commentaire</InputLabel>
                                <div class="relative mt-2">
                                    <TextArea v-model="form.goal_comment"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications/>
                        <SubmitButton :disabled="form.processing">Enregistrer</SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
