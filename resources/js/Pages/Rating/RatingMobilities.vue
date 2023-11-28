<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import Title from "@/Components/Rating/Title.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Tabs from "@/Components/Rating/Tabs.vue";
import {computed, ref, watch} from "vue";
import {PencilSquareIcon, PlusIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import {getPagination, hasData} from "@/helpers/helper.js";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import DeleteModal from "@/Components/Common/DeleteModal.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";
import SaveMobilityModal from "@/Pages/Rating/modals/SaveMobilityModal.vue";


const props = defineProps({
    agent: {},
    rating: {},
    types: {type: Array},
    mobilities: {}
})
const authenticated = usePage().props.auth.user;
const isEvaluated = computed(() => authenticated.user_id === props.rating.evaluated_id)
const isValidator = computed(() => authenticated.user_id !== props.rating.evaluated_id && authenticated.user_id !== props.rating.evaluator_id)

const pages = isEvaluated.value ? [
    {name: 'Mes Évaluations', href: route('ratings.index', {agent_rating: props.rating.rating_id}), current: false},
    {name: 'Evaluation', href: '#', current: true},
] : isValidator ? [
    {name: 'Mes validations', href: route('validations.index'), current: false},
    {name: 'Évaluation', href: '#', current: true},
] : [
    {name: 'Mes Agents', href: route('agents.index'), current: false},
    {name: 'Évaluations', href: route('agent-ratings.index', {agent: props.agent.user_id}), current: false},
    {name: 'Evaluation', href: '#', current: true},
]
const pagination = computed(() => getPagination(props.mobilities));
const displayedData = ref(props.mobilities.data);
const search = '';
const openSave = ref(false);
const openDelete = ref(false);
const toDestroy = ref(displayedData[0]?.rating_mobility_id);
const mobilityToEdit = ref(displayedData[0]);
const destroy = (id) => {
    toDestroy.value = id;
    openDelete.value = true;
}

const setupEdit = (id) => {
    mobilityToEdit.value = displayedData.value.filter(m => m.rating_mobility_id === id)[0];
    openSave.value = true;
}

const saveMobility = (id = -1) => {
    openSave.value = true;
}


watch(() => props.mobilities,
    function (next) {
        displayedData.value = next.data;
        if (!displayedData.value.length > 0) {
            if (next.prev_page_url) router.get(next.prev_page_url)
            else router.get(next.first_page_url);
        }
    }
);

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Mobilités"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <Title :agent="agent" :rating="rating"/>
            <Tabs :agent_id="props.agent.user_id" :evaluated="isEvaluated" :rating_id="props.rating.rating_id" :validator="isValidator"/>
            <div class="sm:flex sm:items-center border-b border-gray-400 pb-5 mt-8">
                <SectionTitle desc="Liste des mobilités demandées pour cette évaluation" title="Mobilités"/>
                <div v-if="!isValidator && !rating.rating_is_validated" class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <button
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        @click="saveMobility()">
                        Nouvelle Mobilité
                        <PlusIcon class="-mr-0.5 h-5 w-5"/>
                    </button>
                </div>
            </div>
            <Datatable v-if="hasData(mobilities.data)" v-model="search" :pagination="pagination" :search="false">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Nature</TableHeading>
                        <TableHeading>Demandée par</TableHeading>
                        <TableHeading>Poste demandé</TableHeading>
                        <TableHeading class="whitespace-pre-line">Commentaire</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="mobility in displayedData" :key="mobility.rating_mobility_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ mobility.type.mobility_type_name }}</TableData>
                        <TableData>
                            {{ mobility.asked_by ? mobility.asked_by.user_display_name : 'Unknown' }}
                        </TableData>
                        <TableData>
                            {{ mobility.rating_mobility_title }}
                        </TableData>
                        <TableData class="whitespace-pre-line">
                            {{ mobility.rating_mobility_comment }}
                        </TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div v-if="!rating.rating_is_validated && mobility.asked_by && authenticated.user_id === mobility.asked_by.user_id"
                                 class="flex items-center justify-center space-x-2">
                                <button
                                    class="rounded-lg bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                                    type="button"
                                    @click="setupEdit(mobility.rating_mobility_id)">
                                    <PencilSquareIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                                <button
                                    class="rounded-lg bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                    type="button"
                                    @click="destroy(mobility.rating_mobility_id)">
                                    <TrashIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState v-else message="Demander une mobilité en utilisant le formulaire en haut." title="Aucune mobilité demandée pour l'instant."/>
        </div>
        <DeleteModal :link="route('rating-mobilities.destroy',{rating: rating.rating_id,rating_mobility: toDestroy ? toDestroy : -1})" :opened="openDelete"
                     @close-modal="openDelete = false"/>
        <SaveMobilityModal :isValidator="isValidator" :mobility="mobilityToEdit" :opened="openSave" :rating="rating" :types="types" @close-modal="openSave = false"/>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
