<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/Forms/InputLabel.vue';
import TextInput from '@/Components/Forms/TextInput.vue';
import SubmitButton from '@/Components/Forms/SubmitButton.vue';
import {isEmpty} from '@/helpers/helper.js';
import InputError from "@/Components/Forms/InputError.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import NumberInput from "@/Components/Forms/NumberInput.vue";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import {CheckIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid/index.js";
import {computed} from "vue";

const props = defineProps({
    phase: {type: Object, default: {}},
    types: {type: Array}
});

let form;
const title = computed(() => {
    return isEmpty(props.phase) ? 'Nouvelle Phase D\'évaluation' : 'Modifier Phase d\'évaluation';
});
const pages = [
    {name: 'Phase d\'évaluation', href: route('phases.index'), current: false},
    {name: isEmpty(props.phase) ? 'Nouveau' : 'Modifier', href: '#', current: true},
]
const setForm = () => {
    form = useForm(
        isEmpty(props.phase)
            ? {
                phase_name: '',
                phase_year: new Date().getFullYear(),
                period_type_id: props.types[0].period_type_id,
                phase_min_goals: 4,
            }
            : {
                phase_name: props.phase.phase_name || '',
                phase_year: parseInt(props.phase.phase_year) || new Date().getFullYear(),
                period_type_id: props.phase.period_type_id || props.types[0].period_type_id,
                phase_min_goals: props.phase.phase_min_goals || 4,
            }
    );
}
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

setForm();

</script>
<template>
    <AuthenticatedLayout>
        <Head title="Nouvelle Phase d'évaluation"/>
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
                                        id="name"
                                        v-model="form.phase_name"
                                        :invalid="form.errors.phase_name !== undefined"
                                        autofocus
                                        placeholder="Nom"/>
                                </div>
                                <InputError :message="form.errors.phase_name"/>
                            </div>
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Année</InputLabel>
                                <div class="mt-2">
                                    <NumberInput v-model="form.phase_year"/>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.phase_year"/>
                                </div>
                            </div>
                            <div class="sm:col-span-4">
                                <InputLabel>Fréquence des évaluations</InputLabel>
                                <div class="mt-2">
                                    <Listbox v-model="form.period_type_id" as="div">
                                        <div class="relative mt-2">
                                            <ListboxButton
                                                class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-s-pink-800 sm:text-sm sm:leading-6">
                                                <span class="block truncate">{{ types.filter((type) => type.period_type_id === form.period_type_id)[0].period_type_name }}
                                                </span>
                                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                    <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                                </span>
                                            </ListboxButton>
                                            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <ListboxOptions
                                                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                    <ListboxOption v-for="type in types" :key="type.period_type_id" v-slot="{ active, selected }"
                                                                   :value="type.period_type_id"
                                                                   as="template">
                                                        <li :class="[active ? 'bg-s-pink-800  text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.period_type_name
                                                                }}</span>
                                                            <span v-if="selected"
                                                                  :class="[active ? 'text-white' : 'text-s-pink-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
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
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Minimum d'objectif par évaluation</InputLabel>
                                <div class="mt-2">
                                    <NumberInput v-model="form.phase_min_goals"/>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.phase_min_goals"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications/>
                        <SubmitButton :processing="form.processing"> Enregistrer</SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
