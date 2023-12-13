<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {capitalized, moment} from "@/helpers/helper.js";
import TextInput from "@/Components/Forms/TextInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import Switch from "@/Components/Forms/Switch.vue";
import {LockClosedIcon} from "@heroicons/vue/20/solid/index.js";
import GoalActivity from "@/Components/Rating/GoalActivity.vue";
import NumberInput from "@/Components/Forms/NumberInput.vue";
import InputError from "@/Components/Forms/InputError.vue";

const props = defineProps({
    goal: {
        type: Object,
        default: {}
    },
    history: {}
})

const title = 'Modifier l\'objectif.';
const desc = 'Accepter ou Contester un objectif.';
const pages = [
    {name: 'Mes Objectifs', href: route('goals.index'), current: false},
    {name: 'Modifier', href: '#', current: true},
]

let form;
const setForm = () => {
    form = useForm({comment: '', goal_rate: props.goal.goal_rate});
}
const submit = () => {
    form.put(route('goals.update', {goal: props.goal.goal_id}), {
        onSuccess: () => setForm(),
        preserveScroll: true
    });
}

setForm();
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Suivi Objectif"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Objectif</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-white">
                        Details de l'Objectif
                    </p>
                </div>
            </div>
            <form class="mt-8 shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg bg-white dark:bg-grayish" @submit.prevent="submit">
                <div class="grid max-w-full grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Libellé et Valeur Cible</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Informations sur le libellé de l'objectif ainsi que la valeur cible.</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="sm:col-span-full">
                                <InputLabel for="start_date" required>Libelle</InputLabel>
                                <div class="relative mt-2">
                                    <TextInput v-model="goal.goal_name" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="sm:col-span-full">
                                <InputLabel for="start_date" required>Valeur Cible</InputLabel>
                                <div class="relative mt-2">
                                    <TextInput v-model="goal.goal_expected_result" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="grid max-w-full grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2 dark:border-black">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Disponibilité et Échéance</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Les moyens pour atteindre l'objectif sont ils réunis ? Qu'elle sera l'échéance pour cette
                            objectif. </p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <InputLabel for="start_date" required>Échéance</InputLabel>
                                <div class="relative mt-2">
                                    <input :disabled="true" :value="capitalized(moment(goal.goal_expected_date).format('DD MMMM YYYY'))"
                                           class="bg-white dark:bg-grayish block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 dark:ring-2 placeholder:text-gray-400 focus:ring-2 focus:ring-inset  sm:text-sm sm:leading-6"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <div class="mt-2">
                                    <Switch v-model="goal.goal_means_available" :disabled="true" desc="Les moyens pour accomplir cette objectif sont t-il disponible ?"
                                            label="Disponibilité des moyens"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid max-w-full grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2 dark:border-black">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Évaluation</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Informations relatives à l'évaluation de cet objectif.</p>
                    </div>
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <InputLabel>Année d'évaluation</InputLabel>
                                <div class="relative mt-2">
                                    <TextInput v-model="goal.phase.phase_year" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <InputLabel>Période d'évaluation</InputLabel>
                                <div class="relative mt-2">
                                    <TextInput v-model="goal.period.evaluation_period_name" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 col-span-full">
                                <InputLabel for="start_date" required>Barème</InputLabel>
                                <div class="relative mt-2">
                                    <NumberInput v-model="goal.goal_marking" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid max-w-full grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-2 lg:px-8 border-t-2 dark:border-black">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Suivi de l'objectif</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Faites le suivi de cet objectif renseignant le taux d'évaluation et en laissant un
                            commentaire.</p>
                        <GoalActivity :history="history"/>
                    </div>
                    <div class="md:col-span-1">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Taux d'avancement</InputLabel>
                                <div class="mt-2 flex rounded-md shadow-sm">
                                    <input
                                        v-model="form.goal_rate"
                                        :class="form.errors.goal_rate !== undefined ? 'focus:ring-red-400 ring-red-500':'focus:ring-cyan-600 ring-gray-300 dark:ring-gray-600'"
                                        class="bg-white dark:bg-grayish block w-full min-w-0 flex-1 rounded-none rounded-l-md border-0 py-1.5 text-gray-900 dark:text-white ring-1 dark:ring-2 ring-inset  placeholder:text-gray-400 focus:ring-2 focus:ring-inset  sm:text-sm sm:leading-6"
                                        maxlength="3" type="number"/>
                                    <span
                                        class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 px-3 text-gray-500 dark:text-gray-100 sm:text-sm">%</span>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.goal_rate"/>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date">Commentaire</InputLabel>
                                <div class="relative mt-2">
                                    <TextArea v-model="form.comment" :invalid="form.errors.comment !== undefined"/>
                                </div>
                                <InputError :message="form.errors.comment"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <FormIndications/>
                    <SubmitButton :processing="form.processing">Enregistrer</SubmitButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
