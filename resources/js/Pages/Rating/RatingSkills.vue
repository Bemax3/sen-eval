<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {computed, reactive, ref, watch} from "vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import {CheckIcon, ChevronUpDownIcon, LockClosedIcon} from "@heroicons/vue/20/solid/index.js";
import Tabs from "@/Components/Rating/Tabs.vue";
import Title from "@/Components/Rating/Title.vue";
import SectionMark from "@/Components/Rating/SectionMark.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import {hasData} from "@/helpers/helper.js";
import {Combobox, ComboboxButton, ComboboxInput, ComboboxOption, ComboboxOptions} from "@headlessui/vue";
import axios from "axios";

const props = defineProps({
	rating: {type: Object},
	agent: {type: Object},
	marking: {},
	specific_skills: {type: Object},
	skills: {type: Object},
	agent_n2: {type: Object},
	others: {},
	goals: {type: Object}
})

const pages = [
	{name: 'Mes Evaluations', href: route('ratings.index'), current: false},
	{name: 'Rating', href: '#', current: true},
]
const evaluatorComment = props.rating.evaluator_comment || '';
const goalsTotal = computed(() => {
	let total = 0;
	props.goals.forEach(goal => total += goal.goal_mark)
	return total;
})
const n2 = useForm({
	validator_id: props.agent_n2 ? props.agent_n2.user_id : hasData(props.others) ? props.others[0].user_id : null,
	rating_is_contested: props.rating.rating_is_contested === 1
})
const searchAgent = reactive({keyword: '', fields: ['user_matricule', 'user_display_name']});
const commentForm = useForm({evaluated_comment: props.rating.evaluated_comment || ''})
const others = props.others;
const query = ref('')
const filteredN1 = ref(others)

const submitEval = () => {
	commentForm.put(route('ratings.update', {
		agent: props.agent.user_id,
		rating: props.rating.rating_id
	}), {
		onError: err => {
			usePage().props.flash.notify = {type: 'error', message: err.phase_skill_id}
		},
	})
}
const sendToN2 = () => {
	n2.put(route('ratings.update', {
		rating: props.rating.rating_id
	}), {
		onError: err => {
			usePage().props.flash.notify = {type: 'error', message: err.validator_id}
		},
	})
}

const getFromDb = () => {
	return axios.post(route('users.search'), searchAgent);
}

watch(() => query.value, function (next) {
	let filtered = next === ''
			? others
			: others.filter((n1) => {
				return n1.user_matricule.toLowerCase().includes(query.value.toLowerCase()) || n1.user_display_name.toLowerCase().includes(query.value.toLowerCase())
			})
	if (filtered.length > 0) filteredN1.value = filtered;
	else {
		if (next.length >= 3)
			getFromDb().then(res => filteredN1.value = res.data);
	}
})

</script>

<template>
	<AuthenticatedLayout>
		<Head title="Profil"/>
		<div class="px-4 sm:px-6 lg:px-8">
			<Breadcrumbs :pages="pages"/>
			<Title :agent="agent" :rating="rating"/>
			<Tabs :agent_id="agent.user_id" :evaluated="true" :rating_id="rating.rating_id"/>
			<div role="list">
				<div class="px-4 py-4 sm:px-0">
					<SectionMark :mark="rating.specific_skills_sum_rating_skill_mark" :marking="marking.specific"
					             title="Compétences Spécifiques (Savoir, Savoir Faire, Savoir Être)"/>
					<ul v-if="hasData(specific_skills)" class="divide-y divide-gray-100" role="list">
						<li v-for="skill in specific_skills " :key="skill.rating_skill_id" class="flex items-center justify-between gap-x-6 py-5">
							<div class="min-w-0">
								<div class="flex items-start gap-x-3">
									<p class="text-base font-bold leading-6 text-gray-900">{{ skill.phase_skill.skill.skill_name }}</p>
									<p v-if="skill.rating_skill_mark_is_claimed"
									   class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
										Contesté</p>
								</div>
								<div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
									<p class="whitespace-break-spaces">
										{{ skill.phase_skill.skill.skill_desc }}
									</p>
								</div>
							</div>
							<div class="flex flex-none items-center gap-x-4">
								<div class="flex items-center justify-center space-x-4">
									<p class="ml-0.5 font-bold"> {{ skill.rating_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }} </p>
								</div>
							</div>
						</li>
					</ul>
					<EmptyState v-else message="Les compétences sur lesquelles vous serait évalué s'afficheront ici." title="Vous n'avez pas encore été évalué."/>
				</div>
				<div class="px-4 py-4 sm:px-0">
					<SectionMark :mark="rating.general_skills_sum_rating_skill_mark" :marking="marking.general" title="Compétences Générales"/>
					<ul class="divide-y divide-gray-100" role="list">
						<li v-for="skill in skills " :key="skill.rating_skill_id" class="flex items-center justify-between gap-x-6 py-5">
							<div class="min-w-0">
								<div class="flex items-start gap-x-3">
									<p class="text-base font-bold leading-6 text-gray-900">{{ skill.phase_skill.skill.skill_name }}</p>
									<p v-if="skill.rating_skill_mark_is_claimed"
									   class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
										Contesté</p>
								</div>
								<div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
									<p class="whitespace-break-spaces">
										{{ skill.phase_skill.skill.skill_desc }}
									</p>
								</div>
							</div>
							<div class="flex flex-none items-center gap-x-4">
								<div class="flex items-center justify-center space-x-4">
									<p class="ml-0.5 font-bold"> {{ skill.rating_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }} </p>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="px-4 py-4 sm:px-0">
					<SectionMark :mark="goalsTotal" :marking="marking.perf" title="Performances"/>
					<ul v-if="hasData(goals)" class="divide-y divide-gray-100" role="list">
						<li v-for="goal in goals " :key="goal.goal_id" class="flex items-center justify-between gap-x-6 py-5">
							<div class="min-w-0">
								<div class="flex items-start gap-x-3">
									<p class="text-base font-bold leading-6 text-gray-900">{{ goal.goal_name }}</p>
									<p class="text-white bg-gray-500 ring-gray-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
										{{ goal.period.evaluation_period_name }}
									</p>
									<p v-if="goal.goal_mark_is_claimed"
									   class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
										Contesté
									</p>
								</div>
								<div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
									<p class="whitespace-break-spaces">
										{{ goal.goal_expected_result }}
									</p>
								</div>
							</div>
							<div class="flex flex-none items-center gap-x-4">
								<div class="flex items-center justify-center space-x-4">
									<p class="ml-0.5 font-bold"> {{ goal.goal_mark }} / {{ goal.goal_marking }} </p>
								</div>
							</div>
						</li>
					</ul>
					<EmptyState v-else message="Les objectifs que votre évaluateur aura crée pour vous s'afficherons automatiquement ici."
					            title="Vous n'avez pas encore d'objectif."/>
				</div>
			</div>
			<div class="px-4 py-4 sm:px-0">
				<SectionMark title="Commentaires"/>
				<form class="mt-8 bg-white shadow sm:rounded-lg" @submit.prevent="submitEval">
					<div class="grid grid-cols-2 gap-2">
						<div class="px-4 py-5 sm:p-6">
							<h3 class="text-base font-semibold leading-6 text-gray-900">Commentaire Évaluateur</h3>
							<div class="mt-2 max-w-xl text-sm text-gray-500">
								<p>Commentaire de {{ rating.evaluator.user_display_name }} </p>
							</div>
							<div class="mt-5 sm:flex sm:items-center">
								<div class="w-full sm:max-w-xl">
									<div class="col-span-full">
										<InputLabel for="start_date"></InputLabel>
										<div class="relative mt-2">
											<TextArea v-model="evaluatorComment" :disabled="true"/>
											<div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
												<LockClosedIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="px-4 py-5 sm:p-6">
							<h3 class="text-base font-semibold leading-6 text-gray-900">Commentaire Évalué</h3>
							<div class="mt-2 max-w-xl text-sm text-gray-500">
								<p>Ajouter un commentaire. </p>
							</div>
							<div class="mt-5 sm:flex sm:items-center">
								<div class="w-full sm:max-w-xl">
									<div class="col-span-full">
										<InputLabel for="start_date"></InputLabel>
										<div class=" mt-2">
											<TextArea v-model="commentForm.evaluated_comment"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
						<FormIndications/>
						<SubmitButton class="mt-3 sm:ml-3 sm:mt-0 sm:w-auto" type="submit">Enregistrer</SubmitButton>
					</div>
				</form>
			</div>
			<div class="px-4 py-4 sm:px-0">
				<SectionMark title="Validation"/>
				<form class="mt-8 bg-white shadow sm:rounded-lg" @submit.prevent="sendToN2">
					<div class="grid grid-cols-2 gap-2">
						<div class="px-4 py-5 sm:p-6">
							<h3 class="text-base font-semibold leading-6 text-gray-900">Transférer au N + 2</h3>
							<div class="mt-3 w-full sm:max-w-xl">
								<Combobox v-model="n2.validator_id">
									<div class="relative">
										<ComboboxInput
												:class="n2.errors.validator_id !== undefined ? 'focus:ring-red-600 ring-red-600' : ''"
												:display-value="(id) => { let selected = filteredN1.filter(n => n.user_id === id)[0];
                                                                    return selected ? selected.user_matricule + ' ' + selected.user_display_name : agent_n2.user_matricule + ' ' + agent_n2.user_display_name}"
												class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6"
												placeholder="Trouver votre N + 1"
												@change="searchAgent.keyword = query = $event.target.value; "/>
										<ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
											<ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
										</ComboboxButton>
										<ComboboxOptions v-if="filteredN1.length > 0"
										                 class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
											<ComboboxOption v-for="n1 in filteredN1" :key="n1.user_id" v-slot="{ active, selected }" :value="n1.user_id" as="template">
												<li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-cyan-600 text-white' : 'text-gray-900']">
													<div class="flex">
                                                        <span :class="['truncate', selected && 'font-semibold']">
                                                            {{ n1?.user_matricule + ' ' + n1?.user_display_name }}
                                                        </span>
													</div>
													<span v-if="selected"
													      :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-cyan-600']">
                                                        <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                                    </span>
												</li>
											</ComboboxOption>
										</ComboboxOptions>
									</div>
								</Combobox>
							</div>
							<div class=" mt-3 flex items-center">
								<input id="validate-n1" v-model="n2.rating_is_contested" class="h-4 w-4 rounded border-gray-300 text-cyan-600 focus:ring-cyan-600"
								       name="validate-n1"
								       type="checkbox"/>
								<label class="ml-3 block text-sm leading-6 text-gray-900" for="validate-n1">Contester l'évaluation</label>
							</div>
						</div>
					</div>
					<div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
						<FormIndications/>
						<SubmitButton class="mt-3 sm:ml-3 sm:mt-0 sm:w-auto" type="submit">Enregistrer</SubmitButton>
					</div>
				</form>
			</div>
		</div>
	</AuthenticatedLayout>
</template>

<style scoped>

</style>
