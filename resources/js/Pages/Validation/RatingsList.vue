<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {getPagination, hasData} from "@/helpers/helper.js";
import {EyeIcon} from "@heroicons/vue/20/solid/index.js";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import {computed, reactive, ref, watch} from "vue";
import axios from "axios";

const props = defineProps({
	ratings: {
		type: Object
	}
});

const pages = [{name: 'Évaluations á valider', href: '#', current: true}]
const pagination = computed(() => getPagination(props.ratings));
const displayedData = ref(props.ratings.data);
const search = reactive({keyword: '', fields: ['goal_name', 'goal_expected_result']});

watch(() => search.keyword,
		function (next) {
			if (next === '') {
				displayedData.value = props.ratings.data;
			} else {
				axios.post(route('agent-goals.search', {agent: props.agent.user_id}), search).then(res => (displayedData.value = res.data));
			}
		}
);

</script>

<template>
	<AuthenticatedLayout>
		<Head title="Profil"/>
		<div class="px-4 sm:px-6 lg:px-8">
			<Breadcrumbs :pages="pages"/>
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-2xl font-semibold leading-6 text-gray-900">Évaluations á valider</h1>
					<p class="mt-2 text-sm text-gray-700">
						Liste des evaluations faites par mes agents.
					</p>
				</div>
			</div>
			<Datatable v-if="hasData(ratings.data)" v-model="search.keyword" :pagination="pagination">
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
					<tr v-for="e in displayedData" :key="e.rating_id">
						<TableData :first="true" class="whitespace-pre-line">
							{{ e.evaluator.user_display_name + ' ' + e.evaluator.user_matricule }}
						</TableData>
						<TableData :first="true" class="whitespace-pre-line">
							{{ e.evaluated.user_display_name + ' ' + e.evaluated.user_matricule }}
						</TableData>
						<TableData>{{ e.phase.phase_year }}</TableData>
						<TableData>
                            <span class="flex-shrink-0">
                                <span
		                                class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                    <span class="text-cyan-600">{{ e.rating_mark }}</span>
                                </span>
                            </span>
						</TableData>
						<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
							<div class="flex items-center justify-center">
								<Link :href="route('validations.show', {validation: e.rating_id})"
								      class="group flex items-center px-4 py-2 text-sm">
									<EyeIcon aria-hidden="true"
									         class="mr-3 h-5 w-5 text-gray-400 group-hover:text-amber-600"/>
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
					message="Vos agents ne vous ont pas transmis d'évaluation á valider."
					title="Pas d'évaluations"
			/>
		</div>
	</AuthenticatedLayout>
</template>

<style scoped></style>
