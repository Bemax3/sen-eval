<script setup>
import {computed} from "vue";

const props = defineProps({agent: Object,rating: Object})

const color = computed(()=> {
    let mark = props.rating.rating_mark
    switch (true) {
        case (mark < 50): return 0;
        case (mark >= 50 && mark < 75): return 1;
        case (mark >= 75): return 2;
    }
})
</script>

<template>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900">
                    Évaluation de {{agent.user_display_name}}. Matricule : {{agent.user_matricule}}
                    Année : {{rating.phase.phase_year}}
                </h1>
                <span class="flex-shrink-0">
                    <span class="flex h-20 w-20 items-center justify-center rounded-full border-4" :class="color === 0 ? 'border-red-600' : (color === 1 ? 'border-amber-600' : 'border-green-600')">
                        <span :class="color === 0 ? 'text-red-600' : (color === 1 ? 'text-amber-600' : 'text-green-600')" class="text-2xl font-bold">{{ rating.rating_mark }}</span>
                    </span>
                </span>
            </div>
            <p class="mt-2 text-sm text-gray-700">
                Évaluateur: {{rating.evaluator.user_display_name}}. Matricule : {{rating.evaluator.user_matricule}}.
            </p>
        </div>
    </div>
</template>

<style scoped>

</style>
