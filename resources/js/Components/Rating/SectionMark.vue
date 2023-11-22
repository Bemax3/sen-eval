<script setup>
defineProps({title: String, mark: Number, marking: Number})
</script>
<template>
    <div class="border-gray-300 pr-4 py-2 sm:pr-6 flex justify-between items-center border-b-2">
        <h3 :class="!marking ? 'h-9' : ''" class="text-lg font-semibold leading-6 text-gray-900">{{ title }}</h3>
        <div v-if="marking" class="flex space-x-2">
            <span class="flex-shrink-0">
                <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-gray-900">
                    <span class="text-gray-900">{{ mark ?? 0 }}</span>
                </span>
            </span>
            <span class="text-3xl">/</span>
            <span class="flex-shrink-0">
                <span class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-gray-900">
                    <span class="text-gray-900">{{ marking }}</span>
                </span>
            </span>
        </div>
    </div>
</template>

<style scoped>

</style>
