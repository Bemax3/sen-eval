<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Datatable from '@/Components/Common/Tables/Datatable.vue';
import TableHeading from '@/Components/Common/Tables/TableHeading.vue';
import TableData from '@/Components/Common/Tables/TableData.vue';
import {computed, reactive, ref, watch} from 'vue';
import {Head, router} from '@inertiajs/vue3';
import {getPagination, hasData} from '@/helpers/helper.js';
import EmptyState from '@/Components/Common/EmptyState.vue';
import axios from 'axios';
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";

const props = defineProps({
    roles: {
        type: Object,
    },
});
const pages = [{name: 'Roles', href: '#', current: true}]
const pagination = computed(() => getPagination(props.roles));
const displayedData = ref(props.roles.data);
const search = reactive({keyword: '', fields: ['role_name', 'role_code']});

watch(() => search.keyword,
    function (next) {
        if (next === '') {
            displayedData.value = props.roles.data;
        } else {
            axios.post(route('roles.search'), search).then(res => (displayedData.value = res.data));
        }
    }
);

watch(() => props.roles,
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
        <Head title="Roles"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Roles</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        La liste des roles des utilisateurs de l'application.
                    </p>
                </div>
            </div>
            <Datatable v-if="hasData(roles.data)" v-model="search.keyword" :pagination="pagination">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Nom du Role</TableHeading>
                        <TableHeading>Code du Role</TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="role in displayedData" :key="role.role_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ role.role_name }}</TableData>
                        <TableData>{{ role.role_code }}</TableData>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState
                v-else
                :link="route('roles.create')"
                action="Nouveau"
                message="Créer une nouvelle compétence en appuyant sur ce bouton"
                title="Pas de Compétence"/>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
