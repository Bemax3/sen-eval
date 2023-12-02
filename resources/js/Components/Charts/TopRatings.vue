<script setup>
import {computed} from "vue";

const props = defineProps({tops: {}})
const color = computed(() => {
    let mark = props.tops.rating_mark
    switch (true) {
        case (mark <= 25):
            return 'red';
        case (mark > 25 && mark <= 50):
            return 'amber';
        case (mark > 50 && mark <= 75):
            return 'green';
        default:
            return 'cyan';
    }
})
</script>

<template>
    <ul class="mt-6 space-y-6" role="list">
        <li v-for="(topItem, topItemIdx) in tops" :key="topItem.rating_id" class="relative flex gap-x-4">
            <div :class="[topItemIdx === tops.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
                <div class="w-px bg-gray-200"/>
            </div>

            <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white dark:bg-grayish">
                <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"/>
            </div>
            <p class="flex-auto py-0.5 text-base leading-5 text-gray-500 dark:text-gray-100 space-x-3">
                <span class="font-medium text-gray-900 dark:text-white">{{ topItem.evaluated.user_display_name + ' - ' + topItem.evaluated.user_matricule }}</span>
                <span
                    :class="topItem.rating_is_validated ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-600 dark:text-white' : 'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-600 dark:text-white'"
                    class="inline-flex items-center rounded-md  px-2 py-1 text-xs font-medium ring-1 ring-inset ">
                                        {{ topItem.rating_is_validated ? 'Validé' : 'En attende' }}
                                    </span>
            </p>
            <p :class="color === 'red' ? 'text-red-600' : (color === 'amber' ? 'text-amber-600' : (color === 'green' ? 'text-green-600' : 'text-cyan-600'))"
               class="flex-none py-0.5 text-base font-bold leading-5">{{ topItem.rating_mark }}</p>
        </li>
    </ul>
</template>

<style scoped>

</style>
