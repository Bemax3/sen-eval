<script setup>
	import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
	import Datatable from '@/Components/Common/Tables/Datatable.vue';
	import TableHeading from '@/Components/Common/Tables/TableHeading.vue';
	import TableData from '@/Components/Common/Tables/TableData.vue';
	import {computed, reactive, ref, watch} from 'vue';
    import {Head, Link, router} from '@inertiajs/vue3';
	import DeleteModal from '@/Components/Common/DeleteModal.vue';
	import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
	import {ChevronDownIcon, PencilSquareIcon, TrashIcon, PlusIcon} from '@heroicons/vue/20/solid';
    import {getPagination, hasData} from '@/helpers/helper.js';
	import EmptyState from '@/Components/Common/EmptyState.vue';
	import axios from 'axios';
	import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
    import ToogleWithIcon from "@/Components/Forms/ToogleWithIcon.vue";
    import ToggleOnDatatable from "@/Components/Forms/ToggleOnDatatable.vue";

	const props = defineProps({
		claims: {
			type: Object,
		},
	});
	const pagination = computed(() => getPagination(props.claims));
	const openModal = ref(false);
    let idToDestroy = hasData(props.claims.data) ? props.claims.data[0].claim_type_id : null;
	const destroy = id => {
		idToDestroy = id;
		openModal.value = true;
	};

    const displayedData = ref(props.claims.data);

    const search = reactive({
        keyword: '',
        fields: ['claim_type_name'],
    });

    const toggleStatus = reactive(hasData(props.claims.data) ? {
        claim_type_id: props.claims.data[0].claim_type_id ,
        claim_type_is_active: props.claims.data[0].claim_type_is_active
    } : {})

    watch(() => search.keyword,
		function (next) {
			if (next === '') {
				displayedData.value = props.claims.data;
			} else {
				axios.post(route('claimTypes.search'), search).then(res => (displayedData.value = res.data));
			}
		}
	);
	watch(()=> props.claims,
	function (next) {
			displayedData.value = next.data;
			if(!displayedData.value.length >0) {
				if(next.prev_page_url) router.get(next.prev_page_url)
				else router.get(next.first_page_url);
			}
		}
	);

	const pages = [
		{ name: 'Types de Réclamation', href: '#', current: true },
	]
</script>

<template>
	<AuthenticatedLayout>
        <Head title="Types de Réclamation"/>
		<div class="px-4 sm:px-6 lg:px-8">
			<Breadcrumbs :pages="pages"/>
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-2xl font-semibold leading-6 text-gray-900">Types de Réclamation</h1>
					<p class="mt-2 text-sm text-gray-700">
						La liste des réclamations qu'il sera possible de faire lors de l'évaluation.
					</p>
				</div>
				<div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
					<Link
						:href="route('claimTypes.create')"
						class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
						as="button">
						Ajouter un Type
						<PlusIcon class="-mr-0.5 h-5 w-5" />
					</Link>
				</div>
			</div>
			<Datatable :pagination="pagination" v-if="hasData(claims.data)" v-model="search.keyword">
				<table v-if="displayedData.length > 0" class="min-w-full divide-y divide-gray-300">
					<thead class="bg-gray-50">
						<tr>
							<TableHeading :first="true">Nom</TableHeading>
							<TableHeading>Description</TableHeading>
							<TableHeading>Status</TableHeading>
							<th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
								<span class="sr-only">Actions</span>
							</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 bg-white">
						<tr v-for="claim in displayedData" :key="claim.claim_type_id">
							<TableData :first="true">{{ claim.claim_type_name }}</TableData>
							<TableData>{{ claim.claim_type_desc }}</TableData>
							<TableData>
                                <div class="flex space-x-4">
                                    <ToggleOnDatatable :link="route('claimTypes.update',{claimType: claim.claim_type_id})" :value="claim.claim_type_is_active" obj="claim_type_is_active"/>
                                    <span
                                        :class="claim.claim_type_is_active ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20'"
                                        class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                        {{ claim.claim_type_is_active ? 'Activé' : 'Désactivé' }}
                                    </span>
                                </div>
                            </TableData>
							<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <div class="flex items-center justify-center">
                                    <Link :href="route('claimTypes.edit', {claimType: claim.claim_type_id})" class="group flex items-center px-4 py-2 text-sm">
                                        <PencilSquareIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-cyan-600" aria-hidden="true" />
                                    </Link>
                                    <a href="#" @click="destroy(claim.claim_type_id)" class="group flex items-center px-4 py-2 text-sm">
                                        <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-red-600" aria-hidden="true" />
                                    </a>
                                </div>
							</td>
						</tr>
					</tbody>
				</table>
				<div v-else class="text-center bg-white text-lg text-gray-600 py-4"> Aucun élément trouvé. </div>
			</Datatable>
			<EmptyState
				v-else
				title="Pas de type de réclamation"
				message="Créer un nouveau type en appuyant sur ce bouton"
				:link="route('claimTypes.create')"
				action="Nouveau" />
			<DeleteModal
				:opened="openModal"
				:id="idToDestroy"
				@close-modal="openModal = false"
				name="claimType"
				link="claimTypes.destroy" />
		</div>
	</AuthenticatedLayout>
</template>

<style scoped></style>
