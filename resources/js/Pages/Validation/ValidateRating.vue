<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {computed, ref, watch} from "vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import Tabs from "@/Components/Rating/Tabs.vue";
import Title from "@/Components/Rating/Title.vue";
import SectionMark from "@/Components/Rating/SectionMark.vue";
import {hasData} from "@/helpers/helper.js";
import EmptyState from "@/Components/Common/EmptyState.vue";
import {CheckIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid/index.js";
import InputError from "@/Components/Forms/InputError.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import ValidatorsList from "@/Components/Rating/ValidatorsList.vue";
import axios from "axios";
import {Combobox, ComboboxButton, ComboboxInput, ComboboxOption, ComboboxOptions} from "@headlessui/vue";

const props = defineProps({
	rating: {type: Object},
	agent: {type: Object},
	marking: {},
	specific_skills: {type: Object},
	skills: {type: Object},
	goals: {type: Object},
	validators: {},
	n1: {type: Object},
	others: {},
})

const user = usePage().props.auth.user;

const pages = [
	{name: 'Mes Validations', href: route('ratings.index'), current: false},
	{name: 'Rating', href: '#', current: true},
]

const goalsTotal = computed(() => {
	let total = 0;
	props.goals.forEach(goal => total += goal.goal_mark)
	return total;
})

const validation = computed(() => props.validators.filter(v => v.validator_id === user.user_id)[0]);
const validationForm = useForm({
	validator_id: validation.value?.validator_id,
	has_validated: true,
})
const commentForm = useForm({
	remember: false,
	validator_id: validation.value?.validator_id,
	rating_validator_comment: validation.value?.rating_validator_comment || '',
	new_validator: props.n1?.user_id || props.others[0].user_id
})

const others = props.others;
const query = ref('')
const filteredN1 = ref(others)

const save = () => {
	commentForm.put(route('validations.update', {
		validation: validation.value.rating_validator_id
	}), {
		onError: err => {
			usePage().props.flash.notify = {type: 'error', message: err.rating_validator_comment}
		},
		preserveScroll: true
	});
}

const validate = () => {
	validationForm.put(route('validations.update', {
		validation: validation.value.rating_validator_id
	}), {
		onError: err => {
			usePage().props.flash.notify = {type: 'error', message: err.has_validated}
		},
		preserveScroll: true
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
			<Tabs :agent_id="agent.user_id" :rating_id="rating.rating_id" :validator="true"/>
			<div role="list">
				<div class="px-4 py-4 sm:px-0">
					<SectionMark :mark="rating.specific_skills_sum_rating_skill_mark"
					             :marking="marking.specific"
					             title="Compétences Spécifiques (Savoir, Savoir Faire, Savoir Être)"/>
					<ul v-if="hasData(specific_skills)" class="divide-y divide-gray-100" role="list">
						<li v-for="skill in specific_skills " :key="skill.rating_skill_id"
						    class="flex items-center justify-between gap-x-6 py-5">
							<div class="min-w-0">
								<div class="flex items-start gap-x-3">
									<p class="text-base font-bold leading-6 text-gray-900">
										{{ skill.rating_skill_name || skill.phase_skill.skill.skill_name }}
									</p>
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
									<p class="ml-0.5 font-bold">
										{{ skill.rating_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }}
									</p>
								</div>
							</div>
						</li>
					</ul>
					<EmptyState v-else message="Les compétences évaluées s'afficheront ici."
					            title="Pas encore de compétences évaluées."/>
				</div>
				<div class="px-4 py-4 sm:px-0">
					<SectionMark :mark="rating.general_skills_sum_rating_skill_mark" :marking="marking.general"
					             title="Compétences Générales"/>
					<ul class="divide-y divide-gray-100" role="list">
						<li v-for="skill in skills " :key="skill.rating_skill_id"
						    class="flex items-center justify-between gap-x-6 py-5">
							<div class="min-w-0">
								<div class="flex items-start gap-x-3">
									<p class="text-base font-bold leading-6 text-gray-900">
										{{ skill.phase_skill.skill.skill_name }}
									</p>
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
									<p class="ml-0.5 font-bold">
										{{ skill.rating_skill_mark }} / {{ skill.phase_skill.phase_skill_marking }}
									</p>
								</div>
							</div>
						</li>
					</ul>
				</div>
				<div class="px-4 py-4 sm:px-0">
					<SectionMark :mark="goalsTotal" :marking="marking.perf" title="Performances"/>
					<ul v-if="hasData(goals)" class="divide-y divide-gray-100" role="list">
						<li v-for="goal in goals " :key="goal.goal_id"
						    class="flex items-center justify-between gap-x-6 py-5">
							<div class="min-w-0">
								<div class="flex items-start gap-x-3">
									<p class="text-base font-bold leading-6 text-gray-900">{{ goal.goal_name }}</p>
									<p class="text-gray-700 bg-gray-50 ring-gray-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
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
					<EmptyState v-else
					            message="Les objectifs que l'évaluateur aura crée pour l'évalué s'afficherons automatiquement ici."
					            title="Pas encore d'objectif."/>
				</div>
			</div>
			<div class="px-4 py-4 sm:px-0">
				<SectionMark title="Commentaires"/>
				<div v-if="validators">
					<ValidatorsList :rating="rating" :validators="validators"/>
				</div>
				<EmptyState v-else message="Les commentaires des validateurs et de l'évalué s'afficheront ici."
				            title="Aucun commentaires pour l'instant. "/>
			</div>
			<div class="px-4 py-4 sm:px-0">
				<SectionMark title="Validation"/>
				<div class="mt-8 bg-white shadow sm:rounded-lg">
					<form @submit.prevent="save">
						<div class="grid grid-cols-2 gap-2">
							<div class="px-4 py-5 sm:p-6">
								<h3 class="text-base font-semibold leading-6 text-gray-900">Commentaire</h3>
								<div class="mt-2 max-w-xl text-sm text-gray-500">
									<p>Ajouter un commentaire. </p>
								</div>
								<div class="mt-5 sm:flex sm:items-center">
									<div class="w-full sm:max-w-xl">
										<div class="col-span-full">
											<InputLabel for="start_date"></InputLabel>
											<div class=" mt-2">
												<TextArea v-model="commentForm.rating_validator_comment"
												          :invalid="commentForm.errors.rating_validator_comment !== undefined"/>
											</div>
											<InputError :message="commentForm.errors.rating_validator_comment"/>
										</div>
									</div>
								</div>
							</div>
							<div class="px-4 py-5 sm:p-6">
								<h3 class="text-base font-semibold leading-6 text-gray-900">Transférer</h3>
								<div class="mt-2 max-w-xl text-sm text-gray-500">
									<p>Transférer l'évaluation au supérieur hiérarchique. </p>
								</div>
								<div class="mt-6 w-full sm:max-w-xl">
									<Combobox v-model="commentForm.new_validator">
										<div class="relative">
											<ComboboxInput
													:class="commentForm.errors.new_validator !== undefined ? 'focus:ring-red-600 ring-red-600' : ''"
													:display-value="(id) => { let selected = filteredN1.filter(n => n.user_id === id)[0];
                                                                    return selected ? selected.user_matricule + ' ' + selected.user_display_name : commentForm.new_validator.user_matricule + ' ' + commentForm.new_validator.user_display_name}"
													class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6"
													placeholder="Trouver votre N + 1"
													@change="searchAgent.keyword = query = $event.target.value; "/>
											<ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
												<ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
											</ComboboxButton>
											<ComboboxOptions v-if="filteredN1.length > 0"
											                 class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
												<ComboboxOption v-for="n1 in filteredN1" :key="n1.user_id" v-slot="{ active, selected }" :value="n1.user_id"
												                as="template">
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
									<input id="remember-n1" v-model="commentForm.remember" class="h-4 w-4 rounded border-gray-300 text-cyan-600 focus:ring-cyan-600"
									       name="remember-n1"
									       type="checkbox"/>
									<label class="ml-3 block text-sm leading-6 text-gray-900" for="remember-n1">Sauvegarder en tant que mon N + 1</label>
								</div>
							</div>
						</div>
						<div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
							<FormIndications/>
							<div>
								<SubmitButton class=" mt-3 sm:ml-3 sm:mt-0 sm:w-auto" type="submit">Enregistrer</SubmitButton>
								<button class="inline-flex gap-x-1.5 disabled:opacity-70 rounded-md bg-cyan-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600 mt-3 sm:ml-3 sm:mt-0 sm:w-auto"
								        @click.prevent="validate">Valider
									<CheckIcon class="text-white -mr-0.5 h-5 w-5"/>
								</button>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</AuthenticatedLayout>
</template>

<style scoped>

</style>
