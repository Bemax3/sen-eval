<script setup>
import {ChevronRightIcon, HomeIcon} from '@heroicons/vue/20/solid'

defineProps({
    pages: {}
})
</script>

<template>
    <nav aria-label="Breadcrumb" class="flex mb-8 overflow-x-scroll">
        <ol class="flex items-center space-x-4" role="list">
            <li>
                <div>
                    <a :href="route('agents.index')" class="text-gray-400 hover:text-gray-500">
                        <HomeIcon aria-hidden="true" class="h-5 w-5 flex-shrink-0"/>
                        <span class="sr-only">Home</span>
                    </a>
                </div>
            </li>
            <li v-for="page in pages" :key="page.name">
                <div class="flex items-center">
                    <ChevronRightIcon aria-hidden="true" class="h-5 w-5 flex-shrink-0 text-gray-400"/>
                    <a :aria-current="page.current ? 'page' : undefined" :href="page.href" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">{{ page.name
                        }}</a>
                </div>
            </li>
        </ol>
    </nav>
</template>

