<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {CheckIcon, ChevronUpDownIcon, LockClosedIcon} from "@heroicons/vue/20/solid/index.js";
import {capitalized, isEmpty, moment} from "@/helpers/helper.js";
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxLabel,
    ComboboxOption,
    ComboboxOptions, Listbox,
    ListboxButton, ListboxOption, ListboxOptions
} from "@headlessui/vue";
import {computed, reactive, ref, watch} from "vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";

const props = defineProps({
    user: {
        type: Object,
    },
    n1s: {
        type: Array
    },
    roles: {

    }
});

const pages = [
    { name: 'Profil', href: '#', current: true },
]

const setData = () => useForm(!isEmpty(props.user) ? {
    user_first_name: props.user.user_first_name || '',
    user_last_name: props.user.user_last_name || '',
    email: props.user.email || '',
    org_name: props.user.org ? props.user.org.org_name : '',
    user_title: props.user.user_title || '',
    user_matricule: props.user.user_matricule || '',
    group_name: props.user.group ? props.user.group.group_name : '',
    user_responsibility_center: props.user.user_responsibility_center || '',
    user_gf: props.user.user_gf || '',
    user_nr: props.user.user_nr || '',
    user_gf_prom_date: props.user.user_gf_prom_date || '',
    user_nr_prom_date: props.user.user_nr_prom_date || '',
} : {})

const data = setData();

const form = useForm({
    n1_id: props.user.n1 ? props.user.n1.user_id : null,
    role_id: props.user.role_id
})

const n1s =  props.n1s;

const query = ref('')

const search = reactive({
    keyword: '',
    fields: ['user_first_name','user_last_name','user_matricule'],
});

const submitForm = () => {
    form.put(route('users.update',{user: props.user.user_id}));
}

const getFromDb =  () => {
    return axios.post(route('users.search'), search);
}

const filteredN1 = ref(n1s)

watch(() => query.value, function (next) {
    let filtered = next === ''
        ? n1s
        : n1s.filter((n1) => {
            return n1.user_matricule.toLowerCase().includes(query.value.toLowerCase()) || n1.user_first_name.toLowerCase().includes(query.value.toLowerCase()) || n1.user_last_name.toLowerCase().includes(query.value.toLowerCase())
        })
    if (filtered.length > 0) filteredN1.value = filtered;
    else {
        if(next.length >= 3)
            getFromDb().then(res => filteredN1.value = res.data);
    }
})



</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profil"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Profil de {{user.user_first_name + ' ' + user.user_last_name}}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Informations personnelles et administratives de l'agent.
                    </p>
                </div>
            </div>
            <div class="mt-8 shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg bg-white">
                <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Informations Personnelles</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Changer les informations personnelles de cette agents</p>
                    </div>

                    <form class="md:col-span-2">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">
                            <div class="col-span-full flex items-center gap-x-8">
                                <img alt="" class="h-24 w-24 flex-none rounded-lg bg-gray-800 object-cover" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Prénom</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.user_first_name" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Nom</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.user_last_name" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.email" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-8 flex">
                            <button :disabled="true" type="submit" class="inline-flex gap-x-1.5 disabled:opacity-70 rounded-md bg-cyan-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                Enregistrer
                                <CheckIcon class="text-white -mr-0.5 h-5 w-5" />
                                <!--                            <SubmitButton></SubmitButton>-->
                            </button>
                        </div>
                    </form>
                </div>

                <div class="grid max-w-7xl grid-cols-1 gap-x-8 gap-y-10 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8 border-t-2">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Informations Administratives</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-400">Modifier les informations administrative.</p>
                    </div>

                    <form class="md:col-span-2" @submit.prevent="submitForm">
                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:max-w-xl sm:grid-cols-6">

                            <div class="col-span-full">
                                <label for="confirm-password" class="block text-sm font-medium leading-6 text-gray-900">Organisation</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.org_name" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="confirm-password" class="block text-sm font-medium leading-6 text-gray-900">Poste</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.user_title" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="confirm-password" class="block text-sm font-medium leading-6 text-gray-900">College</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.group_name" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Matricule</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.user_matricule" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Centre de Responsabilité</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.user_responsibility_center" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">GF</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.user_gf" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">NR</label>
                                <div class="relative shadow-sm rounded-md mt-2">
                                    <TextInput v-model="data.user_nr" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">Date Promotion GF</label>
                                <div class="relative shadow-sm rounded-md mt-2 mt-2">
                                    <input class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset  sm:text-sm sm:leading-6" :value="capitalized(moment(data.user_gf_prom_date).format('DD MMMM YYYY'))" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">Date Promotion NR</label>
                                <div class="relative shadow-sm rounded-md mt-2 mt-2">
                                    <input class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset  sm:text-sm sm:leading-6" :value="capitalized(moment(data.user_nr_prom_date).format('DD MMMM YYYY'))" :disabled="true"/>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <LockClosedIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-4">
                                <InputLabel>Année d'évaluation</InputLabel>
                                <div class="mt-2">
                                    <Listbox as="div" v-model="form.role_id">
                                        <div class="relative mt-2">
                                            <ListboxButton class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6">
                                                <span class="block truncate">{{ roles.filter((type) => type.role_id === form.role_id)[0].role_name }}</span>
                                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                            </span>
                                            </ListboxButton>
                                            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <ListboxOptions class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                    <ListboxOption as="template" v-for="type in roles" :key="type.role_id" :value="type.role_id" v-slot="{ active, selected }">
                                                        <li :class="[active ? 'bg-cyan-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.role_name }}</span>
                                                            <span v-if="selected" :class="[active ? 'text-white' : 'text-cyan-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon class="h-5 w-5" aria-hidden="true" />
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
                                <Combobox as="div" v-model="form.n1_id">
                                    <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">Supérieure Hiérarchique (N + 1)</ComboboxLabel>
                                    <div class="relative mt-2">
                                        <ComboboxInput
                                            :display-value="(id) => { let selected = user.n1 ? user.n1 : filteredN1.filter(n1 => n1.user_id === id)[0];
                                                return selected ? selected.user_matricule + ' ' + selected.user_first_name + ' ' + selected.user_last_name : 'Non défini'}"
                                            class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6" @change="search.keyword = query = $event.target.value; "  />
                                        <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                                            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                        </ComboboxButton>
                                        <ComboboxOptions v-if="filteredN1.length > 0" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                            <ComboboxOption v-for="n1 in filteredN1" :key="n1.user_id" :value="n1.user_id" as="template" v-slot="{ active, selected }">
                                                <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-cyan-600 text-white' : 'text-gray-900']">
                                                    <div class="flex">
                                                        <span :class="['truncate', selected && 'font-semibold']">
                                                            {{ n1?.user_matricule + ' ' + n1?.user_first_name + ' ' + n1?.user_last_name }}
                                                        </span>
                                                    </div>
                                                    <span v-if="selected" :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-cyan-600']">
                                                    <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                                </span>
                                                </li>
                                            </ComboboxOption>
                                        </ComboboxOptions>
                                    </div>
                                </Combobox>
                            </div>
                        </div>

                        <div class="mt-8 flex">
                            <SubmitButton> Enregistrer </SubmitButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
