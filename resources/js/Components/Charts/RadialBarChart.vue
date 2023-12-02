<script setup>
import {ref, watch} from "vue";
import {theme} from "@/theme.js";

const props = defineProps({
    chartOptions: {},
    series: {},
})

const options = ref(props.chartOptions)

const key = ref(0);

const setTheme = (next) => {
    options.value.theme = {
        mode: next ? 'dark' : ''
    }
    if (next) {
        options.value.chart.background = '#18181B'
    } else {
        options.value.chart.background = '#FFFFFF'
    }
}


watch(() => theme.dark, (next) => {
    setTheme(next)
    key.value += 1;
})

</script>

<template>
    <div id="chart">
        <apexchart :key="key" :options="options" :series="series" height="350" type="radialBar"></apexchart>
    </div>

</template>

<style scoped>

</style>
