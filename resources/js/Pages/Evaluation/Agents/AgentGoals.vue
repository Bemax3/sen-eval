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
    goals: {
        type: Object
    }
});

const pagination = computed(() => getPagination(props.goals));
const displayedData = ref(props.goals.data);
const search = reactive({
    keyword: '',
    fields: ['goal_name','goal_expected_result'],
});

watch(() => search.keyword,
    function (next) {
        if (next === '') {
            displayedData.value = props.goals.data;
        } else {
            axios.post(route('agent-goals.search',{agent: props.agent.user_id}), search).then(res => (displayedData.value = res.data));
        }
    }
);

const pages = [
    { name: 'Objectifs', href: '#', current: true },
]

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profil"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Objectifs de {{agent.user_first_name + ' ' + agent.user_last_name}}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Objectifs de {{agent.user_first_name + ' ' + agent.user_last_name}}. Matricule : {{agent.user_matricule}}
                    </p>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        href="#"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                        as="button">
                        Evaluations
                        <ChevronDoubleRightIcon class="-mr-0.5 h-5 w-5"/>
                    </Link>
                </div>
            </div>
            <Separator title="Objectifs" />
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <SectionTitle title="Objectifs de l'agent" desc="Cette liste représente les objectifs fixés á cet agent."/>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('agent-goals.create',{agent: agent.user_id})"
                        as="button"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Nouveau
                        <PlusIcon class="-mr-0.5 h-5 w-5"/>
                    </Link>
                </div>
            </div>
            <Datatable :pagination="pagination" v-if="hasData(goals.data)" v-model="search.keyword">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Libelle</TableHeading>
                        <TableHeading>Valeur Cible</TableHeading>
                        <TableHeading>Disponibilité des Moyens</TableHeading>
                        <TableHeading>Échéance</TableHeading>
                        <TableHeading>Accepté / Contesté</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="goal in displayedData" :key="goal.goal_id">
                        <TableData class="whitespace-pre-line" :first="true">{{ goal.goal_name }}</TableData>
                        <TableData class="whitespace-pre-line">{{ goal.goal_expected_result }}</TableData>
                        <TableData>
                            <span :class="goal.goal_means_available ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'" class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ goal.goal_means_available ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </TableData>
                        <TableData >{{ capitalized(moment(goal.goal_expected_date).format('DD MMMM YYYY')) }}</TableData>
                        <TableData>
                            <span :class="goal.goal_is_accepted ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'" class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ goal.goal_is_accepted ? 'Accepté' : 'Contesté' }}
                            </span>
                        </TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center">
                                <Link :href="route('agent-goals.edit', {agent: agent.user_id, agent_goal: goal.goal_id})" class="group flex items-center px-4 py-2 text-sm">
                                    <EyeIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600" aria-hidden="true" />
                                </Link>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé. </div>
            </Datatable>
            <EmptyState
                v-else
                title="Pas d'objectifs"
                message="Créer un objectif en appuyant sur ce bouton"
                :link="route('agent-goals.create',{agent: agent.user_id})"
                action="Nouveau" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
