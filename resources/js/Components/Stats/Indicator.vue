<script setup>

defineProps({
    name: {},
    value: {},
    icon: {},
})

</script>

<template>
    <div class="rounded-lg bg-white px-4 pt-5 shadow sm:px-6 sm:pt-6">
        <dt>
            <div class="absolute rounded-md bg-cyan-600  p-3">
                <component :is="icon" aria-hidden="true" class="h-6 w-6 text-white"/>
            </div>
            <p class="ml-16 truncate text-sm font-medium text-gray-500 ">{{ name }}</p>
        </dt>
        <dd class="ml-16 flex items-baseline">
            <p class="text-2xl font-semibold text-cyan-600">{{ value }}</p>
            <!--			<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">-->
            <!--				<div class="text-sm">-->
            <!--					<a class="font-medium text-indigo-600 hover:text-indigo-500" href="#">View all-->
            <!--						<span class="sr-only"> {{ name }} stats</span>-->
            <!--					</a>-->
            <!--				</div>-->
            <!--			</div>-->
        </dd>
    </div>
</template>

<style scoped>

</style>
