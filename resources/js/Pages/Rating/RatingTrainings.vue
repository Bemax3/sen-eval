<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, useForm, usePage} from "@inertiajs/vue3";
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
import RevokeTraining from "@/Components/Rating/RevokeTraining.vue";
import SaveTrainingModal from "@/Pages/Rating/modals/SaveTrainingModal.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";


const props = defineProps({
    agent: {},
    rating: {},
    types: {type: Array},
    trainings: {}
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

const search = '';
const pagination = computed(() => getPagination(props.trainings));
const displayedData = ref(props.trainings.data);
const openDelete = ref(false);
const openSave = ref(false);
const toDestroy = ref(displayedData[0]?.rating_training_id);
const trainingToEdit = ref(displayedData[0]);
const destroy = (id) => {
    toDestroy.value = id;
    openDelete.value = true;
}

const setupEdit = (id) => {
    trainingToEdit.value = displayedData.value.filter(t => t.rating_training_id === id)[0];
    openSave.value = true;
}

const saveTraining = () => {
    openSave.value = true
}

const revoke = useForm(isEvaluated.value ? {asked_by_evaluated: 0} : {asked_by_evaluator: 0})

watch(() => props.trainings,
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
        <Head title="Formations"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <Title :agent="agent" :rating="rating"/>
            <Tabs :agent_id="props.agent.user_id" :evaluated="isEvaluated" :rating_id="props.rating.rating_id" :validator="isValidator"/>
            <div class="sm:flex sm:items-center border-b border-gray-400 pb-5 mt-8">
                <SectionTitle desc="Liste des formations demandées pour cette évaluation" title="Formations"/>
                <div v-if="!isValidator && !rating.rating_is_validated" class="space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <button
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        @click="saveTraining()">
                        Nouvelle Formation
                        <PlusIcon class="-mr-0.5 h-5 w-5"/>
                    </button>
                </div>
            </div>
            <Datatable v-if="hasData(trainings.data)" v-model="search" :pagination="pagination" :search="false">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Type</TableHeading>
                        <TableHeading>Demandée par l'évaluateur</TableHeading>
                        <TableHeading>Demandée par l'évalué</TableHeading>
                        <TableHeading class="whitespace-pre-line">Commentaire de l'évaluateur</TableHeading>
                        <TableHeading class="whitespace-pre-line">Commentaire de l'évalué</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="training in displayedData" :key="training.rating_training_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ training.type.training_type_name }}</TableData>
                        <TableData>
                            <span :class="training.asked_by_evaluator ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'"
                                  class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ training.asked_by_evaluator ? 'Oui' : 'Non' }}
                            </span>
                        </TableData>
                        <TableData>
                            <span :class="training.asked_by_evaluated ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'"
                                  class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ training.asked_by_evaluated ? 'Oui' : 'Non' }}
                            </span>
                        </TableData>
                        <TableData class="whitespace-pre-line">{{ training.evaluator_comment || '__' }}</TableData>
                        <TableData class="whitespace-pre-line">{{ training.evaluated_comment || '__' }}</TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div
                                v-if="!isValidator && ((isEvaluated && training.asked_by_evaluated) || (!isEvaluated && training.asked_by_evaluator)) && !rating.rating_is_validated"
                                class="flex items-center justify-center gap-2">
                                <button
                                    class="rounded-lg bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                                    type="button"
                                    @click="setupEdit(training.rating_training_id)">
                                    <PencilSquareIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                                <button
                                    class="rounded-lg bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                    type="button"
                                    @click="destroy(training.rating_training_id)">
                                    <TrashIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState v-else message="Demander une formation en utilisant la liste déroulante en haut." title="Aucune formation demandée pour l'instant."/>
        </div>
        <RevokeTraining :form="revoke" :link="route('rating-trainings.destroy',{rating: rating.rating_id,rating_training: toDestroy ? toDestroy : -1})"
                        :opened="openDelete"
                        @close-modal="openDelete=false"/>
        <SaveTrainingModal :isEvaluated="isEvaluated" :isValidator="isValidator" :opened="openSave" :rating="rating" :training="trainingToEdit" :types="types"
                           @close-modal="openSave = false"/>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
