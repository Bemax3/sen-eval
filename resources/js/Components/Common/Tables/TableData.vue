<script setup>
const props = defineProps({
    first: {
        type:Boolean,
        default:false
    }
})
</script>

<template>
    <td v-if="first" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><slot/></td>
    <td v-else class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><slot/></td>
</template>

<style scoped>

</style>
