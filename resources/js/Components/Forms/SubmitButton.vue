<script setup>
import {CheckIcon} from "@heroicons/vue/20/solid";
import {watch} from "vue";

const props = defineProps({disabled: {}});
watch(() => props.disabled, function (next) {})

</script>

<template>
    <button :disabled="disabled" type="submit" class=" z-10 inline-flex gap-x-1.5 disabled:opacity-70 rounded-md bg-cyan-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
        <slot />
	    <CheckIcon v-if="!disabled"  class="text-white -mr-0.5 h-5 w-5" />
	    <span v-else class="border-white border-2 rounded-full px-2 py-2 -mr-0.5 h-4 w-4 border-t-cyan-600 animate-spin"></span>
    </button>
</template>


