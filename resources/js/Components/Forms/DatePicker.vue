<script setup>
import VueTailwindDatePicker from 'vue-tailwind-datepicker';
import {computed, ref, watch} from "vue";
import  {CalendarDaysIcon,XCircleIcon} from "@heroicons/vue/24/outline/index.js";
import {moment, parseDate} from "@/helpers/helper.js";

const props = defineProps({
	modelValue: {
		type: Date,
		required: true,
	},
	invalid: {
		type: Boolean
	},
});

const dateValue = ref([]);
dateValue.value = [moment(props.modelValue).format('DD-MM-YYYY')]

const formatter = ref({
	date: 'DD-MM-YYYY',
	month: 'MM',
})

watch(() => dateValue.value,function (next) {
	emit('update:modelValue',parseDate(next[0],'dd.mm.yyyy'))
})


const emit = defineEmits(['update:modelValue']);

</script>

<template>
	<VueTailwindDatePicker
		:input-classes="[invalid ? 'ring-red-400 focus:ring-red-600' : 'focus:ring-cyan-600', 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6']"
		v-model="dateValue"
		:formatter="formatter"
	>
<!--		<template #inputIcon="{ value }">-->
<!--			<component :is="XCircleIcon" v-if="value" />  <component :is="CalendarDaysIcon" v-else />-->
<!--		</template>-->
	</VueTailwindDatePicker>
</template>

<style scoped>

</style>
