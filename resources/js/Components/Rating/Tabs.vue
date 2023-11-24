<script setup>
import {Link, router} from "@inertiajs/vue3";
import {getCurrentRoute} from "@/helpers/helper.js";
import {ref} from "vue";

const props = defineProps({
	rating_id: Number,
	agent_id: Number,
	evaluated: {
		type: Boolean, default: false
	},
	validator: {
		type: Boolean, default: false
	}
})

const currentRoute = getCurrentRoute();


const tabs = [
	!props.validator ?
			{
				name: 'Compétences',
				href: !props.evaluated ? route('agent-ratings.show', {
					agent: props.agent_id,
					agent_rating: props.rating_id
				}) : route('ratings.show', {rating: props.rating_id}),
				current: ['agent-ratings', 'ratings'].includes(currentRoute)
			}
			: {name: 'Compétences', href: route('validations.show', {validation: props.rating_id}), current: currentRoute === 'validations'}
	,
	{name: 'Réclamations', href: route('rating-claims.index', {rating: props.rating_id}), current: currentRoute === 'rating-claims'},
	{name: 'Formations', href: route('rating-trainings.index', {rating: props.rating_id}), current: currentRoute === 'rating-trainings'},
	{name: 'Mobilités', href: route('rating-mobilities.index', {rating: props.rating_id}), current: currentRoute === 'rating-mobilities'},
	{name: 'Sanctions', href: route('rating-sanctions.index', {rating: props.rating_id}), current: currentRoute === 'rating-sanctions'},
	{name: 'Promotions & Avancements', href: route('rating-promotions.index', {rating: props.rating_id}), current: currentRoute === 'rating-promotions'},
]

const selectedTab = ref(tabs.filter(t => t.current === true)[0])

const changeTab = () => {
	router.get(selectedTab.value.href)
}

</script>

<template>
	<div class="border-b border-gray-200 pb-5 sm:pb-0">
		<div class="mt-3 sm:mt-4">
			<div class="sm:hidden">
				<label class="sr-only" for="current-tab">Select a tab</label>
				<select id="current-tab"
				        v-model="selectedTab"
				        class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-cyan-600 focus:outline-none focus:ring-cyan-500 sm:text-sm"
				        name="current-tab"
				        @change="changeTab">
					<option v-for="tab in tabs" :key="tab.name" :selected="tab.current" :value="tab">{{ tab.name }}</option>
				</select>
			</div>
			<div class="hidden sm:block">
				<nav class="-mb-px flex space-x-8">
					<Link v-for="tab in tabs" :key="tab.name" :aria-current="tab.current ? 'page' : undefined"
					      :class="[tab.current ? 'border-cyan-600 text-cyan-700' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium']"
					      :href="tab.href">{{ tab.name }}
					</Link>
				</nav>
			</div>
		</div>
	</div>
</template>

<style scoped>

</style>
