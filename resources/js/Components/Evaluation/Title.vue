<script setup>
import {computed} from "vue";

const props = defineProps({agent: Object,evaluation: Object})

const markColor = computed(()=> {
    if(props.evaluation.evaluation_mark < 50) return 'red';
    else if(props.evaluation.evaluation_mark < 75) return 'amber';
    else return 'green'
})

</script>

<template>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900">
                    Évaluation de {{agent.user_display_name}}. Matricule : {{agent.user_matricule}}
                    Année : {{evaluation.phase.phase_year}}
                </h1>
                <span class="flex-shrink-0">
                    <span class="flex h-20 w-20 items-center justify-center rounded-full border-4" :class="`border-${markColor}-600`">
                        <span :class="`text-${markColor}-600`" class="text-2xl font-bold">{{ evaluation.evaluation_mark }}</span>
                    </span>
                </span>
            </div>
            <p class="mt-2 text-sm text-gray-700">
                Évaluateur: {{evaluation.evaluator.user_display_name}}. Matricule : {{evaluation.evaluator.user_matricule}}.
            </p>
        </div>
    </div>
</template>

<style scoped>

</style>
