<script setup>
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import {Head, useForm} from '@inertiajs/vue3';
	import InputLabel from '@/Components/Forms/InputLabel.vue';
	import TextInput from '@/Components/Forms/TextInput.vue';
	import TextArea from '@/Components/Forms/TextArea.vue';
	import SubmitButton from '@/Components/Forms/SubmitButton.vue';
	import {computed, watch} from 'vue';
	import {isEmpty} from '@/helpers/helper.js';
    import InputError from "@/Components/Forms/InputError.vue";
	import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
	import FormIndications from "@/Components/Forms/FormIndications.vue";

	const props = defineProps({
		claim: {
			type: Object,
			default: {},
		},
	});

	let form;
	const setForm = () => {
		form = useForm(
	isEmpty(props.claim)
			? {
				claim_type_name: '',
				claim_type_desc: '',
			}
			: {
				claim_type_name: props.claim.claim_type_name || '',
				claim_type_desc: props.claim.claim_type_desc || '',
			}
		);
	}

	setForm();
	const submit = () => {
		if (isEmpty(props.claim))
			form.post(route('claimTypes.store'), {
				onSuccess: () => setForm(),
			});
		else
			form.put(route('claimTypes.update', {claimType: props.claim.claim_type_id}), {
				onSuccess: () => setForm(),
			});
	};

	const title = computed(() => {
		return isEmpty(props.claim) ? 'Nouveau Type de Réclamation' : 'Modifier Type de Réclamation';
	});

	const pages = [
		{ name: 'Types de Réclamation', href: route('claimTypes.index'), current: false },
		{ name: 'Nouveau', href: '#', current: true },
	]
</script>
<template>
	<AuthenticatedLayout>
        <Head title="Nouveau type de Réclamation"/>
		<div class="px-4 sm:px-6 lg:px-8">
			<Breadcrumbs :pages="pages"/>
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ title }}</h1>
	                <p class="mt-2 text-sm text-gray-700">Ajouter ou modifier un type de réclamation qu'il sera possible de faire lors de l'évaluation.</p>
				</div>
			</div>
			<div class="mt-8 flow-root">
			<form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
				<div class="px-4 py-6 sm:p-8">
					<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
						<div class="sm:col-span-4">
							<InputLabel for="name" required>Nom de la Réclamation</InputLabel>
							<div class="mt-2">
								<TextInput
									v-model="form.claim_type_name"
									:invalid="form.errors.claim_type_name !== undefined"
									id="name"
									placeholder="Nom"
									autofocus />
							</div>
                            <InputError :message="form.errors.claim_type_name"/>
						</div>

						<div class="col-span-full">
							<InputLabel for="description">Description</InputLabel>
							<div class="mt-2">
								<TextArea
									v-model="form.claim_type_desc"
									:invalid="form.errors.claim_type_desc !== undefined"
									id="description"
									placeholder="Description" />
							</div>
							<!--                            <p class="mt-3 text-sm leading-6 text-gray-600">Optionnel</p>-->
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
