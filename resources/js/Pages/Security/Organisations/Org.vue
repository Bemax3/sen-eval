<script setup>
import {getPagination, hasData} from "@/helpers/helper.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import {Head, Link, router} from '@inertiajs/vue3';
import {computed, reactive, ref, watch} from "vue";
import axios from "axios";
import {EyeIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    org: {type: Object},
    agents: {type: Object}
})

const pages = [
    {name: 'Organisations', href: route('orgs.index'), current: false},
    {name: props.org.org_name, href: '#', current: true},
]
const pagination = computed(() => getPagination(props.agents));
const displayedData = ref(props.agents.data);
const search = reactive({
    keyword: '',
    fields: ['user_matricule', 'user_display_name'],
    org_id: props.org.org_id
});

watch(() => search.keyword,
    function (next) {
        if (next === '') {
            displayedData.value = props.agents.data;
        } else {
            axios.post(route('users.search'), search).then(res => (displayedData.value = res.data));
        }
    }
);

watch(() => props.agents,
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
        <Head title="Organisation"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ props.org.org_name }}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        La liste des agents de la direction.
                    </p>
                </div>
            </div>
            <Datatable v-if="hasData(agents.data)" v-model="search.keyword" :pagination="pagination">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Matricule</TableHeading>

                        <TableHeading>Nom</TableHeading>
                        <TableHeading>Poste</TableHeading>
                        <TableHeading>GF</TableHeading>
                        <TableHeading>NR</TableHeading>
                        <TableHeading>CR</TableHeading>
                        <TableHeading>Organisation</TableHeading>
                        <TableHeading>CR Organisation</TableHeading>
                        <TableHeading></TableHeading>

                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="agent in displayedData" :key="agent.user_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ agent.user_matricule }}</TableData>
                        <TableData>{{ agent.user_display_name }}</TableData>
                        <TableData class="whitespace-pre-line">{{ agent.user_title }}</TableData>
                        <TableData>{{ agent.user_gf }}</TableData>
                        <TableData>{{ agent.user_nr }}</TableData>
                        <TableData>{{ agent.user_responsibility_center }}</TableData>
                        <TableData class="whitespace-pre-line">{{ agent.org ? agent.org.org_name : 'No Org' }}</TableData>
                        <TableData>{{ agent.org.org_responsibility_center }}</TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center">
                                <Link :href="route('users.show', {user: agent.user_id})" class="group flex items-center px-4 py-2 text-sm">
                                    <EyeIcon aria-hidden="true" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"/>
                                </Link>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState
                v-else
                :link="route('orgs.create')"
                action="Nouveau"
                message="Créer une nouvelle organisation en appuyant sur ce bouton"
                title="Pas d'organisation"/>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
