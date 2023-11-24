<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {capitalized, getPagination, hasData, moment} from "@/helpers/helper.js";
import {CheckIcon, ChevronDoubleRightIcon, ChevronUpDownIcon, EyeIcon, PlusIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";
import Separator from "@/Components/LayoutParts/Separator.vue";
import {computed, reactive, ref, watch} from "vue";
import axios from "axios";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";

const props = defineProps({
	agent: {type: Object},
	goals: {type: Object},
	phases: {},
	phase_id: {}
});

const pages = [{name: 'Mes Agents', href: route('agents.index'), current: false}, {name: 'Objectifs', href: '#', current: true}]
const pagination = computed(() => getPagination(props.goals));
const displayedData = ref(props.goals.data);
const search = reactive({keyword: '', fields: ['goal_name', 'goal_expected_result']});


const form = useForm({
	phase_id: parseInt(props.phase_id) || -1
})

const filtrer = () => {
	router.get(route('agent-goals.index', {agent: props.agent.user_id, phase_id: form.phase_id}), {}, {preserveScroll: true})
}

watch(() => search.keyword, function (next) {
	if (next === '') {
		displayedData.value = props.goals.data;
	} else {
		axios.post(route('agent-goals.search', {agent: props.agent.user_id}), search).then(res => (displayedData.value = res.data));
	}
});


watch(() => props.goals, function (next) {
	displayedData.value = next.data;
	if (!displayedData.value.length > 0) {
		if (next.prev_page_url) router.get(next.prev_page_url)
		else router.get(next.first_page_url);
	}
});

</script>

<template>
	<AuthenticatedLayout>
		<Head title="Objectifs - Agents"/>
		<div class="px-4 sm:px-6 lg:px-8">
			<Breadcrumbs :pages="pages"/>
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-2xl font-semibold leading-6 text-gray-900">Objectifs de {{ agent.user_display_name }}</h1>
					<p class="mt-2 text-sm text-gray-700">
						Objectifs de {{ agent.user_display_name }}. Matricule : {{ agent.user_matricule }}
					</p>
				</div>
				<div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
					<Link
							:href="route('agent-ratings.index',{agent: agent.user_id})"
							as="button"
							class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
						Évaluations
						<ChevronDoubleRightIcon class="-mr-0.5 h-5 w-5"/>
					</Link>
				</div>
			</div>
			<Separator title="Objectifs"/>
			<div class="sm:flex sm:items-center border-b border-gray-400 pb-5">

				<SectionTitle desc="Tableau déscriptif des objectifs fixés à cet agent." title="Objectifs de l'agent"/>

				<div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
					<Link
							:href="route('agent-goals.create',{agent: agent.user_id})"
							as="button"
							class="inline-flex gap-x-1.5 rounded-md bg-cyan-600  px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
						Nouveau
						<PlusIcon class="-mr-0.5 h-5 w-5"/>
					</Link>
				</div>
			</div>
			<div class="mt-8 bg-white shadow sm:rounded-lg">
				<div class="px-4 py-5 sm:p-6">
					<h3 class="text-base font-semibold leading-6 text-gray-900">Filtres</h3>
					<div class="mt-2 max-w-xl text-sm text-gray-500">
						<p>Filtrer les données en fonction de l'année et de la direction</p>
					</div>
					<form class="mt-5 sm:flex sm:items-center gap-2" @submit.prevent="filtrer">
						<div class="w-full sm:max-w-xl">
							<InputLabel>Année d'évaluation</InputLabel>
							<div class="mt-2">
								<Listbox v-model="form.phase_id" as="div">
									<div class="relative mt-2">
										<ListboxButton
												class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6">
											<span class="block truncate">{{ phases.filter((type) => type.phase_id === form.phase_id)[0]?.phase_year || 'Toute confondues'
                                                }}</span>
											<span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </span>
										</ListboxButton>
										<transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
											<ListboxOptions
													class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
												<ListboxOption v-slot="{ active, selected }" :value="-1"
												               as="template">
													<li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
														<span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">Toute confondues</span>
														<span v-if="selected"
														      :class="[active ? 'text-white' : 'text-cyan-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                                        </span>
													</li>
												</ListboxOption>
												<ListboxOption v-for="type in phases" :key="type.phase_id" v-slot="{ active, selected }" :value="type.phase_id"
												               as="template">
													<li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
														<span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.phase_year }}</span>
														<span v-if="selected"
														      :class="[active ? 'text-white' : 'text-cyan-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                                        </span>
													</li>
												</ListboxOption>
											</ListboxOptions>
										</transition>
									</div>
								</Listbox>
							</div>
						</div>
						<div class="mt-8">
							<SubmitButton class="sm:ml-3 sm:mt-0 sm:w-auto" type="submit">Filtrer</SubmitButton>
						</div>
					</form>
				</div>
			</div>
			<Datatable v-if="hasData(goals.data)" v-model="search.keyword" :pagination="pagination">
				<table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
					<thead class="bg-gray-50">
					<tr>
						<TableHeading :first="true">Libelle</TableHeading>
						<TableHeading>Valeur Cible</TableHeading>
						<TableHeading>Disponibilité des Moyens</TableHeading>
						<TableHeading>Échéance</TableHeading>
						<!--						<TableHeading>Accepté / Contesté</TableHeading>-->
						<!--						<TableHeading>Reserve</TableHeading>-->
						<TableHeading>Taux de réalisation</TableHeading>
						<TableHeading>Année d'évaluation</TableHeading>
						<TableHeading>Barème</TableHeading>
						<TableHeading></TableHeading>
					</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 bg-white">
					<tr v-for="goal in displayedData" :key="goal.goal_id">
						<TableData :first="true" class="whitespace-pre-line">{{ goal.goal_name }}</TableData>
						<TableData class="whitespace-pre-line">{{ goal.goal_expected_result }}</TableData>
						<TableData>
                            <span :class="goal.goal_means_available ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'"
                                  class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ goal.goal_means_available ? 'Disponible' : 'Indisponible' }}
                            </span>
						</TableData>
						<TableData>{{ capitalized(moment(goal.goal_expected_date).format('DD MMMM YYYY')) }}</TableData>
						<!--						<TableData>-->
						<!--                            <span :class="goal.goal_is_accepted ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'"-->
						<!--                                  class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">-->
						<!--                                {{ goal.goal_is_accepted ? 'Accepté' : 'Contesté' }}-->
						<!--                            </span>-->
						<!--						</TableData>-->
						<!--						<TableData class="whitespace-break-spaces">-->
						<!--							{{ goal.goal_comment || '__' }}-->
						<!--						</TableData>-->
						<TableData class="whitespace-break-spaces">
							{{ goal.goal_rate }} %
						</TableData>
						<TableData class="whitespace-break-spaces">
							{{ goal.phase.phase_year }}
						</TableData>
						<TableData>
                            <span class="flex-shrink-0">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                                    <span class="text-cyan-700">{{ goal.goal_marking }}</span>
                                </span>
                            </span>
						</TableData>
						<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
							<div class="flex items-center justify-center">
								<Link :href="route('agent-goals.edit', {agent: agent.user_id, agent_goal: goal.goal_id})"
								      class="group flex items-center px-4 py-2 text-sm">
									<EyeIcon aria-hidden="true" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600"/>
								</Link>
								<button class="group flex items-center px-4 py-2 text-sm"
								        @click="router.delete(route('agent-goals.destroy',{agent: agent.user_id, agent_goal: goal.goal_id}))">
									<TrashIcon aria-hidden="true" class="mr-3 h-5 w-5 text-gray-400 group-hover:text-red-600"/>
								</button>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
				<div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
			</Datatable>
			<EmptyState
					v-else
					:link="route('agent-goals.create',{agent: agent.user_id})"
					action="Nouveau"
					message="Créer un objectif en appuyant sur ce bouton"
					title="Pas d'objectifs"/>
		</div>
	</AuthenticatedLayout>
</template>

<style scoped></style>
