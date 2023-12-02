<script setup>

import TableData from "@/Components/Common/Tables/TableData.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import {computed, reactive, ref, watch} from "vue";
import {Head, Link, router} from "@inertiajs/vue3";
import {PencilSquareIcon, PlusIcon} from "@heroicons/vue/20/solid/index.js";
import {getPagination, hasData} from "@/helpers/helper.js";
import EmptyState from "@/Components/Common/EmptyState.vue";
import axios from "axios";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import ToggleOnDatatable from "@/Components/Forms/ToggleOnDatatable.vue";

const props = defineProps({
    sanctions: {type: Object}
})

const pages = [{name: 'Types de Sanction', href: '#', current: true}]
const pagination = computed(() => getPagination(props.sanctions));
const displayedData = ref(props.sanctions.data);
const search = reactive({keyword: '', fields: ['sanction_type_name']});

watch(() => search.keyword,
    function (next) {
        if (next === '') {
            displayedData.value = props.sanctions.data;
        } else {
            axios.post(route('sanctionTypes.search'), search).then(res => (displayedData.value = res.data));
        }
    }
);

watch(() => props.sanctions,
    function (next) {
        displayedData.value = next.data;
        if (!displayedData.value.length > 0) {
            if (next.prev_page_url) router.get(next.prev_page_url)
            else router.get(next.first_page_url);
        }
    });

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Types de Sanction"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">Types de Sanction</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-white"
                    >La liste des sanctions qu'il sera possible de donner lors de l'évaluation.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('sanctionTypes.create')"
                        as="button"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                    >Ajouter un Type
                        <PlusIcon class="-mr-0.5 h-5 w-5"/>
                    </Link>
                </div>
            </div>
            <Datatable v-if="hasData(sanctions.data)" v-model="search.keyword" :pagination="pagination">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300 dark:divide-black">
                    <thead class="bg-gray-50 dark:bg-grayish">
                    <tr>
                        <TableHeading :first="true">Nom</TableHeading>
                        <TableHeading>Description</TableHeading>
                        <TableHeading>Status</TableHeading>
                        <TableHeading>Modifier</TableHeading>

                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-black bg-white dark:bg-grayish">
                    <tr v-for="sanction in displayedData" :key="sanction.sanction_type_id">
                        <TableData :first="true">{{ sanction.sanction_type_name }}</TableData>
                        <TableData>{{ sanction.sanction_type_desc }}</TableData>
                        <TableData>
                            <div class="flex space-x-4">
                                <ToggleOnDatatable :link="route('sanctionTypes.update',{sanctionType: sanction.sanction_type_id})"
                                                   :value="sanction.sanction_type_is_active" obj="sanction_type_is_active"/>
                                <span
                                    :class="sanction.sanction_type_is_active ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white'"
                                    class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                    {{ sanction.sanction_type_is_active ? 'Activé' : 'Désactivé' }}
                                </span>
                            </div>
                        </TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center">
                                <Link :href="route('sanctionTypes.edit',{sanctionType: sanction.sanction_type_id})" class="group flex items-center px-4 py-2 text-sm">
                                    <PencilSquareIcon aria-hidden="true" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"/>

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
                :link="route('sanctionTypes.create')"
                action="Nouveau"
                message="Créer un nouveau type en appuyant sur ce bouton"
                title="Pas de type de sanction"
            />
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
