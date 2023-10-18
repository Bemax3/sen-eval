<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/Forms/InputLabel.vue';
import TextInput from '@/Components/Forms/TextInput.vue';
import SubmitButton from '@/Components/Forms/SubmitButton.vue';
import {computed, watch} from 'vue';
import {isEmpty} from '@/helpers/helper.js';
import InputError from "@/Components/Forms/InputError.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import RangePicker from "@/Components/Forms/RangePicker.vue";

const props = defineProps({
	phase: {
		type: Object,
		default: {},
	},
});

let form;
const setForm = () => {
		form = useForm(
		isEmpty(props.phase)
			? {
				phase_name: '',
				phase1: [new Date(),new Date()],
				phase2: [new Date(),new Date()],
			}
			: {
				phase_name: props.phase.phase_name || '',
				phase1: [new Date(props.phase.phase_first_eval_start),new Date(props.phase.phase_first_eval_end)] || [new Date(),new Date()],
				phase2: [new Date(props.phase.phase_second_eval_start),new Date(props.phase.phase_second_eval_end)] || [new Date(),new Date()],
			}
		);
}

setForm();

const submit = () => {
	if (isEmpty(props.phase))
		form.post(route('phases.store'), {
			onSuccess: () => setForm(),
		});
	else
		form.put(route('phases.update', {phase: props.phase.phase_id}), {
			onSuccess: () => setForm(),
		});
};

const title = computed(() => {
	return isEmpty(props.phase) ? 'Nouvelle Phase D\'évaluation' : 'Modifier Phase d\'évaluation';
});

const pages = [
	{ name: 'Phases d\'évaluation', href: route('phases.index'), current: false },
	{ name: 'Nouveau', href: '#', current: true },
]
</script>
<template>
	<AuthenticatedLayout>
		<div class="px-4 sm:px-6 lg:px-8">
			<Breadcrumbs :pages="pages"/>
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ title }}</h1>
					<p class="mt-2 text-sm text-gray-700">Ajouter ou modifier une phase d'évaluation.</p>
				</div>
			</div>
			<div class="mt-8 flow-root">
				<form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
					<div class="px-4 py-6 sm:p-8">
						<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
							<div class="sm:col-span-4">
								<InputLabel for="name" required>Nom</InputLabel>
								<div class="mt-2">
									<TextInput
											v-model="form.phase_name"
											:invalid="form.errors.phase_name !== undefined"
											id="name"
											placeholder="Nom"
											autofocus />
								</div>
								<InputError :message="form.errors.phase_name"/>
							</div>

							<div class="col-span-full">
								<InputLabel for="start_date" required>Période d'évaluation du premier semestre</InputLabel>
								<div class="mt-2">
									<RangePicker v-model="form.phase1" :invalid="form.errors.phase1 !== undefined || form.errors.phase_first_eval_end !== undefined" placeholder="01-06-20** au 30-06-20**"/>
								</div>
								<div class="flex flex-col space-y-2">
									<InputError :message="form.errors.phase1" />
									<InputError :message="form.errors.phase_first_eval_start" />
									<InputError :message="form.errors.phase_first_eval_end" />
								</div>
							</div>

							<div class="col-span-full">
								<InputLabel for="end_date" required>Période d'évaluation du second semestre</InputLabel>
								<div class="mt-2">
									<RangePicker v-model="form.phase2" :invalid="form.errors.phase2 !== undefined || form.errors.phase_second_eval_end !== undefined" placeholder="01-12-20** au 31-12-20**"/>
								</div>
								<div class="flex flex-col space-y-2">
									<InputError :message="form.errors.phase2"/>
									<InputError :message="form.errors.phase_second_eval_start" />
									<InputError :message="form.errors.phase_second_eval_end" />
								</div>
							</div>
						</div>
					</div>
					<div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
						<FormIndications />
						<SubmitButton :disabled="form.processing"> Enregistrer </SubmitButton>
					</div>
				</form>
			</div>
		</div>
	</AuthenticatedLayout>
</template>
