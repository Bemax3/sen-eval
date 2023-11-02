<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, usePage} from "@inertiajs/vue3";
import {PencilSquareIcon, CheckIcon, PlusIcon, ChevronDownIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {capitalized, getPagination, hasData, moment} from "@/helpers/helper.js";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import ToggleOnDatatable from "@/Components/Forms/ToggleOnDatatable.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import {computed, onBeforeUpdate, reactive, ref, watch} from "vue";
import axios from "axios";
import EmptyState from "@/Components/Common/EmptyState.vue";
import Separator from "@/Components/LayoutParts/Separator.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";
import {Dialog, DialogPanel, DialogTitle, Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import PeriodModal from "@/Components/Modals/PeriodModal.vue";
import DeleteModal from "@/Components/Common/DeleteModal.vue";

const props = defineProps({
    phase: {
        type: Object,
    },
    periods: {
        type: Object
    }

})

const pagination = computed(() => getPagination(props.periods));

const displayedData = ref(props.periods.data);
const openModal = ref(false);
let idToDestroy = hasData(props.periods.data) ? props.periods.data[0].evaluation_period_id : null;
const destroy = id => {
    idToDestroy = id;
    openModal.value = true;
};
const search = reactive({
    keyword: '',
    fields: ['evaluation_period_start','evaluation_period_end'],
    phase_id: props.phase.phase_id
});


watch(() => search.keyword,
    function (next) {
        if (next === '') {
            displayedData.value = props.periods.data;
        } else {
            axios.post(route('periods.search'), search).then(res => {displayedData.value = res.data;}).catch(err => console.log(err));
        }
    }
);

watch(()=> props.periods,
    function (next) {
        displayedData.value = next.data;
        if(!displayedData.value.length >0) {
            if(next.prev_page_url) router.get(next.prev_page_url)
            else router.get(next.first_page_url);
        }
    }
);

const pages = [
    { name: 'Phases d\'évaluation', href: route('phases.index'), current: false },
    { name: 'Périodes d\'évaluation', href: '#', current: true },
]

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Paramètre de Phase"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Paramètres {{ phase.phase_name}}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Details et paramètres de l'évaluation.
                    </p>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('phaseSkills.show',{phaseSkill: phase.phase_id})"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        as="button">
                        Compétences
                    </Link>
                    <Link
                        :href="route('periods.show',{period: phase.phase_id})"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        as="button">
                        Périodes d'évaluation
                    </Link>
                </div>
            </div>
            <Separator title="Périodes" />
            <div class="sm:flex sm:items-center">
                <SectionTitle title="Période d'évaluation" desc="Cette liste représente les périodes ou les évaluateurs pourront soumettre les évaluations de leur agents."/>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('periods.create',{phase: phase.phase_id})"
                        as="button"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Nouvelle Période
                        <PlusIcon class="-mr-0.5 h-5 w-5"/>
                    </Link>
                </div>
            </div>
            <Datatable v-model="search.keyword" :pagination="getPagination(periods)" v-if="hasData(props.periods.data)">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Identifiant</TableHeading>
                        <TableHeading>Nom</TableHeading>
                        <TableHeading>Date de début</TableHeading>
                        <TableHeading>Date de Fin</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="(period,i) in displayedData" :key="period.evaluation_period_id">
                        <TableData :first="true">{{i + 1}}</TableData>
                        <TableData>{{period.evaluation_period_name}}</TableData>
                        <TableData>{{capitalized(moment(period.evaluation_period_start).format('DD MMMM YYYY')) }}</TableData>
                        <TableData>{{capitalized(moment(period.evaluation_period_end).format('DD MMMM YYYY')) }}</TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center">
                                <Link :href="route('periods.edit', {period: period.evaluation_period_id})" class="group flex items-center px-4 py-2 text-sm">
                                    <PencilSquareIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600" aria-hidden="true" />
                                </Link>
                                <a href="#" @click="destroy(period.evaluation_period_id)" class="group flex items-center px-4 py-2 text-sm">
                                    <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-red-600" aria-hidden="true" />
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé. </div>
            </Datatable>
            <EmptyState
                v-else
                title="Pas de périodes d'évaluation crée pour cette phase."
                message="Ajouter des périodes en cliquant sur ce bouton."
                :link="route('periods.create',{phase: phase.phase_id})"
                action="Nouvelle Période" />
            <DeleteModal
                :opened="openModal"
                :id="idToDestroy"
                @close-modal="openModal = false"
                name="period"
                link="periods.destroy" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
