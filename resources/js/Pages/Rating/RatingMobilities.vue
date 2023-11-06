<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import Title from "@/Components/Rating/Title.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Tabs from "@/Components/Rating/Tabs.vue";
import {computed, reactive, ref, watch} from "vue";
import {
    Listbox, ListboxButton,
    ListboxOption, ListboxOptions
} from "@headlessui/vue";
import Separator from "@/Components/LayoutParts/Separator.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {CheckIcon, ChevronUpDownIcon, PencilSquareIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import {getPagination, hasData} from "@/helpers/helper.js";
import InputError from "@/Components/Forms/InputError.vue";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";


const props = defineProps({
    agent:{},
    rating: {},
    types:{type: Array},
    mobilities: {}
})

const pagination = computed(() => getPagination(props.mobilities));

const displayedData = ref(props.mobilities.data);

const isEvaluated = computed(() => {
    return usePage().props.auth.user.user_id === props.rating.evaluated_id
})

const pages = isEvaluated.value ? [
    { name: 'Mes Evaluations', href: route('ratings.index',{agent_rating: props.rating.rating_id}), current: false },
    { name: 'Evaluation', href: '#', current: true },
] : [
    { name: 'Mes Agents', href: route('agents.index'), current: false },
    { name: 'Evaluations', href: route('agent-ratings.index',{agent: props.agent.user_id}), current: false },
    { name: 'Evaluation', href: '#', current: true },
]

let form = ref(useForm(isEvaluated.value ? {
    asked_by_evaluated: 1,
    rating_mobility_title: '',
    mobility_type_id: hasData(props.types) ? props.types[0].mobility_type_id : null
} : {
    asked_by_evaluator: 1,
    rating_mobility_title: '',
    mobility_type_id: hasData(props.types) ? props.types[0].mobility_type_id : null
}));

const search = reactive({
    keyword: '',
    fields: ['user_display_name','user_matricule'],
});

const input = ref(null);
const setupEdit = (id) => {
    const mobility = displayedData.value.filter(m => m.rating_mobility_id === id)[0];
    if(isEvaluated) form.value.asked_by_evaluated = mobility.asked_by_evaluated;
    else form.value.asked_by_evaluator = mobility.asked_by_evaluator;
    form.value.rating_mobility_id =  id;
    form.value.rating_mobility_title = mobility.rating_mobility_title;
    form.value.mobility_type_id = mobility.mobility_type_id;
    input.value.focus();
}

const submit = () => {
    if(form.value.rating_mobility_id) form.value.put(route('rating-mobilities.update',{rating: props.rating.rating_id,rating_mobility: form.value.rating_mobility_id}))
    else form.value.post(route('rating-mobilities.store',{rating: props.rating.rating_id}))
}

watch(()=> props.mobilities,
    function (next) {
        displayedData.value = next.data;
        if(!displayedData.value.length >0) {
            if(next.prev_page_url) router.get(next.prev_page_url)
            else router.get(next.first_page_url);
        }
    }
);



</script>

<template>
    <AuthenticatedLayout>
        <Head title="Profil"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <Title :agent="agent" :rating="rating" />
            <Tabs :rating_id="props.rating.rating_id" :agent_id="props.agent.user_id" :evaluated="isEvaluated"/>
                <form class="mt-8 bg-white px-4 py-5 sm:p-6 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Demander une mobilité</h3>
                    <div class="mt-2 max-w-xl text-sm text-gray-500">
                        <p>Demander une mobilité et ajouter la á la liste des demandes pour cette évaluation. </p>
                    </div>
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <InputLabel for="start_date" required>Poste</InputLabel>
                                <div class="mt-2">
                                    <TextInput ref="input" v-model="form.rating_mobility_title" :invalid="form.errors.rating_mobility_title !== undefined"/>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <InputError :message="form.errors.rating_mobility_title"/>
                                </div>
                            </div>
                            <div class="col-span-full relative">
                                <InputLabel for="start_date" required>Nature</InputLabel>
                                <Listbox v-model="form.mobility_type_id">
                                    <div class="relative">
                                        <ListboxButton class="w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6" :class="form.errors.phase_id ? 'ring-red-300':'ring-gray-300'">
                                            <span v-if="hasData(types)" class="block truncate">{{ types.filter((type) => type.mobility_type_id === form.mobility_type_id)[0].mobility_type_name }}</span>
                                            <span v-else class="block truncate">Aucune Mobilité disponible pour l'instant.</span>
                                            <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                        </span>
                                        </ListboxButton>
                                        <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                            <ListboxOptions v-if="hasData(types)" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                <ListboxOption as="template" v-for="type in types" :key="type.mobility_type_id" :value="type.mobility_type_id" v-slot="{ active, selected }">
                                                    <li :class="[active ? 'bg-cyan-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                        <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.mobility_type_name }}</span>
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
                            <InputError :message="form.errors.mobility_type_id"/>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications />
                        <SubmitButton type="submit" class="sm:ml-3 sm:mt-0 sm:w-auto">Enregistrer</SubmitButton>
                    </div>
                </form>
            <Separator title="Mobilités Demandées" />
            <Datatable :pagination="pagination" v-if="hasData(mobilities.data)" v-model="search.keyword">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Nature</TableHeading>
                        <TableHeading>Demandée par </TableHeading>
                        <TableHeading>Poste demandé</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="mobility in displayedData" :key="mobility.rating_mobility_id">
                        <TableData class="whitespace-pre-line" :first="true">{{ mobility.type.mobility_type_name }}</TableData>
                        <TableData>
                            <template v-if="mobility.asked_by_evaluator" >
                                {{ rating.evaluator.user_display_name }}
                            </template>
                            <template v-else-if="mobility.asked_by_evaluated">
                                {{ rating.evaluated.user_display_name }}
                            </template>
                        </TableData>
                        <TableData>
                            {{mobility.rating_mobility_title}}
                        </TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center space-x-2">
                                <button v-if="(isEvaluated && mobility.asked_by_evaluated) || (!isEvaluated && mobility.asked_by_evaluator)" @click="setupEdit(mobility.rating_mobility_id)" type="button" class="rounded-lg bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                                    <PencilSquareIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                                <button v-if="(isEvaluated && mobility.asked_by_evaluated) || (!isEvaluated && mobility.asked_by_evaluator)" @click="router.delete(route('rating-mobilities.destroy',{rating: rating.rating_id,rating_mobility: mobility.rating_mobility_id}))" type="button" class="rounded-lg bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                                    <TrashIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé. </div>
            </Datatable>
            <EmptyState v-else title="Aucune mobilité demandée pour l'instant." message="Demander une mobilité en utilisant le formulaire en haut."/>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
