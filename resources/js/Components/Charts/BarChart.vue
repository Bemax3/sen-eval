<script setup>

defineProps({
    chartOptions: {},
    series: {},
})

</script>

<template>
    <div id="bar-chart">
        <apexchart :options="chartOptions" :series="series" type="bar"></apexchart>
    </div>
</template>

