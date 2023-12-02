<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Datatable from '@/Components/Common/Tables/Datatable.vue';
import TableHeading from '@/Components/Common/Tables/TableHeading.vue';
import TableData from '@/Components/Common/Tables/TableData.vue';
import {computed, ref} from 'vue';
import {Head, Link} from '@inertiajs/vue3';
import {getPagination, hasData} from '@/helpers/helper.js';
import EmptyState from '@/Components/Common/EmptyState.vue';
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {EyeIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    users: {
        type: Object,
    },
    phase: {},
    org: {}
});

const pages = [{
    name: 'Statistiques',
    href: route('admin-dashboard.index', {org_id: props.org.org_id, phase_id: props.phase.phase_id}),
    current: false
}, {name: 'Agents non évalués', href: '#', current: true}]
const pagination = computed(() => getPagination(props.users));
const displayedData = ref(props.users.data);
const search = ''

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Agents"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Agents non évalués pour l'année {{ phase.phase_year }}
                        {{ org !== -1 ? ' - ' + org.org_name : '' }}</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-white">
                        La liste des agents non évalués pour l'année {{ phase.phase_year }}.
                    </p>
                </div>
            </div>
            <Datatable v-if="hasData(users.data)" v-model="search" :pagination="pagination" :search="false">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300 dark:divide-black">
                    <thead class="bg-gray-50 dark:bg-grayish">
                    <tr>
                        <TableHeading :first="true">Matricule</TableHeading>
                        <TableHeading>Nom</TableHeading>
                        <TableHeading>Poste</TableHeading>
                        <TableHeading>GF</TableHeading>
                        <TableHeading>NR</TableHeading>
                        <TableHeading>CR</TableHeading>
                        <TableHeading>Organisation</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                    <tr v-for="user in displayedData" :key="user.user_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ user.user_matricule }}</TableData>
                        <TableData>{{ user.user_display_name }}</TableData>
                        <TableData class="whitespace-pre-line">{{ user.user_title }}</TableData>
                        <TableData>{{ user.user_gf }}</TableData>
                        <TableData>{{ user.user_nr }}</TableData>
                        <TableData>{{ user.user_responsibility_center }}</TableData>
                        <TableData class="whitespace-pre-line">{{ user.org ? user.org.org_name : 'No Org' }}</TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center">
                                <Link :href="route('users.show', {user: user.user_id})" class="group flex items-center px-4 py-2 text-sm">
                                    <EyeIcon aria-hidden="true" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"/>
                                </Link>
                            </div>
                        </td>
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
