<script setup>
import {StarIcon} from "@heroicons/vue/20/solid/index.js";

defineProps({
    required: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <label class="text-sm font-medium leading-6 text-gray-900 dark:text-white flex items-center gap-x-1">
        <slot/>
        <StarIcon v-if="required" class="text-red-500 h-1.5 w-1.5"/>
    </label>
</template>

