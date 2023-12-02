<script setup>
const props = defineProps({
    title: {
        type: String,
    },
    desc: {
        type: String,
    }
})
</script>

<template>
    <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold leading-6 text-gray-900 dark:text-white">{{ title }}</h1>
        <p class="mt-2 text-sm text-gray-70s0 dark:text-white">{{ desc }}</p>
    </div>
    <!--	<div class="border-b border-gray-400  pb-5">-->
    <!--		<h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">{{ title }}</h3>-->
    <!--		<p class="mt-2 max-w-4xl text-sm text-gray-500 dark:text-gray-100">{{-->
    <!--				desc-->
    <!--			}}</p>-->
    <!--	</div>-->
</template>

<style scoped>

</style>
