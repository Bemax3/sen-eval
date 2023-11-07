<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, useForm, usePage} from "@inertiajs/vue3";
import Title from "@/Components/Rating/Title.vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import Tabs from "@/Components/Rating/Tabs.vue";
import {computed, ref, watch} from "vue";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import Separator from "@/Components/LayoutParts/Separator.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {CheckIcon, ChevronUpDownIcon, TrashIcon} from "@heroicons/vue/20/solid/index.js";
import {getPagination, hasData} from "@/helpers/helper.js";
import InputError from "@/Components/Forms/InputError.vue";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import EmptyState from "@/Components/Common/EmptyState.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import Switch from "@/Components/Forms/Switch.vue";


const props = defineProps({
    agent: {},
    rating: {},
    types: {type: Array},
    promotions: {}
})

const pagination = computed(() => getPagination(props.promotions));

const displayedData = ref(props.promotions.data);

const isEvaluated = computed(() => {
    return usePage().props.auth.user.user_id === props.rating.evaluated_id
})

const isValidator = computed(() => {
    return usePage().props.auth.user.user_id === props.rating.validator_id
})

const pages = isEvaluated.value ? [
    {name: 'Mes Evaluations', href: route('ratings.index', {agent_rating: props.rating.rating_id}), current: false},
    {name: 'Evaluation', href: '#', current: true},
] : [
    {name: 'Mes Agents', href: route('agents.index'), current: false},
    {name: 'Evaluations', href: route('agent-ratings.index', {agent: props.agent.user_id}), current: false},
    {name: 'Evaluation', href: '#', current: true},
]

let form = ref(useForm({
    evaluated_is_eligible: 0,
    promotion_type_id: hasData(props.types) ? props.types[0].promotion_type_id : null
}));

const search = '';

const submit = () => form.value.post(route('rating-promotions.store', {rating: props.rating.rating_id}))


watch(() => props.promotions,
    function (next) {
        displayedData.value = next.data;
        if (!displayedData.value.length > 0) {
            if (next.prev_page_url) router.get(next.prev_page_url)
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
            <Title :agent="agent" :rating="rating"/>
            <Tabs :agent_id="props.agent.user_id" :evaluated="isEvaluated" :rating_id="props.rating.rating_id" :validator="isValidator"/>
            <form v-if="!isEvaluated && !isValidator" class="mt-8 bg-white px-4 py-5 sm:p-6 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2"
                  @submit.prevent="submit">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Demander une promotion ou un avancement</h3>
                <div class="mt-2 max-w-xl text-sm text-gray-500">
                    <p>Demander une promotion ou un avancement et ajouter la á la liste des demandes pour cette évaluation. </p>
                </div>
                <div class="px-4 py-6 sm:p-8">
                    <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <div class="mt-2">
                                <Switch v-model="form.evaluated_is_eligible" desc="L'évalué est-il éligible á cette avancement ou promotion ?"
                                        label="Non Éligible / Éligible"/>
                            </div>
                        </div>
                        <div class="col-span-full relative">
                            <InputLabel for="start_date" required>Nature</InputLabel>
                            <Listbox v-model="form.promotion_type_id">
                                <div class="relative">
                                    <ListboxButton
                                        :class="form.errors.phase_id ? 'ring-red-300':'ring-gray-300'"
                                        class="w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset focus:outline-none focus:ring-2 focus:ring-cyan-600 sm:text-sm sm:leading-6">
                                        <span v-if="hasData(types)"
                                              class="block truncate">{{ types.filter((type) => type.promotion_type_id === form.promotion_type_id)[0].promotion_type_name
                                            }}</span>
                                        <span v-else class="block truncate">Aucune promotion disponible pour l'instant.</span>
                                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                            <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                        </span>
                                    </ListboxButton>
                                    <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                        <ListboxOptions v-if="hasData(types)"
                                                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                            <ListboxOption v-for="type in types" :key="type.promotion_type_id" v-slot="{ active, selected }"
                                                           :value="type.promotion_type_id"
                                                           as="template">
                                                <li :class="[active ? 'bg-cyan-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                    <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.promotion_type_name }}</span>
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
                        <InputError :message="form.errors.promotion_type_id"/>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                    <FormIndications/>
                    <SubmitButton class="sm:ml-3 sm:mt-0 sm:w-auto" type="submit">Enregistrer</SubmitButton>
                </div>
            </form>
            <Separator title="Promotions / Avancements Demandées"/>
            <Datatable v-if="hasData(promotions.data)" v-model="search" :pagination="pagination" :search="false">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Nature</TableHeading>
                        <TableHeading>Demandée par</TableHeading>
                        <TableHeading>Éligibilité</TableHeading>
                        <TableHeading></TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="promotion in displayedData" :key="promotion.rating_promotion_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ promotion.type.promotion_type_name }}</TableData>
                        <TableData>{{ rating.evaluator.user_display_name }}</TableData>
                        <TableData>
                            <span :class="promotion.evaluated_is_eligible ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'"
                                  class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ promotion.evaluated_is_eligible ? 'Éligible' : 'Non Éligible' }}
                            </span>
                        </TableData>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <div class="flex items-center justify-center space-x-2">
                                <button v-if="!isEvaluated"
                                        class="rounded-lg bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                        type="button"
                                        @click="router.delete(route('rating-promotions.destroy',{rating: rating.rating_id,rating_promotion: promotion.rating_promotion_id}))">
                                    <TrashIcon aria-hidden="true" class="h-5 w-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState v-else :message="isEvaluated ? '' : 'Demander une promotion en utilisant le formulaire en haut.'"
                        title="Aucune promotions ou avancement demandée pour l'instant."/>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
