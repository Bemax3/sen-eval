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

const props = defineProps({
    phase: {type: Object},
    period: {type: Object, default: {}}
})

const pages = [
    {name: 'Phase d\'évaluation', href: route('phases.index'), current: false},
    {name: 'Périodes d\'évaluation', href: route('periods.show', {period: props.phase.phase_id}), current: true},
    {name: isEmpty(props.period) ? 'Nouveau' : 'Modifier', href: '#', current: true},
]
const title = isEmpty(props.period) ? 'Nouvelle Période d\'évaluation' : 'Modifier la période d\'évaluation';
const desc = isEmpty(props.period) ? 'Ajouter une période d\'évaluation à cette phase.' : 'Modifier une période d\'évaluation de cette phase';

let form;
const setForm = () => {
    form = useForm(
        isEmpty(props.period)
            ? {
                phase_id: props.phase.phase_id,
                period: [new Date(), new Date()]
            }
            : {
                phase_id: props.phase.phase_id,
                period: [props.period.evaluation_period_start, props.period.evaluation_period_end]
            }
    );
}
const submit = () => {
    if (isEmpty(props.period))
        form.post(route('periods.store'), {
            onSuccess: () => setForm(),
        });
    else
        form.put(route('periods.update', {period: props.period.evaluation_period_id}), {
            onSuccess: () => setForm(),
        });
}

setForm();

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Nouvelle Période de Phase"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Paramètres {{ phase.phase_name }}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Details et paramètres de l'évaluation.
                    </p>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('phaseSkills.show',{phaseSkill: phase.phase_id})"
                        as="button"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Compétences
                    </Link>
                    <Link
                        :href="route('periods.show',{period: phase.phase_id})"
                        as="button"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Périodes d'évaluation
                    </Link>
                </div>
            </div>
            <Separator title="Périodes"/>
            <SectionTitle :desc="desc" :title="title"/>
            <div class="mt-8 flow-root">
                <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Période d'évaluation</InputLabel>
                                <div class="mt-2">
                                    <RangePicker v-model="form.period" :invalid="form.errors.evaluation_period_end !== undefined"/>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.Evaluation_period_start"/>
                                    <InputError :message="form.errors.evaluation_period_end"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications/>
                        <SubmitButton :processing="form.processing"> Enregistrer</SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
