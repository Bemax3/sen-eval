<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {computed} from "vue";
import {isEmpty} from "@/helpers/helper.js";
import InputError from "@/Components/Forms/InputError.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import Switch from "@/Components/Forms/Switch.vue";

const props = defineProps({
    sanction: {
        type: Object,
        default: {}
    }
})
let form;

const setForm = () => {
    form = useForm((isEmpty(props.sanction)) ?
        {
            sanction_type_name: '',
            sanction_type_desc: '',
            sanction_type_is_active: 1
        } :
        {
            sanction_type_name: props.sanction.sanction_type_name || '',
            sanction_type_desc: props.sanction.sanction_type_desc || '',
            sanction_type_is_active: props.sanction.sanction_type_is_active
        }
    );
}

setForm();
const submit = () => {
    if (isEmpty(props.sanction))
        form.post(route('sanctionTypes.store'), {
            onSuccess: () => setForm()
        });
    else
        form.put(route('sanctionTypes.update', {sanctionType: props.sanction.sanction_type_id}), {
            onSuccess: () => setForm()
        });
}

const title = computed(() => {
    return isEmpty(props.sanction) ? 'Nouveau Type de Sanction' : 'Modifier Type de Sanction';
})

const pages = [
    {name: 'Types de Sanction', href: route('sanctionTypes.index'), current: false},
    {name: isEmpty(props.sanction) ? 'Nouveau' : 'Modifier', href: '#', current: true},
]
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Nouveau type de Sanction"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ title }}</h1>
                    <p class="mt-2 text-sm text-gray-700">Ajouter ou modifier un type de sanction applicable lors de l'évaluation.</p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <InputLabel for="name" required>Nom de la sanction</InputLabel>
                                <div class="mt-2">
                                    <TextInput
                                        id="name"
                                        v-model="form.sanction_type_name"
                                        :invalid="form.errors.sanction_type_name !== undefined"
                                        autofocus placeholder="Nom"/>
                                </div>
                                <InputError :message="form.errors.sanction_type_name"/>
                            </div>

                            <div class="col-span-full">
                                <InputLabel for="description">Description</InputLabel>
                                <div class="mt-2">
                                    <TextArea
                                        id="description"
                                        v-model="form.sanction_type_desc"
                                        :invalid="form.errors.sanction_type_desc !== undefined"
                                        placeholder="Description"
                                    />
                                </div>
                            </div>
                            <div class="col-span-full">
                                <div class="mt-2">
                                    <Switch v-model="form.sanction_type_is_active"
                                            desc="Sera t-il possible de proposer ou demander ce type de formation lors des évaluations"
                                            label="Actif"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications/>
                        <SubmitButton :disabled="form.processing">
                            Enregistrer
                        </SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
