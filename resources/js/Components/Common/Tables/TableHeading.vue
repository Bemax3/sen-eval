<script setup>
const props = defineProps({
    first: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <th v-if="first" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6" scope="col">
        <slot/>
    </th>
    <th v-else class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900" scope="col">
        <slot/>
    </th>
</template>

<style scoped>

</style>
