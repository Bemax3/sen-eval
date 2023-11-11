<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Datatable from '@/Components/Common/Tables/Datatable.vue';
import TableHeading from '@/Components/Common/Tables/TableHeading.vue';
import TableData from '@/Components/Common/Tables/TableData.vue';
import {computed, reactive, ref, watch} from 'vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {Cog6ToothIcon, PencilSquareIcon, PlusIcon} from '@heroicons/vue/20/solid';
import {getPagination, hasData} from '@/helpers/helper.js';
import EmptyState from '@/Components/Common/EmptyState.vue';
import axios from 'axios';
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import ToggleOnDatatable from "@/Components/Forms/ToggleOnDatatable.vue";

const props = defineProps({
	phases: {
		type: Object,
	},
});
const pagination = computed(() => getPagination(props.phases));
const displayedData = ref(props.phases.data);
const search = reactive({
	keyword: '',
	fields: ['phase_name'],
});
const pages = [
	{name: 'Phase d\'évaluation', href: '#', current: true},
]

watch(() => search.keyword,
		function (next) {
			if (next === '') {
				displayedData.value = props.phases.data;
			} else {
				axios.post(route('phases.search'), search).then(res => (displayedData.value = res.data));
			}
		}
);
watch(() => props.phases,
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
		<Head title="Phases d'évaluation"/>
		<div class="px-4 sm:px-6 lg:px-8">
			<Breadcrumbs :pages="pages"/>
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-2xl font-semibold leading-6 text-gray-900">Phases d'évaluation</h1>
					<p class="mt-2 text-sm text-gray-700">
						La liste des phases d'évaluation
					</p>
				</div>
				<div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
					<Link
							:href="route('phases.create')"
							as="button"
							class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
						Ajouter une phase
						<PlusIcon class="-mr-0.5 h-5 w-5"/>
					</Link>
				</div>
			</div>
			<Datatable v-if="hasData(phases.data)" v-model="search.keyword" :pagination="pagination">
				<table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
					<thead class="bg-gray-50">
					<tr>
						<TableHeading :first="true">Nom</TableHeading>
						<TableHeading>Année de l'évaluation</TableHeading>
						<TableHeading>Activée</TableHeading>
						<TableHeading>Details et modification</TableHeading>
					</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 bg-white">
					<tr v-for="phase in displayedData" :key="phase.phase_id">
						<TableData :first="true">{{ phase.phase_name }}</TableData>
						<TableData>{{ phase.phase_year }}</TableData>
						<TableData>
							<div class="flex space-x-4">
								<ToggleOnDatatable :link="route('phases.update-status',{phase: phase.phase_id})" :value="phase.phase_is_active" obj="phase_is_active"/>
								<span
										:class="phase.phase_is_active ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'"
										class="rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                    {{ phase.phase_is_active ? 'Activé' : 'Désactivé' }}
                                </span>
							</div>
						</TableData>
						<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
							<div class="flex items-center">
								<Link :href="route('phaseSkills.show', {phaseSkill: phase.phase_id})" class="group flex items-center px-4 py-2 text-sm">
									<Cog6ToothIcon aria-hidden="true" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"/>
								</Link>
								<Link :href="route('phases.edit', {phase: phase.phase_id})" class="group flex items-center px-4 py-2 text-sm">
									<PencilSquareIcon aria-hidden="true" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"/>
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
					:link="route('phases.create')"
					action="Nouveau"
					message="Créer un nouveau type en appuyant sur ce bouton"
					title="Pas de type de réclamation"/>
		</div>
	</AuthenticatedLayout>
</template>

<style scoped></style>
