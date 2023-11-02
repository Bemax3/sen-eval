<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {capitalized, getPagination, hasData, moment} from "@/helpers/helper.js";
import {EyeIcon, IdentificationIcon, PlusIcon, ChevronDoubleRightIcon} from "@heroicons/vue/20/solid/index.js";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";
import Separator from "@/Components/LayoutParts/Separator.vue";
import {computed, reactive, ref, watch} from "vue";
import axios from "axios";

const props = defineProps({
    agent: {
        type: Object,
    },
    evals: {
        type: Object
    }
});

const pagination = computed(() => getPagination(props.evals));
const displayedData = ref(props.evals.data);
const search = reactive({
    keyword: '',
    fields: ['goal_name','goal_expected_result'],
});

watch(() => search.keyword,
    function (next) {
        if (next === '') {
            displayedData.value = props.evals.data;
        } else {
            axios.post(route('agent-goals.search',{agent: props.agent.user_id}), search).then(res => (displayedData.value = res.data));
        }
    }
);

const pages = [
    { name: 'Mes Agents', href: route('agents.index'), current: false },
    { name: 'Evaluations', href: '#', current: true },
]

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profil"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Evaluations de {{agent.user_display_name}}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Liste des evaluations de {{agent.user_display_name}}. Matricule : {{agent.user_matricule}}
                    </p>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('agent-goals.index',{agent: agent.user_id})"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        as="button">
                        Objectif
                        <ChevronDoubleRightIcon class="-mr-0.5 h-5 w-5"/>
                    </Link>
                </div>
            </div>
            <Separator title="Evaluations" />
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <SectionTitle title="Évaluations" desc="Cette liste est un descriptif des évaluations."/>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('evaluation.create',{agent: agent.user_id})"
                        as="button"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Évaluer cet agent
                        <PlusIcon class="-mr-0.5 h-5 w-5"/>
                    </Link>
                </div>
            </div>
            <Datatable :pagination="pagination" v-if="hasData(evals.data)" v-model="search.keyword">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Évaluateur</TableHeading>
                        <TableHeading>Évalué</TableHeading>
                        <TableHeading>Année</TableHeading>
                        <TableHeading>Note</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="e in displayedData" :key="e.evaluation_id">
                        <TableData class="whitespace-pre-line" :first="true">{{ e.evaluator.user_display_name + ' ' + e.evaluator.user_matricule  }}</TableData>
                        <TableData class="whitespace-pre-line" :first="true">{{ e.evaluated.user_display_name + ' ' + e.evaluated.user_matricule  }}</TableData>
                        <TableData>{{ e.phase.phase_year }}</TableData>
                        <TableData>
                            <span class="flex-shrink-0">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                    <span class="text-cyan-600">{{e.evaluation_mark}}</span>
                                </span>
                            </span>
                        </TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center">
                                <Link :href="route('evaluation.show', {agent: agent.user_id,evaluation: e.evaluation_id})" class="group flex items-center px-4 py-2 text-sm">
                                    <EyeIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600" aria-hidden="true" />
                                </Link>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4">Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState
                v-else
                title="Pas d'évaluation"
                message="Créer une nouvelle évaluation"
                :link="route('evaluation.create',{agent: agent.user_id})"
                action="Évaluer cet agent" />
        </div>
    </AuthenticatedLayout>
</template>
