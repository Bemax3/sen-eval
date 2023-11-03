<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    evaluation_id: Number,
})

const tabs = [
    { name: 'Compétences', href: '#', current: true },
    { name: 'Réclamations', href: '#', current: false },
    { name: 'Formations', href: '#', current: false },
    { name: 'Mobilités', href: '#', current: false },
    { name: 'Sanctions', href: '#', current: false },
    { name: 'Promotions & Avancements', href: '#', current: false },
]

</script>

<template>
    <div class="border-b border-gray-200 pb-5 sm:pb-0">
        <div class="mt-3 sm:mt-4">
            <div class="sm:hidden">
                <label for="current-tab" class="sr-only">Select a tab</label>
                <select id="current-tab" name="current-tab" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-cyan-500 focus:outline-none focus:ring-cyan-500 sm:text-sm">
                    <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <nav class="-mb-px flex space-x-8">
                    <Link v-for="tab in tabs" :key="tab.name" :href="tab.href" :class="[tab.current ? 'border-cyan-500 text-cyan-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium']" :aria-current="tab.current ? 'page' : undefined">{{ tab.name }}</Link>
                </nav>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
