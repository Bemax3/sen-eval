<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Indicator from "@/Components/Charts/Indicator.vue";
import {CheckIcon, ExclamationCircleIcon, UsersIcon, XMarkIcon} from '@heroicons/vue/24/outline'
import {Head, router} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import {ArrowDownTrayIcon, ChevronRightIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid/index.js";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {computed, ref} from "vue";
import BarChart from "@/Components/Charts/BarChart.vue";
import SmallList from "@/Components/Charts/SmallList.vue";
import PieChart from "@/Components/Charts/PieChart.vue";
import {hasData} from "@/helpers/helper.js";
import EmptyState from "@/Components/Common/EmptyState.vue";
import SimpleTable from "@/Components/Common/Tables/SimpleTable.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import TopRatings from "@/Components/Charts/TopRatings.vue";
import RadialBarChart from "@/Components/Charts/RadialBarChart.vue";

const props = defineProps({
    users: {},
    orgs: {},
    rated: {},
    not_rated: {},
    not_validated: {},
    average: {},
    tops: {},
    skills: {},
    skillsChart: {},
    specificSkillsChart: {},
    phases: {},
    phase: {},
    org: {},
    trainings: {},
    trainingsChart: {},
    mobilities: {},
    mobilitiesChart: {},
    claims: {},
    claimsChart: {},
    sanctions: {},
    sanctionsChart: {},
    promotions: {},
    promotionsChart: {},
    advancementsChart: {},
    selected: {}
})


const averageChart = computed(() => {
    let average = JSON.parse(JSON.stringify(props.average));
    average.chartOptions.plotOptions.radialBar.dataLabels.value["formatter"] = (value) => value.replace("%", "")
    return average;
})

const tabs = [
    {id: 1, name: 'Formations', current: false},
    {id: 2, name: 'Réclamations', current: false},
    {id: 3, name: 'Mobilités', current: false},
    {id: 4, name: 'Sanctions', current: false},
    {id: 5, name: 'Promotions & Avancements', current: false},
]

const selectedTab = ref(tabs.filter(t => t.id === (parseInt(props.selected) || 1))[0])

const form = ref({
    phase_id: parseInt(props.phase),
    org_id: parseInt(props.org)
})

const stats = [
    {id: 1, name: 'Total des Agents', stat: props.users, icon: UsersIcon, link: props.org !== -1 ? route('orgs.show', {org: props.org}) : route('users.index')},
    {
        id: 2,
        name: 'Évaluations validées',
        stat: props.rated,
        icon: CheckIcon,
        link: route('admin-dashboard.rated', {phase_id: form.value.phase_id, org_id: form.value.org_id})
    },
    {
        id: 3,
        name: 'Évaluations non validées',
        stat: props.not_validated,
        icon: ExclamationCircleIcon,
        link: route('admin-dashboard.pending', {phase_id: form.value.phase_id, org_id: form.value.org_id})
    },
    {
        id: 4,
        name: 'Non évalués',
        stat: props.not_rated,
        icon: XMarkIcon,
        link: route('admin-dashboard.unrated', {phase_id: form.value.phase_id, org_id: form.value.org_id})
    },
]

const changeTab = (id) => {
    selectedTab.value = tabs.filter(t => t.id === id)[0]
    selectedTab.current = true;
}

const pages = [{name: 'Statistiques', href: '#', current: true}];


const filterDashboard = () => {
    router.get(route('admin-dashboard.index', {phase_id: form.value.phase_id, org_id: form.value.org_id, selected: selectedTab.value.id}))
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

const total_claims = computed(() => props.claims.reduce((a, b) => a + b.claims_count, 0))
const total_sanctions = computed(() => props.sanctions.reduce((a, b) => a + b.sanctions_count, 0))

const total_mobilities = computed(() => {
    let by_evaluators = 0;
    let by_evaluated = 0;
    let all = 0;
    props.mobilities.forEach(el => {
        by_evaluators += el.mobilities_by_evaluators;
        by_evaluated += el.mobilities_by_evaluated;
        all += el.mobilities_by_evaluators + el.mobilities_by_evaluated;
    });
    return {by_evaluators: by_evaluators, by_evaluated: by_evaluated, all: all};
})

const total_promotions = computed(() => {
    let eligible = 0;
    let others = 0;
    let all = 0;
    props.promotions.forEach(el => {
        eligible += el.eligible_count;
        others += el.others;
        all += el.eligible_count + el.others;
    });
    return {eligible: eligible, others: others, all: all};
})


const top_trainings = props.trainings.sort((a, b) => a.trainings_count > b.trainings_count ? -1 : 1);
const mobilities = props.mobilities.map(m => {
    return {...m, mobilities_count: m.mobilities_by_evaluators + m.mobilities_by_evaluated}
})
const top_mobilities = mobilities.sort((a, b) => a.mobilities_count > b.mobilities_count ? -1 : 1);
const top_claims = props.claims.sort((a, b) => a.claims_count > b.claims_count ? -1 : 1);
const top_sanctions = props.sanctions.sort((a, b) => a.sanctions_count > b.sanctions_count ? -1 : 1);

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Statistiques"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Dashboard</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-white">
                        Statistiques des évaluations.
                    </p>
                </div>
            </div>
            <div class="mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <!--                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Filtres</h3>-->
                    <!--                    <div class="mt-2 max-w-xl text-sm text-gray-500 dark:text-gray-100">-->
                    <!--                        <p>Filtrer les données en fonction de l'année et de la direction</p>-->
                    <!--                    </div>-->
                    <form class="sm:flex sm:items-center gap-10" @submit.prevent="filterDashboard">
                        <div class="w-full sm:max-w-xl">
                            <InputLabel>Direction</InputLabel>
                            <div class="mt-2">
                                <Listbox v-model="form.org_id" as="div">
                                    <div class="relative mt-2">
                                        <ListboxButton
                                            class="relative w-full cursor-default rounded-md bg-white dark:bg-grayish py-1.5 pl-3 pr-10 text-left text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6">
                                            <span class="block truncate">{{ orgs.filter((type) => type.org_id === form.org_id)[0]?.org_name || 'Tout' }}</span>
                                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </span>
                                        </ListboxButton>
                                        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <ListboxOptions
                                                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white dark:bg-grayish py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                <ListboxOption v-slot="{ active, selected }" :value="-1"
                                                               as="template">
                                                    <li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900 dark:text-white', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">Tout</span>
                                                        <span v-if="selected"
                                                              :class="[active ? 'text-white' : 'text-cyan-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                                        </span>
                                                    </li>
                                                </ListboxOption>
                                                <ListboxOption v-for="type in orgs" :key="type.org_id" v-slot="{ active, selected }" :value="type.org_id"
                                                               as="template">
                                                    <li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900 dark:text-white', 'relative cursor-default select-none py-2 pl-3 pr-9']">
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
                                            class="relative w-full cursor-default rounded-md bg-white dark:bg-grayish py-1.5 pl-3 pr-10 text-left text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6">
                                            <span class="block truncate">{{ phases.filter((type) => type.phase_id === form.phase_id)[0]?.phase_year }}</span>
                                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </span>
                                        </ListboxButton>
                                        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <ListboxOptions
                                                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white dark:bg-grayish py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                <ListboxOption v-for="type in phases" :key="type.phase_id" v-slot="{ active, selected }" :value="type.phase_id"
                                                               as="template">
                                                    <li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900 dark:text-white', 'relative cursor-default select-none py-2 pl-3 pr-9']">
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
            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <Indicator v-for="item in stats" :key="item.id" :icon="item.icon" :link="item.link" :name="item.name" :value="item.stat"
                           class="relative overflow-hidden rounded-lg bg-white dark:bg-grayish px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6"/>
            </dl>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                <div class="col-span-2 mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="m-3 text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                            <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                            Moyenne {{ form.org_id === -1 ? 'générale' : 'de la direction' }}
                        </h3>
                        <RadialBarChart :chart-options="averageChart.chartOptions" :series="averageChart.series"/>
                    </div>
                </div>
                <div class="col-span-2 mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="m-3 text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                            <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                            Meilleures notes
                            <a :href="route('admin-dashboard.leaderboard',{phase_id: form.phase_id, org_id: form.org_id})"
                               class="font-medium text-cyan-600 hover:text-cyan-500 text-sm m-2"
                            >Voir tout le classement</a>
                        </h3>
                        <TopRatings :tops="tops"/>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                <div class="col-span-2 mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="m-3 text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                            <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                            Moyenne par compétence générale
                        </h3>
                        <BarChart :chart-options="skillsChart.chartOptions" :series="skillsChart.series"/>
                    </div>
                </div>
                <div class="col-span-2 mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="m-3 text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                            <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                            Moyennes par compétence spécifique
                        </h3>
                        <BarChart :chart-options="specificSkillsChart.chartOptions" :series="specificSkillsChart.series"/>
                    </div>
                </div>
            </div>
            <div class="mt-8 sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <SectionTitle title="Besoins exprimés lors des évaluations"/>
                    <div class="border-b border-gray-200 pb-5 sm:pb-0">
                        <div class="mt-3 sm:mt-4">
                            <div class="hidden sm:block">
                                <nav class="-mb-px flex space-x-8">
                                    <button v-for="tab in tabs" :key="tab.name" :aria-current="tab.current ? 'page' : undefined"
                                            :class="[tab.id === selectedTab.id ? 'border-cyan-600 text-cyan-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-white', 'whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium']"
                                            @click="changeTab(tab.id)"
                                    >{{ tab.name }}
                                    </button>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <template v-if="selectedTab.id === 1">
                <template v-if="trainings.length > 0">
                    <div class="sm:flex sm:items-center border-b border-gray-400  pb-5 mt-8">
                        <SectionTitle title="Besoin en Formation"/>
                        <div class="space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a
                                :href="route('admin-dashboard.download-trainings',{phase_id: form.phase_id, org_id: form.org_id})"
                                class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                Télécharger
                                <ArrowDownTrayIcon class="-mr-0.5 h-5 w-5"/>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                        <div class="col-span-3 mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <BarChart :chart-options="trainingsChart.chartOptions" :series="trainingsChart.series"/>
                            </div>
                        </div>
                        <div class="mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                                    <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                                    Formations les plus demandées
                                </h3>
                                <SmallList :data="top_trainings" name="training"/>
                            </div>
                        </div>
                    </div>
                    <SimpleTable v-if="trainings.length > 0">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-black">
                            <thead class="bg-gray-50 dark:bg-grayish">
                            <tr>
                                <TableHeading :first="true">Domaine</TableHeading>
                                <TableHeading class="whitespace-nowrap">Proposée par la hiérarchie</TableHeading>
                                <TableHeading class="whitespace-pre-line">Souhaitée par les agents</TableHeading>
                                <TableHeading class="whitespace-pre-line">Exprimés par les deux parties</TableHeading>
                                <TableHeading>Totaux</TableHeading>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
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
                </template>
                <EmptyState v-else title="Aucun besoin en formation exprimé."/>
            </template>
            <template v-if="selectedTab.id === 2">
                <template v-if="claimsChart && hasData(claimsChart.series)">
                    <div class="sm:flex sm:items-center border-b border-gray-400  pb-5 mt-8">
                        <SectionTitle title="Réclamations"/>
                        <div class="space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a
                                :href="route('admin-dashboard.download-claims',{phase_id: form.phase_id, org_id: form.org_id})"
                                class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                Télécharger
                                <ArrowDownTrayIcon class="-mr-0.5 h-5 w-5"/>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                        <div class="col-span-3 mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <PieChart :chart-options="claimsChart.chartOptions" :series="claimsChart.series" class="max-w-4xl"/>
                            </div>
                        </div>
                        <div class="mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                                    <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                                    Réclamation les plus demandées
                                </h3>
                                <SmallList :data="top_claims" name="claim"/>
                            </div>
                        </div>
                    </div>
                    <SimpleTable v-if="claims.length > 0">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-black">
                            <thead class="bg-gray-50 dark:bg-grayish">
                            <tr>
                                <TableHeading :first="true">Type de la réclamation</TableHeading>
                                <TableHeading class="whitespace-pre-line">Exprimées</TableHeading>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                            <tr v-for="claim in claims" :key="claim.claim_type_id">
                                <TableData :first="true">{{ claim.claim_type_name }}</TableData>
                                <TableData>{{ claim.claims_count }}</TableData>
                            </tr>
                            <tr>
                                <TableData :first="true">Total</TableData>
                                <TableData class="font-bold">
                                    {{ total_claims }}
                                </TableData>
                            </tr>
                            </tbody>
                        </table>
                    </SimpleTable>
                </template>
                <EmptyState v-else title="Aucune réclamations exprimées."/>
            </template>
            <template v-if="selectedTab.id === 3">
                <template v-if="mobilities.length > 0">
                    <div class="sm:flex sm:items-center border-b border-gray-400  pb-5 mt-8">
                        <SectionTitle title="Besoin en Mobilité"/>
                        <div class="space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a
                                :href="route('admin-dashboard.download-mobilities',{phase_id: form.phase_id, org_id: form.org_id})"
                                class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                Télécharger
                                <ArrowDownTrayIcon class="-mr-0.5 h-5 w-5"/>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                        <div class="col-span-3 mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <BarChart :chart-options="mobilitiesChart.chartOptions" :series="mobilitiesChart.series"/>
                            </div>
                        </div>
                        <div class="mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                                    <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                                    Mobilités les plus demandées
                                </h3>
                                <SmallList :data="top_mobilities" name="mobility" plural="mobilities"/>
                            </div>
                        </div>
                    </div>
                    <SimpleTable v-if="mobilities.length > 0">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-black">
                            <thead class="bg-gray-50 dark:bg-grayish">
                            <tr>
                                <TableHeading :first="true">Domaine</TableHeading>
                                <TableHeading class="whitespace-nowrap">Proposée par la hiérarchie</TableHeading>
                                <TableHeading class="whitespace-pre-line">Souhaitée par les agents</TableHeading>
                                <TableHeading>Totaux</TableHeading>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                            <tr v-for="mobility in mobilities" :key="mobility.mobility_type_id">
                                <TableData :first="true">{{ mobility.mobility_type_name }}</TableData>
                                <TableData>{{ mobility.mobilities_by_evaluators }}</TableData>
                                <TableData>{{ mobility.mobilities_by_evaluated }}</TableData>
                                <TableData class="font-bold">{{ mobility.mobilities_count }}</TableData>
                            </tr>
                            <tr>
                                <TableData :first="true">Totaux</TableData>
                                <TableData class="font-bold">
                                    {{ total_mobilities.by_evaluators }}
                                </TableData>
                                <TableData class="font-bold">{{ total_mobilities.by_evaluated }}</TableData>
                                <TableData class="font-bold">{{ total_mobilities.all }}</TableData>
                            </tr>
                            </tbody>
                        </table>
                    </SimpleTable>
                </template>
                <EmptyState v-else title="Aucune besoin de mobilité exprimé."/>
            </template>
            <template v-if="selectedTab.id === 4">
                <template v-if="sanctionsChart && hasData(sanctionsChart.series)">
                    <div class="sm:flex sm:items-center border-b border-gray-400  pb-5 mt-8">
                        <SectionTitle title="Sanctions"/>
                        <div class="space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a
                                :href="route('admin-dashboard.download-sanctions',{phase_id: form.phase_id, org_id: form.org_id})"
                                class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                Télécharger
                                <ArrowDownTrayIcon class="-mr-0.5 h-5 w-5"/>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4">
                        <div class="col-span-3 mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <PieChart :chart-options="sanctionsChart.chartOptions" :series="sanctionsChart.series" class="max-w-3xl"/>
                            </div>
                        </div>
                        <div class="mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                                    <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                                    Sanction les plus demandées
                                </h3>
                                <SmallList :data="top_sanctions" name="sanction"/>
                            </div>
                        </div>
                    </div>
                    <SimpleTable v-if="sanctions.length > 0">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-black">
                            <thead class="bg-gray-50 dark:bg-grayish">
                            <tr>
                                <TableHeading :first="true">Type de la réclamation</TableHeading>
                                <TableHeading class="whitespace-pre-line">Exprimées</TableHeading>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                            <tr v-for="sanction in sanctions" :key="sanction.sanction_type_id">
                                <TableData :first="true">{{ sanction.sanction_type_name }}</TableData>
                                <TableData>{{ sanction.sanctions_count }}</TableData>
                            </tr>
                            <tr>
                                <TableData :first="true">Total</TableData>
                                <TableData class="font-bold">
                                    {{ total_sanctions }}
                                </TableData>
                            </tr>
                            </tbody>
                        </table>
                    </SimpleTable>
                </template>
                <EmptyState v-else title="Aucune sanction donné."/>
            </template>
            <template v-if="selectedTab.id === 5">
                <template v-if="promotions.length > 0">
                    <div class="sm:flex sm:items-center border-b border-gray-400  pb-5 mt-8">
                        <SectionTitle title="Promotions et avancements"/>
                        <div class="space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a
                                :href="route('admin-dashboard.download-promotions',{phase_id: form.phase_id, org_id: form.org_id})"
                                class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                Télécharger
                                <ArrowDownTrayIcon class="-mr-0.5 h-5 w-5"/>
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="m-3 text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                                    <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                                    Promotions
                                </h3>
                                <PieChart :chart-options="promotionsChart.chartOptions" :series="promotionsChart.series" class="max-w-3xl"/>
                            </div>
                        </div>
                        <div class="mt-8 bg-white dark:bg-grayish shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="m-3 text-base font-semibold leading-6 text-gray-900 dark:text-white flex items-center">
                                    <ChevronRightIcon class="-mr-0.5 h-8 w-8 text-cyan-500"/>
                                    Avancements
                                </h3>
                                <PieChart :chart-options="advancementsChart.chartOptions" :series="advancementsChart.series" class="max-w-3xl"/>
                            </div>
                        </div>
                    </div>
                    <SimpleTable v-if="promotions.length > 0">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-black">
                            <thead class="bg-gray-50 dark:bg-grayish">
                            <tr>
                                <TableHeading :first="true">Type de la promotion</TableHeading>
                                <TableHeading :first="true">Proposé et éligible</TableHeading>
                                <TableHeading :first="true">Proposé et non éligible</TableHeading>
                                <TableHeading class="whitespace-pre-line">Totaux</TableHeading>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                            <tr v-for="promotion in promotions" :key="promotion.promotion_type_id">
                                <TableData :first="true">{{ promotion.promotion_type_name }}</TableData>
                                <TableData>{{ promotion.eligible_count }}</TableData>
                                <TableData>{{ promotion.others }}</TableData>
                                <TableData class="font-bold">{{ promotion.eligible_count + promotion.others }}</TableData>
                            </tr>
                            <tr>
                                <TableData :first="true">Totaux</TableData>
                                <TableData class="font-bold">
                                    {{ total_promotions.eligible }}
                                </TableData>
                                <TableData class="font-bold">
                                    {{ total_promotions.others }}
                                </TableData>
                                <TableData class="font-bold">
                                    {{ total_promotions.all }}
                                </TableData>
                            </tr>
                            </tbody>
                        </table>
                    </SimpleTable>
                </template>
                <EmptyState v-else title="Aucune promotion demandée."/>
            </template>
        </div>
    </AuthenticatedLayout>
</template>

