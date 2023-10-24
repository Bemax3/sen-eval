<script setup>
import {onMounted, ref} from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
        default: ''
    },
    invalid: {
        type: Boolean
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({focus: () => input.value.focus()});
</script>

<template>
    <textarea
        ref="input"
        rows="3"
        @input="$emit('update:modelValue', $event.target.value)"
        :value="modelValue"
        :class="invalid ? 'ring-red-400 focus:ring-red-600' : 'focus:ring-purple-600'"
        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6"
    ></textarea>
</template>

<style scoped>

</style>
