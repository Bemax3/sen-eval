<script setup>
const props = defineProps({
    first: {
        type:Boolean,
        default:false
    }
})
</script>

<template>
    <th v-if="first" scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"><slot/></th>
    <th v-else scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><slot/></th>
</template>

<style scoped>

</style>
