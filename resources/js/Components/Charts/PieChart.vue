<script setup>
defineProps({
    chartOptions: {},
    series: {},
})
</script>
<template>
    <div id="pie-chart" class="m-auto my-8">
        <apexchart :options="chartOptions" :series="series" type="pie"></apexchart>
    </div>
</template>
