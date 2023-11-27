<script setup>
import {CheckIcon} from "@heroicons/vue/20/solid";
import {watch} from "vue";

const props = defineProps({disabled: {}, processing: {}});
watch(() => props.disabled, function (next) {
})

</script>

<template>
    <button
        :class="disabled ? 'bg-gray-600' : 'hover:bg-cyan-700     bg-cyan-600 '"
        :disabled="disabled || processing"
        class="inline-flex gap-x-1.5 disabled:opacity-70 rounded-md  px-3 py-2 text-sm font-semibold text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600"
        type="submit">
        <slot/>
        <CheckIcon v-if="!processing" class="text-white -mr-0.5 h-5 w-5"/>
        <span v-else class="border-white border-2 rounded-full px-2 py-2 -mr-0.5 h-4 w-4 border-t-cyan-600 animate-spin"></span>
    </button>
</template>


