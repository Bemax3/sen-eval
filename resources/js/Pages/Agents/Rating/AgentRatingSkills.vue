<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, useForm, usePage} from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Tabs from "@/Components/Rating/Tabs.vue";
import {CheckIcon, ChevronUpDownIcon, PencilSquareIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import {computed, reactive, ref, watch} from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import {Combobox, ComboboxButton, ComboboxInput, ComboboxOption, ComboboxOptions, Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {capitalized, hasData, moment} from "@/helpers/helper.js";
import TextArea from "@/Components/Forms/TextArea.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import SectionMark from "@/Components/Rating/SectionMark.vue";
import Title from "@/Components/Rating/Title.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import axios from "axios";
import InputError from "@/Components/Forms/InputError.vue";
import ValidatorsList from "@/Components/Rating/ValidatorsList.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import ValidationWarning from "@/Components/Rating/ValidationWarning.vue";

const props = defineProps({
	rating: {type: Object},
	marking: {type: Object},
	agent: {type: Object},
	specific_skill_types: {},
	specific_skills: {type: Object},
	skills: {type: Object},
	goals: {type: Object},
	n1: {type: Object},
	others: {},
	validators: {}
})

const user = usePage().props.auth.user;

const pages = [
	{name: 'Mes Agents', href: route('agents.index'), current: false},
	{name: 'Évaluations', href: route('agent-ratings.index', {agent: props.agent.user_id}), current: false},
]

const form = useForm({
	rating_id: props.rating.rating_id,
	rating_skill_name: '',
	phase_skill_id: props.specific_skill_types[0] ? props.specific_skill_types[0].pivot.phase_skill_id : null,
})

const searchAgent = reactive({keyword: '', fields: ['user_matricule', 'user_display_name']});
const validation = computed(() => props.validators.filter(v => v.validator_id === user.user_id)[0]);
const commentForm = useForm({
	remember: false,
	validator_id: validation.value?.validator_id,
	rating_validator_comment: validation.value?.rating_validator_comment || '',
	new_validator: props.n1?.user_id || props.others[0].user_id
})


const others = props.others;
const query = ref('')
const filteredN1 = ref(others)
const edits = ref([]);
const inputs = ref([]);
const open = ref(false);

const goalsTotal = computed(() => {
	let total = 0;
	props.goals.forEach(goal => total += goal.goal_mark)
	return total;
})

const save = () => {
	commentForm.put(route('validations.update', {
		validation: validation.value.rating_validator_id
	}), {
		onError: err => {
			usePage().props.flash.notify = {type: 'error', message: err.rating_validator_comment}
		},
		preserveScroll: true
	})
}

const getFromDb = () => {
	return axios.post(route('users.search'), searchAgent);
}

const setupEdits = () => {
	edits.value = [];
	props.skills.forEach(item => edits.value.push({id: item.rating_skill_id, edit: item.rating_skill_mark < 0}))
	props.goals.forEach(item => edits.value.push({id: 'goal_' + item.goal_id, edit: item.goal_mark < 0}))
	props.specific_skills.forEach(item => edits.value.push({id: item.rating_skill_id, edit: item.rating_skill_mark < 0}))
}

const editMark = (id) => {
	return edits.value.filter(s => s.id === id)[0].edit
}

const updateMark = (id, marking) => {
	const input = inputs.value[id];
	edits.value.find(s => s.id === id).edit = false;
	router.put(
			route('rating-skills.update', {rating_skill: id}),
			{rating_skill_mark: input.value, rating_skill_marking: marking},
			{
				onSuccess: () => setupEdits(),
				onError: err => {
					setupEdits();
					console.log(err)
					usePage().props.flash.notify = {type: 'error', message: err.rating_skill_mark}
				},
				preserveScroll: true
			}
	);

}

const updateGoal = (id, marking) => {
	const input = inputs.value['goal_' + id];
	edits.value.find(s => s.id === ('goal_' + id)).edit = false;

	router.put(
			route('goals.update-mark', {goal: id}),
			{goal_mark: input.value, goal_marking: marking, rating_id: props.rating.rating_id},
			{
				onSuccess: () => setupEdits(),
				onError: err => {
					setupEdits();
					// console.log(err)
					usePage().props.flash.notify = {type: 'error', message: err.goal_mark}
				},
				preserveScroll: true
			}
	);
}

const addSpecificSkill = () => {
	form.post(route('rating-skills.store'), {
		onError: err => {
			setupEdits();
			usePage().props.flash.notify = {type: 'error', message: err.phase_skill_id}
		},
		onSuccess: () => setupEdits(),
		preserveScroll: true
	})
}

setupEdits();

watch(() => props.specific_skills, function () {
	setupEdits();
}, {immediate: true})

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
		<Head title="Évaluation"/>
		<div class="px-4 sm:px-6 lg:px-8">
			<Breadcrumbs :pages="pages"/>
			<Title :agent="agent" :rating="rating"/>
			<Tabs :agent_id="props.agent.user_id" :rating_id="props.rating.rating_id"/>
			<div role="list">
				<div class="px-4 py-4 sm:px-0">
					<div v-if="!rating.rating_is_validated" class="pr-4 py-5 sm:pr-6 bg-white mb-4 px-5 rounded-lg shadow">
						<InputLabel>Ajouter une compétence spécifique à évaluer</InputLabel>
						<form class="mt-5 sm:flex sm:items-center gap-x-6" @submit.prevent="addSpecificSkill">
							<div :class="form.errors.rating_skill_name ? 'mb-4' : ''" class="w-full sm:max-w-xl">
								<Listbox v-model="form.phase_skill_id" as="div">
									<div class="relative">
										<ListboxButton
												class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-700 sm:text-sm sm:leading-6">
                                            <span v-if="hasData(specific_skill_types)"
                                                  class="block truncate">{{ specific_skill_types.filter((type) => type.pivot.phase_skill_id === form.phase_skill_id)[0].skill_name
                                                }}</span>
											<span v-else class="block truncate">Aucune compétences disponible pour l'instant.</span>
											<span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </span>
										</ListboxButton>
										<transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
											<ListboxOptions v-if="hasData(specific_skill_types)"
											                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
												<ListboxOption v-for="type in specific_skill_types" :key="type.skill_id" v-slot="{ active, selected }"
												               :value="type.pivot.phase_skill_id" as="template">
													<li :class="[active ? 'bg-cyan-600  text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
														<span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.skill_name }}</span>
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
							<div v-if="specific_skill_types.filter((type) => type.pivot.phase_skill_id === form.phase_skill_id)[0].skill_id === 1"
							     class="w-full sm:max-w-xl mt-4 sm:mt-0">
								<TextInput v-model="form.rating_skill_name" :invalid="form.errors.rating_skill_name !== undefined"
								           placeholder="p. ex. Bonne Gouvernance des SI"/>
								<div class="flex flex-col space-y-2">
									<InputError :message="form.errors.rating_skill_name"/>
								</div>
							</div>
							<SubmitButton :class="form.errors.rating_skill_name ? 'mb-4' : ''" :disabled="rating.rating_is_validated" :processing="form.processing"
							              class="mt-2 sm:ml-3 sm:mt-0 sm:w-auto"
							              type="submit">Ajouter
							</SubmitButton>
						</form>
					</div>
					<SectionMark :mark="rating.specific_skills_sum_rating_skill_mark" :marking="marking.specific"
					             title="Compétences Spécifiques (Savoir, Savoir Faire, Savoir Être)"/>
					<ul v-if="hasData(specific_skills)" class="divide-y divide-gray-100" role="list">
						<li v-for="skill in specific_skills " :key="skill.rating_skill_id" class="flex items-center justify-between gap-x-6 py-5">
							<div class="min-w-0">
								<div class="flex items-start gap-x-3">
									<p class="text-base font-bold leading-6 text-gray-900">{{ skill.rating_skill_name || skill.phase_skill.skill.skill_name }}</p>
									<p v-if="skill.rating_skill_mark_is_claimed"
									   class="text-red-700 bg-red-50 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
										Contesté</p>
								</div>
								<div class="mt-1 flex items-center gap-x-2 text-base leading-5 text-gray-500">
									<p class="whitespace-break-spaces">
										{{ skill.phase_skill.skill.skill_desc }}
									</p>
								</div>
								<div v-if="skill.rating_skill_mark > 0" class="mt-1 flex items-center gap-x-2 text-sm leading-5 text-gray-500">
									<p class="whitespace-break-spaces">Note attribué le {{ capitalized(moment(skill.updated_at).format('DD MMMM YYYY à HH:mm')) }}</p>
								</div>
							</div>
							<div class="flex flex-none items-center gap-x-4">
								<div class="flex items-center justify-center space-x-4">
									<template v-if="!editMark(skill.rating_skill_id)">
										{{ skill.rating_skill_mark }}
									</template>
									<template v-else>
										<input :ref="el => {inputs[skill.rating_skill_id] = el}" :value="skill.rating_skill_mark"
										       class="w-12 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-700 sm:text-sm sm:leading-6"
										       type="text"/>
									</template>
									<p class="ml-0.5 font-bold">
										/ {{ skill.phase_skill.phase_skill_marking }}
									</p>
									<template v-if="!rating.rating_is_validated">
										<template v-if="!editMark(skill.rating_skill_id)">
											<button
													class="rounded-full bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
													type="button"
													@click="edits.find(s => s.id === skill.rating_skill_id).edit = true">
												<PencilSquareIcon aria-hidden="true" class="h-5 w-5"/>
											</button>
										</template>
										<template v-else>
											<button
													class="rounded-full bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
													type="button"
													@click="updateMark(skill.rating_skill_id,skill.phase_skill.phase_skill_marking)">
												<CheckIcon aria-hidden="true" class="h-5 w-5"/>
											</button>
										</template>
										<button
												class="rounded-full bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
												type="button"
												@click="router.delete(route('rating-skills.destroy',{rating_skill: skill.rating_skill_id}))">
											<TrashIcon aria-hidden="true" class="h-5 w-5"/>
										</button>
									</template>
								</div>
							</div>
						</li>
					</ul>
					<EmptyState v-else message="Ajouter des compétences à évaluer en utilisant la liste déroulante plus haut."
					            title="Vous n'avez pas ajouter de compétences spécifiques à évaluer."/>
				</div>
				<div class="px-4 py-4 sm:px-0">
					<SectionMark :mark="rating.general_skills_sum_rating_skill_mark" :marking="marking.general" title="Compétences Générales"/>
					<ul v-if="hasData(skills)" class="divide-y divide-gray-100" role="list">
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
								<div v-if="skill.rating_skill_mark > 0" class="mt-1 flex items-center gap-x-2 text-sm leading-5 text-gray-500">
									<p class="whitespace-break-spaces">Note attribué le {{ capitalized(moment(skill.updated_at).format('DD MMMM YYYY à HH:mm')) }}</p>
								</div>
							</div>
							<div class="flex flex-none items-center gap-x-4">
								<div class="flex items-center justify-center space-x-4">
									<template v-if="!editMark(skill.rating_skill_id)">
										{{ skill.rating_skill_mark }}
									</template>
									<template v-else>
										<input :ref="el => {inputs[skill.rating_skill_id] = el}" :value="skill.rating_skill_mark"
										       class=" w-12 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-700 sm:text-sm sm:leading-6"
										       type="text"/>
									</template>
									<p class="ml-0.5 font-bold">
										/ {{ skill.phase_skill.phase_skill_marking }}
									</p>
									<template v-if="!rating.rating_is_validated">
										<template v-if="!editMark(skill.rating_skill_id)">
											<button
													class="rounded-full bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
													type="button"
													@click="edits.find(s => s.id === skill.rating_skill_id).edit = true">
												<PencilSquareIcon aria-hidden="true" class="h-5 w-5"/>
											</button>
										</template>
										<template v-else>
											<button
													class="rounded-full bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
													type="button"
													@click="updateMark(skill.rating_skill_id,skill.phase_skill.phase_skill_marking)">
												<CheckIcon aria-hidden="true" class="h-5 w-5"/>
											</button>
										</template>
									</template>
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
								<div v-if="goal.goal_mark > 0" class="mt-1 flex items-center gap-x-2 text-sm leading-5 text-gray-500">
									<p class="whitespace-break-spaces">Note attribué le {{ capitalized(moment(goal.updated_at).format('DD MMMM YYYY à HH:mm')) }}</p>
								</div>
							</div>
							<div class="flex flex-none items-center gap-x-4">
								<div class="flex items-center justify-center space-x-4">
									<template v-if="!editMark('goal_' + goal.goal_id)">
										{{ goal.goal_mark }}
									</template>
									<template v-else>
										<input :ref="el => {inputs['goal_' + goal.goal_id] = el}" :value="goal.goal_mark"
										       class=" w-12 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-700 sm:text-sm sm:leading-6"
										       type="text"/>
									</template>
									<p class="ml-0.5 font-bold">
										/ {{ goal.goal_marking }}
									</p>
									<template v-if="!rating.rating_is_validated">
										<template v-if="!editMark('goal_' + goal.goal_id)">
											<button
													class="rounded-full bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
													type="button"
													@click="edits.find(s => s.id === ('goal_' + goal.goal_id)).edit = true">
												<PencilSquareIcon aria-hidden="true" class="h-5 w-5"/>
											</button>
										</template>
										<template v-else>
											<button
													class="rounded-full bg-cyan-600  p-2 text-white shadow-sm hover:bg-cyan-700     focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
													type="button"
													@click="updateGoal(goal.goal_id,goal.goal_marking)">
												<CheckIcon aria-hidden="true" class="h-5 w-5"/>
											</button>
										</template>
									</template>
								</div>
							</div>
						</li>
					</ul>
					<EmptyState v-else :link="route('agent-goals.create',{agent: agent.user_id})"
					            action="Nouvel Objectif" message="Les objectifs que vous aurez crée pour lui s'afficherons automatiquement ici."
					            title="Vous n'avez pas donner d'objectif à cette agent."/>
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
						<div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
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
													class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-cyan-700 sm:text-sm sm:leading-6"
													placeholder="Trouver votre N + 1"
													@change="searchAgent.keyword = query = $event.target.value; "/>
											<ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
												<ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
											</ComboboxButton>
											<ComboboxOptions v-if="filteredN1.length > 0"
											                 class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
												<ComboboxOption v-for="n1 in filteredN1" :key="n1.user_id" v-slot="{ active, selected }" :value="n1.user_id"
												                as="template">
													<li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-cyan-600  text-white' : 'text-gray-900']">
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
									<input id="remember-n1" v-model="commentForm.remember" class="h-4 w-4 rounded border-gray-300 text-cyan-600 focus:ring-cyan-700"
									       name="remember-n1"
									       type="checkbox"/>
									<label class="ml-3 block text-sm leading-6 text-gray-900" for="remember-n1">Sauvegarder en tant que mon N + 1</label>
								</div>
							</div>
						</div>
						<div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
							<FormIndications/>
							<div>
								<SubmitButton :disabled="rating.rating_is_validated" :processing="commentForm.processing" class=" mt-3 sm:ml-3 sm:mt-0 sm:w-auto"
								              type="submit">
									Enregistrer
								</SubmitButton>
								<button
										:class="rating.rating_is_validated ? 'bg-gray-600' : 'bg-cyan-600  focus-visible:outline-cyan-600 hover:bg-cyan-700    '"
										:disabled="rating.rating_is_validated"
										class="inline-flex gap-x-1.5 disabled:opacity-70 rounded-md  px-3 py-2 text-sm font-semibold text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2  mt-3 sm:ml-3 sm:mt-0 sm:w-auto"
										@click.prevent="open = true">Valider
									<CheckIcon class="text-white -mr-0.5 h-5 w-5"/>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<ValidationWarning :opened="open" :validation="validation" @close-modal="open = false"/>
	</AuthenticatedLayout>
</template>
