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
import SaveClaimModal from "@/Pages/Rating/modals/SaveClaimModal.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";

const props = defineProps({
    agent: {},
    rating: {},
    types: {type: Array},
    claims: {}
})

const user = usePage().props.auth.user;

const isEvaluated = computed(() => user.user_id === props.rating.evaluated_id)
const isValidator = computed(() => user.user_id !== props.rating.evaluated_id && user.user_id !== props.rating.evaluator_id)

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


const search = ''
const pagination = computed(() => getPagination(props.claims));
const displayedData = ref(props.claims.data);
const openDelete = ref(false);
const openSave = ref(false);
const toDestroy = ref(displayedData[0]?.rating_claim_id);
const claimToEdit = ref(displayedData[0])
const destroy = (id) => {
    toDestroy.value = id;
    openDelete.value = true;
}
const setupEdit = (id) => {
    claimToEdit.value = displayedData.value.filter(m => m.rating_claim_id === id)[0];
    openSave.value = true
}

const saveClaim = () => {
    openSave.value = true;
}

watch(() => props.claims,
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
        <Head title="Réclamations"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <Title :agent="agent" :rating="rating"/>
            <Tabs :agent_id="props.agent.user_id" :evaluated="isEvaluated" :rating_id="props.rating.rating_id" :validator="isValidator"/>
            <div class="sm:flex sm:items-center border-b border-gray-400  pb-5 mt-8">
                <SectionTitle desc="Liste des réclamations demandées pour cette évaluation" title="Réclamations"/>
                <div v-if="isEvaluated && !rating.rating_is_validated" class="space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <button
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        @click="saveClaim()">
                        Nouvelle Réclamation
                        <PlusIcon class="-mr-0.5 h-5 w-5"/>
                    </button>
                </div>
            </div>
            <Datatable v-if="hasData(claims.data)" v-model="search" :pagination="pagination" :search="false">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300 dark:divide-black">
                    <thead class="bg-gray-50 dark:bg-grayish">
                    <tr>
                        <TableHeading :first="true">Type</TableHeading>
                        <TableHeading class="whitespace-pre-line">Commentaire</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                    <tr v-for="claim in displayedData" :key="claim.rating_claim_id">
                        <TableData :first="true">{{ claim.type.claim_type_name }}</TableData>
                        <TableData class="whitespace-pre-line">{{ claim.rating_claim_comment || '__' }}</TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div v-if="isEvaluated && !rating.rating_is_validated" class="flex items-center justify-center gap-2">
                                <button
                                    class="rounded-lg bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                                    type="button"
                                    @click="setupEdit(claim.rating_claim_id)">
                                    <PencilSquareIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                                <button
                                    class="rounded-lg bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                    type="button"
                                    @click="destroy(claim.rating_claim_id)">
                                    <TrashIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState v-else :message="isEvaluated ? 'Demander une réclamation en utilisant la liste déroulante en haut.' : ''"
                        title="Aucune réclamation faite pour l'instant."/>
        </div>
        <DeleteModal :link="route('rating-claims.destroy',{rating: rating.rating_id,rating_claim: toDestroy ? toDestroy : -1})" :opened="openDelete"
                     @close-modal="openDelete = false"/>
        <SaveClaimModal :claim="claimToEdit" :isEvaluated="isEvaluated" :opened="openSave" :rating="rating" :types="types" @close-modal="openSave = false"/>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
