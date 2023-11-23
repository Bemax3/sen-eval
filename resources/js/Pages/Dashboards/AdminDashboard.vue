<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Indicator from "@/Components/Stats/Indicator.vue";
import {ChartBarIcon, UsersIcon} from '@heroicons/vue/24/outline'
import {Head, router, useForm} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import {CheckIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid/index.js";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import {computed} from "vue";
import SimpleTable from "@/Components/Common/Tables/SimpleTable.vue";

const props = defineProps({
    users: {},
    orgs: {},
    rated: {},
    not_rated: {},
    phases: {},
    phase: {},
    org: {},
    trainings: {}
})

const stats = [
    {id: 1, name: 'Agents', stat: props.users, icon: UsersIcon},
    {id: 3, name: 'Évaluations validées', stat: props.rated, icon: ChartBarIcon},
    {id: 3, name: 'Évaluations non validées', stat: props.not_rated, icon: ChartBarIcon},
]

const pages = [{name: 'Statistiques', href: '#', current: true}];

const form = useForm({
    phase_id: parseInt(props.phase),
    org_id: parseInt(props.org)
})

const filterDashboard = () => {
    router.get(route('admin-dashboard.index', {phase_id: form.phase_id, org_id: form.org_id}))
}

const search = '';

const total = computed(() => {
    let by_evaluators = 0;
    let by_evaluated = 0;
    let by_both = 0;
    let all = 0;
    props.trainings.forEach(el => {
        by_evaluators += el.trainings_by_evaluators;
        by_evaluated += el.trainings_by_evaluated;
        by_both += el.asked_by_both;
        all += el.trainings_count
    });
    return {by_evaluators: by_evaluators, by_evaluated: by_evaluated, by_both: by_both, all: all};
});

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Statistiques"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Dashboard</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Statistiques des évaluations.
                    </p>
                </div>
            </div>
            <div class="mt-8 bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Filtres</h3>
                    <div class="mt-2 max-w-xl text-sm text-gray-500">
                        <p>Filtrer les données en fonction de l'année et de la direction</p>
                    </div>
                    <form class="mt-5 sm:flex sm:items-center gap-10" @submit.prevent="filterDashboard">
                        <div class="w-full sm:max-w-xl">
                            <InputLabel>Direction</InputLabel>
                            <div class="mt-2">
                                <Listbox v-model="form.org_id" as="div">
                                    <div class="relative mt-2">
                                        <ListboxButton
                                            class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6">
                                            <span class="block truncate">{{ orgs.filter((type) => type.org_id === form.org_id)[0]?.org_name || 'Tout' }}</span>
                                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </span>
                                        </ListboxButton>
                                        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <ListboxOptions
                                                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                <ListboxOption v-slot="{ active, selected }" :value="-1"
                                                               as="template">
                                                    <li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">Tout</span>
                                                        <span v-if="selected"
                                                              :class="[active ? 'text-white' : 'text-cyan-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                                        </span>
                                                    </li>
                                                </ListboxOption>
                                                <ListboxOption v-for="type in orgs" :key="type.org_id" v-slot="{ active, selected }" :value="type.org_id"
                                                               as="template">
                                                    <li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.org_name }}</span>
                                                        <span v-if="selected"
                                                              :class="[active ? 'text-white' : 'text-cyan-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                                        </span>
                                                    </li>
                                                </ListboxOption>

                                            </ListboxOptions>
                                        </transition>
                                    </div>
                                </Listbox>
                            </div>
                        </div>
                        <div class="w-full sm:max-w-xl">
                            <InputLabel>Année d'évaluation</InputLabel>
                            <div class="mt-2">
                                <Listbox v-model="form.phase_id" as="div">
                                    <div class="relative mt-2">
                                        <ListboxButton
                                            class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6">
                                            <span class="block truncate">{{ phases.filter((type) => type.phase_id === form.phase_id)[0]?.phase_year }}</span>
                                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </span>
                                        </ListboxButton>
                                        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <ListboxOptions
                                                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                <ListboxOption v-for="type in phases" :key="type.phase_id" v-slot="{ active, selected }" :value="type.phase_id"
                                                               as="template">
                                                    <li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.phase_year }}</span>
                                                        <span v-if="selected"
                                                              :class="[active ? 'text-white' : 'text-cyan-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                                        </span>
                                                    </li>
                                                </ListboxOption>
                                            </ListboxOptions>
                                        </transition>
                                    </div>
                                </Listbox>
                            </div>
                        </div>
                        <div class="mt-7">
                            <SubmitButton class="sm:ml-3 sm:mt-0 sm:w-auto" type="submit">Filtrer</SubmitButton>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-8 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <SectionTitle title="Statistiques"/>
                </div>
            </div>
            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                <Indicator v-for="item in stats" :key="item.id" :icon="item.icon" :name="item.name" :value="item.stat"
                           class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6"/>
            </dl>
            <div class="mt-8 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <SectionTitle title="Besoins en Formations"/>
                </div>
            </div>
            <SimpleTable>
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Domaine</TableHeading>
                        <TableHeading class="whitespace-nowrap">Proposée par la hiérarchie</TableHeading>
                        <TableHeading class="whitespace-pre-line">Souhaitée par les agents</TableHeading>
                        <TableHeading class="whitespace-pre-line">Exprimés par les deux parties</TableHeading>
                        <TableHeading>Totaux</TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="training in trainings" :key="training.training_type_id">
                        <TableData :first="true">{{ training.training_type_name }}</TableData>
                        <TableData>{{ training.trainings_by_evaluators }}</TableData>
                        <TableData>{{ training.trainings_by_evaluated }}</TableData>
                        <TableData>{{ training.asked_by_both }}</TableData>
                        <TableData class="font-bold">{{ training.trainings_count }}</TableData>
                    </tr>
                    <tr>
                        <TableData :first="true">Totaux</TableData>
                        <TableData class="font-bold">
                            {{ total.by_evaluators }}
                        </TableData>
                        <TableData class="font-bold">{{ total.by_evaluated }}</TableData>
                        <TableData class="font-bold">{{ total.by_both }}</TableData>
                        <TableData class="font-bold">{{ total.all }}</TableData>
                    </tr>
                    </tbody>
                </table>
            </SimpleTable>
        </div>
    </AuthenticatedLayout>
</template>

