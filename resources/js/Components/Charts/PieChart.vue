<script setup>
import {onBeforeMount, ref, watch} from "vue";
import {theme} from "@/theme.js";

const props = defineProps({
    chartOptions: {},
    series: {},
})

const key = ref(0);

const options = ref(props.chartOptions)

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

onBeforeMount(() => {
    setTheme(theme.dark)
})

watch(() => theme.dark, (next) => {
    setTheme(next)
    key.value += 1;
})

</script>
<template>
    <div id="pie-chart" class="m-auto my-8">
        <apexchart :key="key" :options="options" :series="series" type="pie"></apexchart>
    </div>
</template>
