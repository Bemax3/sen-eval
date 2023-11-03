<script setup>
const props = defineProps({
    title: {
        type: String
    }
})
</script>

<template>
    <div class="relative mt-8 mb-8">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-300" />
        </div>
        <div class="relative flex justify-center">
            <span class="bg-white px-3 text-base font-semibold leading-6 text-gray-900">{{ title }}</span>
        </div>
    </div>
</template>

<style scoped>

</style>
