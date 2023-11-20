<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, usePage} from "@inertiajs/vue3";
import {CheckIcon, PencilSquareIcon} from "@heroicons/vue/20/solid/index.js";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import {getPagination, hasData} from "@/helpers/helper.js";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import Datatable from "@/Components/Common/Tables/Datatable.vue";
import ToggleOnDatatable from "@/Components/Forms/ToggleOnDatatable.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";
import {computed, onBeforeUpdate, reactive, ref, watch} from "vue";
import axios from "axios";
import EmptyState from "@/Components/Common/EmptyState.vue";
import Separator from "@/Components/LayoutParts/Separator.vue";
import SectionTitle from "@/Components/LayoutParts/SectionTitle.vue";

const props = defineProps({
    phase: {type: Object},
    skills: {type: Object},
})

const pages = [
    {name: 'Phases d\'évaluation', href: route('phases.index'), current: false},
    {name: 'Compétences', href: '#', current: true},
]
const pagination = computed(() => getPagination(props.skills));
const search = reactive({keyword: '', fields: ['skill_name'], phase_id: props.phase.phase_id});
const displayedData = ref(props.skills.data);
const edits = ref([]);
const inputs = ref([]);

const setupEdits = () => displayedData.value.forEach(item => edits.value.push({id: item.skill_id, edit: false}))
const editMark = (id) => {
    return edits.value.filter(s => s.id === id)[0].edit
}
const updateMark = (id) => {
    const input = inputs.value[id];
    edits.value.find(s => s.id === id).edit = false;
    router.put(
        route('phaseSkills.update', {phaseSkill: props.phase.phase_id}),
        {skill_id: id, phase_skill_marking: input.value},
        {
            onError: err => {
                usePage().props.flash.notify = {type: 'error', message: err.phase_skill_marking}
            },
            onSuccess: () => search.keyword = ''
        }
    );
}

setupEdits();

watch(() => search.keyword, function (next) {
    if (next === '') {
        displayedData.value = props.skills.data;
    } else {
        axios.post(route('phaseSkills.search'), search).then(res => {
            displayedData.value = res.data;
            setupEdits()
        }).catch(err => console.log(err));
    }
});

watch(() => props.skills, function (next) {
    displayedData.value = next.data;
    if (!displayedData.value.length > 0) {
        if (next.prev_page_url) router.get(next.prev_page_url)
        else router.get(next.first_page_url);
    }
});

onBeforeUpdate(() => inputs.value = [])

</script>

<template>
    <AuthenticatedLayout>
        <Head title="Paramètre de Phase"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">Paramètres {{ phase.phase_name }}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        Details et paramètres de l'évaluation.
                    </p>
                </div>
                <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link
                        :href="route('phaseSkills.show',{phaseSkill: phase.phase_id})"
                        as="button"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Compétences
                    </Link>
                    <Link
                        :href="route('periods.show',{period: phase.phase_id})"
                        as="button"
                        class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                        Périodes d'évaluation
                    </Link>
                </div>
            </div>
            <Separator title="Compétences"/>
            <SectionTitle
                desc="La liste des compétences que les évaluateurs pourront noter lors de cette évaluation. Vous pouvez changer le barème de chaque compétence pour cette évaluation sans affecter les autres."
                title="Compétences"/>
            <Datatable v-if="hasData(props.skills.data)" v-model="search.keyword" :pagination="pagination">
                <table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <TableHeading :first="true">Nom</TableHeading>
                        <!--                        <TableHeading>Description</TableHeading>-->
                        <TableHeading>Status pour cette phase</TableHeading>
                        <TableHeading>Barème pour cette phase</TableHeading>
                        <TableHeading>College</TableHeading>
                        <TableHeading>Type</TableHeading>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="skill in displayedData" :key="skill.skill_id">
                        <TableData :first="true" class="whitespace-pre-line">{{ skill.skill_name }}</TableData>
                        <!--                        <TableData class="whitespace-pre-line">{{ skill.skill_desc }}</TableData>-->
                        <TableData>
                            <div v-if="!skill.group" class="flex items-center justify-center space-x-2">

                                <ToggleOnDatatable
                                    :data="{phase_skill_is_active: skill.pivot.phase_skill_is_active,skill_id: skill.skill_id}"
                                    :link="route('phaseSkills.update',{phaseSkill: phase.phase_id})"
                                    :value="skill.pivot.phase_skill_is_active"
                                    obj="phase_skill_is_active"
                                    @toggled="search.keyword = ''"
                                />
                                <span
                                    :class="skill.pivot.phase_skill_is_active ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'"
                                    class="rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                {{ skill.pivot.phase_skill_is_active ? 'Activé' : 'Désactivé' }}
                        </span>
                            </div>
                        </TableData>
                        <TableData>
                            <div class="flex items-center justify-center space-x-4">
                                <template v-if="!editMark(skill.skill_id)">
                                    {{ skill.pivot.phase_skill_marking }}
                                </template>
                                <template v-else>
                                    <input :ref="el => {inputs[skill.skill_id] = el}" :value="skill.pivot.phase_skill_marking"
                                           class=" w-10 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-cyan-600 sm:text-sm sm:leading-6"
                                           type="text"/>
                                </template>
                                <p class="ml-0.5">points</p>
                                <template v-if="!editMark(skill.skill_id)">
                                    <button
                                        class="rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                                        type="button"
                                        @click="edits.find(s => s.id === skill.skill_id).edit = true">
                                        <PencilSquareIcon aria-hidden="true" class="h-5 w-5"/>
                                    </button>
                                </template>
                                <template v-else>
                                    <button
                                        class="rounded-full bg-cyan-600 p-2 text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
                                        type="button"
                                        @click="updateMark(skill.skill_id)">
                                        <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                    </button>
                                </template>
                            </div>
                        </TableData>
                        <TableData>{{ skill.group ? skill.group.group_name : 'Commun' }}</TableData>
                        <TableData>{{ skill.type.skill_type_name }}</TableData>
                    </tr>
                    </tbody>
                </table>
                <div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé.</div>
            </Datatable>
            <EmptyState
                v-else
                :link="route('phases.create')"
                action="Nouveau"
                message="Ajouter des compétences a évaluer lors de cette phase."
                title="Pas de Compétence affecté à cette phase."/>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
