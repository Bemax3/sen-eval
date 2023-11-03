<script setup>

defineProps({title: String,mark: Number,marking: Number})
</script>

<template>
    <div class="border-b border-cyan-600 bg-white pr-4 py-2 sm:pr-6 flex justify-between items-center">
        <h3 class="text-lg font-semibold leading-6 text-gray-900">{{title}}</h3>
        <div class="flex space-x-2">
            <span class="flex-shrink-0">
                <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                    <span class="text-cyan-600">{{mark}}</span>
                </span>
            </span>
            <span class="text-3xl">/</span>
            <span class="flex-shrink-0">
                <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-cyan-600">
                    <span class="text-cyan-600">{{marking}}</span>
                </span>
            </span>
        </div>
    </div>
</template>

<style scoped>

</style>
