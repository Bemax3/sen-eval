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
import SavePromotionModal from "@/Pages/Rating/modals/SavePromotionModal.vue";


const props = defineProps({
    agent: {},
    rating: {},
    types: {type: Array},
    promotions: {}
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
const pagination = computed(() => getPagination(props.promotions));
const displayedData = ref(props.promotions.data);
const search = '';
const openDestroy = ref(false);
const openSave = ref(false);
const toDestroy = ref(displayedData[0]?.rating_mobility_id);
const promotionToEdit = ref(displayedData[0]);
const destroy = (id) => {
    toDestroy.value = id;
    openDestroy.value = true;
}
const setupEdit = (id) => {
    promotionToEdit.value = displayedData.value.filter(m => m.rating_promotion_id === id)[0];
    openSave.value = true
}

const savePromotion = () => {
    openSave.value = true
}

watch(() => props.promotions,
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
        <Head title="Promotion"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <Title :agent="agent" :rating="rating"/>
            <Tabs :agent_id="props.agent.user_id" :evaluated="isEvaluated" :rating_id="props.rating.rating_id" :validator="isValidator"/>
            <div class="sm:flex sm:items-center border-b border-gray-400  pb-5 mt-8">
                <SectionTitle desc="Liste des promotions demandées pour cette évaluation" title="Promotions"/>
                <div v-if="!isEvaluated && !isValidator && !rating.rating_is_validated" class="space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <button
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        @click="savePromotion()">
                        Nouvelle Promotion
                        <PlusIcon class="-mr-0.5 h-5 w-5"/>
                    </button>
                </div>
            </div>
            <Datatable v-if="hasData(promotions.data)" v-model="search" :pagination="pagination" :search="false">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300 dark:divide-black">
                    <thead class="bg-gray-50 dark:bg-grayish">
                    <tr>
                        <TableHeading :first="true">Nature</TableHeading>
                        <TableHeading>Demandée par</TableHeading>
                        <TableHeading>Éligibilité</TableHeading>
                        <TableHeading>Proposition</TableHeading>
                        <TableHeading class="whitespace-pre-line">Commentaire</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                    <tr v-for="promotion in displayedData" :key="promotion.rating_promotion_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ promotion.type.promotion_type_name }}</TableData>
                        <TableData>{{ rating.evaluator.user_display_name }}</TableData>
                        <TableData>
                            <span
                                :class="promotion.evaluated_is_eligible ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white'"
                                class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ promotion.evaluated_is_eligible ? 'Éligible' : 'Non Éligible' }}
                            </span>
                        </TableData>
                        <TableData>
                            <span
                                :class="promotion.is_proposed ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white'"
                                class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ promotion.is_proposed ? 'Proposé' : 'Non Proposé' }}
                            </span>
                        </TableData>
                        <TableData class="whitespace-pre-line">{{ promotion.rating_promotion_comment }}</TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div v-if="!isEvaluated && !isValidator && !rating.rating_is_validated" class="flex items-center justify-center gap-2">
                                <button
                                    class="rounded-lg bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                                    type="button"
                                    @click="setupEdit(promotion.rating_promotion_id)">
                                    <PencilSquareIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                                <button
                                    class="rounded-lg bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                    type="button"
                                    @click="destroy(promotion.rating_promotion_id)">
                                    <TrashIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState v-else :message="isEvaluated ? '' : 'Demander une promotion en utilisant le formulaire en haut.'"
                        title="Aucune promotions ou avancement demandée pour l'instant."/>
        </div>
        <DeleteModal :link="route('rating-promotions.destroy',{rating: rating.rating_id,rating_promotion: toDestroy ? toDestroy : -1})" :opened="openDestroy"
                     @close-modal="openDestroy=false"/>
        <SavePromotionModal :agent="agent" :isEvaluated="isEvaluated" :isValidator="isValidator" :opened="openSave" :promotion="promotionToEdit" :rating="rating"
                            :types="types"
                            @close-modal="openSave = false"/>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
