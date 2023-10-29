<script setup>
import {getPagination, hasData} from "@/helpers/helper.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import {MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {ChevronDownIcon, PencilSquareIcon} from '@heroicons/vue/20/solid';
import EmptyState from "@/Components/Common/EmptyState.vue";
import {Head, Link, router} from '@inertiajs/vue3';
import {computed, reactive, ref, watch} from "vue";
import axios from "axios";
import {EyeIcon} from "@heroicons/vue/20/solid/index.js";
const props = defineProps({
    org: {
        type: Object
    },
    agents: {
        type: Object
    }
})

const pagination = computed(() => getPagination(props.agents));

const displayedData = ref(props.agents.data);

const search = reactive({
    keyword: '',
    fields: ['user_matricule','user_first_name','user_last_name','user_title'],
    org_id: props.org.org_id
});

watch(
    () => search.keyword,
    function (next) {
        if (next === '') {
            displayedData.value = props.agents.data;
        } else {
            axios.post(route('users.search'), search).then(res => (displayedData.value = res.data));
        }
    }
);

watch(()=> props.agents,
    function (next) {
        displayedData.value = next.data;
        if(!displayedData.value.length > 0) {
            if(next.prev_page_url) router.get(next.prev_page_url)
            else router.get(next.first_page_url);
        }
    }
);

const pages = [
    { name: 'Organisations', href: route('orgs.index'), current: false },
    { name: props.org.org_name, href: '#', current: true },
]

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
            <Datatable :pagination="pagination" v-if="hasData(agents.data)" v-model="search.keyword">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Matricule</TableHeading>
                        <TableHeading>Prénom</TableHeading>
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
                        <TableData class="whitespace-pre-line" :first="true">{{ agent.user_matricule }}</TableData>
                        <TableData class="whitespace-pre-line">{{ agent.user_first_name }}</TableData>
                        <TableData >{{ agent.user_last_name }}</TableData>
                        <TableData class="whitespace-pre-line">{{ agent.user_title }}</TableData>
                        <TableData >{{ agent.user_gf }}</TableData>
                        <TableData >{{ agent.user_nr }}</TableData>
                        <TableData >{{ agent.user_responsibility_center }}</TableData>
                        <TableData class="whitespace-pre-line">{{ agent.org ? agent.org.org_name : 'No Org' }}</TableData>
                        <TableData >{{ agent.org.org_responsibility_center }}</TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center">
                                <Link :href="route('users.show', {user: agent.user_id})" class="group flex items-center px-4 py-2 text-sm">
                                    <EyeIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600" aria-hidden="true" />
                                </Link>
                            </div>
                        </td>
<!--                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">-->
<!--                            <Menu as="div" class="relative inline-block text-left">-->
<!--                                <div>-->
<!--                                    <MenuButton-->
<!--                                        class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">-->
<!--                                        Options-->
<!--                                        <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true" />-->
<!--                                    </MenuButton>-->
<!--                                </div>-->
<!--                                <transition-->
<!--                                    enter-active-class="transition ease-out duration-100"-->
<!--                                    enter-from-class="transform opacity-0 scale-95"-->
<!--                                    enter-to-class="transform opacity-100 scale-100"-->
<!--                                    leave-active-class="transition ease-in duration-75"-->
<!--                                    leave-from-class="transform opacity-100 scale-100"-->
<!--                                    leave-to-class="transform opacity-0 scale-95">-->
<!--                                    <MenuItems-->
<!--                                        class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">-->
<!--                                        <div class="py-1">-->
<!--                                            <MenuItem v-slot="{active}">-->
<!--                                                <Link-->
<!--                                                    :href="route('orgs.show', {org: org.org_id})"-->
<!--                                                    :class="[-->
<!--                                                            active ? 'bg-gray-100 text-cyan-600' : 'text-gray-700',-->
<!--                                                            'group flex items-center px-4 py-2 text-sm',-->
<!--                                                        ]">-->
<!--                                                    <PencilSquareIcon-->
<!--                                                        class="mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"-->
<!--                                                        aria-hidden="true" />-->
<!--                                                    Détails-->
<!--                                                </Link>-->
<!--                                            </MenuItem>-->
<!--                                        </div>-->
<!--                                    </MenuItems>-->
<!--                                </transition>-->
<!--                            </Menu>-->
<!--                        </td>-->
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé. </div>
            </Datatable>
            <EmptyState
                v-else
                title="Pas d'organisation"
                message="Créer une nouvelle organisation en appuyant sur ce bouton"
                :link="route('orgs.create')"
                action="Nouveau" />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
