<script setup>
import VueTailwindDatePicker from 'vue-tailwind-datepicker';
import {ref, watch} from "vue";
import {moment, parseDate} from "@/helpers/helper.js";

const props = defineProps({
	modelValue: {
		type: Array,
		required: true,
	},
	invalid: {
		type: Boolean
	},
});

const dateValue = ref([]);
dateValue.value = [moment(props.modelValue[0]).format('DD-MM-YYYY'), moment(props.modelValue[1]).format('DD-MM-YYYY')]

const formatter = ref({
	date: 'DD-MM-YYYY',
	month: 'MMMM',
})

watch(() => dateValue.value, function (next) {
	if (next.length > 0)
		emit('update:modelValue', [parseDate(next[0], 'dd.mm.yyyy'), parseDate(next[1], 'dd.mm.yyyy')])
	else
		emit('update:modelValue', [])

})

const options = ref({
	shortcuts: {
		today: 'Aujourd\'hui',
		yesterday: 'Hier',
		past: period => `${period} derniers jours`,
		currentMonth: 'Ce mois ci',
		pastMonth: 'Dernier mois',
	},
	footer: {
		apply: 'Choisir',
		cancel: 'Annuler',
	},
})


const emit = defineEmits(['update:modelValue']);

</script>

<template>
	<VueTailwindDatePicker
			v-model="dateValue"
			:formatter="formatter"
			:input-classes="[invalid ? 'ring-red-400 focus:ring-red-600' : 'focus:ring-cyan-600', 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6']"
			:options="options"
			i18n="fr"
			separator=" au "
			use-range
	>
	</VueTailwindDatePicker>
</template>

<style scoped>

</style>
