<script setup>
import {ref} from 'vue';

defineProps({
    modelValue: {
        type: Number || String || null,
        required: true,
        default: 5
    },
    invalid: {
        type: Boolean
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

</script>

<template>
    <input
        ref="input"
        :class="invalid ? 'ring-red-400 focus:ring-red-600': 'focus:ring-s-pink-800'"
        :value="modelValue"
        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset  sm:text-sm sm:leading-6"
        type="number"
        @input="$emit('update:modelValue', parseInt($event.target.value))"/>
</template>
