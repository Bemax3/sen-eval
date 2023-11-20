<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/Forms/InputLabel.vue';
import TextInput from '@/Components/Forms/TextInput.vue';
import SubmitButton from '@/Components/Forms/SubmitButton.vue';
import {computed, ref} from 'vue';
import {isEmpty} from '@/helpers/helper.js';
import InputError from "@/Components/Forms/InputError.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import {Combobox, ComboboxButton, ComboboxInput, ComboboxLabel, ComboboxOption, ComboboxOptions} from "@headlessui/vue";
import {CheckIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    org: {
        type: Object,
        default: {},
    },
    parents: {type: Array}
});

const title = computed(() => {
    return isEmpty(props.org) ? 'Nouvelle Organisation' : 'Modifier Organisation';
});
const pages = [
    {name: 'Organisation', href: route('orgs.index'), current: false},
    {name: 'Nouveau', href: '#', current: true},
]
const orgs = props.parents;
const query = ref('')
const filteredOrg = computed(() =>
    query.value === ''
        ? orgs
        : orgs.filter((org) => {
            return org.org_name.toLowerCase().includes(query.value.toLowerCase())
        })
)

let form;
const setForm = () => {
    form = useForm(
        isEmpty(props.org)
            ? {
                org_name: '',
                org_type: '',
                parent_id: props.parents[0].org_id
            }
            : {
                org_name: props.org.org_name,
                org_type: props.org.org_type,
                parent_id: props.org.parent_id
            }
    );
}
const submit = () => {
    if (isEmpty(props.org))
        form.post(route('orgs.store'), {
            onSuccess: () => setForm(),
        });
    else
        form.put(route('orgs.update', {org: props.org.org_id}), {
            onSuccess: () => setForm(),
        });
};

setForm();
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Enregistrer Organisation"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ title }}</h1>
                    <p class="mt-2 text-sm text-gray-700">Ajouter ou modifier une organisation.</p>
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
                                        id="name"
                                        v-model="form.org_name"
                                        :invalid="form.errors.org_name !== undefined"
                                        autofocus
                                        placeholder="Nom"/>
                                </div>
                                <InputError :message="form.errors.org_name"/>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Type</InputLabel>
                                <div class="mt-2">
                                    <TextInput v-model="form.org_type" :disabled="true"/>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.org_type"/>
                                </div>
                            </div>
                            <div class="sm:col-span-4">
                                <Combobox v-model="form.parent_id" as="div">
                                    <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">Organisation Parent</ComboboxLabel>
                                    <div class="relative mt-2">
                                        <ComboboxInput
                                            :display-value="(id) => orgs.filter(x => x.org_id === id)[0]?.org_name"
                                            class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6"
                                            @change="query = $event.target.value"/>
                                        <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                                            <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                        </ComboboxButton>
                                        <ComboboxOptions v-if="filteredOrg.length > 0"
                                                         class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                            <ComboboxOption v-for="org in filteredOrg" :key="org.org_id" v-slot="{ active, selected }" :value="org.org_id" as="template">
                                                <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-cyan-600 text-white' : 'text-gray-900']">
                                                    <div class="flex">
                                                        <span :class="['truncate', selected && 'font-semibold']">
                                                            {{ org.org_name }}
                                                        </span>
                                                        <span :class="['ml-2 truncate text-gray-500', active ? 'text-cyan-200' : 'text-gray-500']">
                                                            {{ org.org_responsibility_center }}
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
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications/>
                        <SubmitButton :disabled="form.processing"> Enregistrer</SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
