<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {computed, ref} from 'vue';
import {Head} from '@inertiajs/vue3';
import {getPagination, hasData} from '@/helpers/helper.js';
import {ArrowDownTrayIcon} from "@heroicons/vue/20/solid/index.js";
import EmptyState from '@/Components/Common/EmptyState.vue';
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";

const props = defineProps({
    trainings: {
        type: Object,
    },
    phase: {},
    org: {},
});

const pages = [{
    name: 'Statistiques',
    href: route('admin-dashboard.index', {org_id: props.org.org_id, phase_id: props.phase.phase_id}),
    current: false
}, {name: 'Liste des formations demandées', href: '#', current: true}]
const pagination = computed(() => getPagination(props.trainings));
const displayedData = ref(props.trainings.data);
const search = ''

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Agents"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Formations demandées pour l'année
                        {{ phase.phase_year }}
                        {{ org !== -1 ? ' - ' + org.org_name : '' }}</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-white">
                        La liste des formations demandées pour l'année {{ phase.phase_year }}.
                    </p>
                </div>
                <div v-if="displayedData.length > 0" class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <a
                        :href="route('admin-dashboard.download-all-trainings',{org_id: org.org_id, phase_id: phase.phase_id})"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Télécharger
                        <ArrowDownTrayIcon class="-mr-0.5 h-5 w-5"/>
                    </a>
                </div>
            </div>
            <Datatable v-if="hasData(trainings.data)" v-model="search" :pagination="pagination" :search="false">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300 dark:divide-black">
                    <thead class="bg-gray-50 dark:bg-grayish">
                    <tr>
                        <TableHeading :first="true">Formation</TableHeading>
                        <TableHeading>Évalué</TableHeading>
                        <TableHeading>Évaluateur</TableHeading>
                        <TableHeading>Demandée par</TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                    <tr v-for="training in displayedData" :key="training.rating_training_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ training.type.training_type_name }}</TableData>
                        <TableData>{{ training.rating.evaluated.user_display_name }}</TableData>
                        <TableData>{{ training.rating.evaluator.user_display_name }}</TableData>
                        <TableData class="whitespace-pre-line">
                            <template v-if="training.asked_by_evaluator && !training.asked_by_evaluated">
                                L'évaluateur
                            </template>
                            <template v-if="training.asked_by_evaluated && !training.asked_by_evaluator">
                                L'évalué
                            </template>
                            <template v-if="training.asked_by_evaluated && training.asked_by_evaluator">
                                L'évaluateur et l'évalué
                            </template>
                        </TableData>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white dark:bg-grayish text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState
                v-else
                message="Tous les agents ont été évalués"
                title="Pas d'agent non évalué"/>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
