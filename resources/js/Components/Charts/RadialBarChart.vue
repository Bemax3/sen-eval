<script setup>
defineProps({chartOptions: {}, series: {}})
</script>

<template>
    <div id="chart">
        <apexchart :options="chartOptions" :series="series" height="350" type="radialBar"></apexchart>
    </div>

</template>

<style scoped>

</style>
