<script setup>

import {computed, onBeforeMount, ref, watch} from "vue";
import {theme} from "@/theme.js";

const props = defineProps({
    chartOptions: {},
    series: {},
})

const options = computed(() => props.chartOptions)

const key = ref(0);

const setTheme = (next) => {
    options.value.theme = {
        mode: next ? 'dark' : 'light'
    }
    if (next) {
        options.value.legend.markers.colors = '#FFFFFF'
        options.value.chart.background = '#18181B'
    } else {
        options.value.legend.markers.colors = '#18181B'
        options.value.chart.background = '#FFFFFF'

    }
}

onBeforeMount(() => {
    setTheme(theme.dark)
})

watch(() => theme.dark, (next) => {
    setTheme(next)
    key.value += 1;
})

</script>

<template>
    <div id="bar-chart">
        <apexchart :key="key" :options="options" :series="series" type="bar"></apexchart>
    </div>
</template>

