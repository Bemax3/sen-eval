<script setup>

const props = defineProps({data: Array, name: String, plural: {type: String, required: false}})


const tops = props.data.map(p => {
    return {
        id: eval("p." + props.name + "_type_id"),
        item: {name: eval("p." + props.name + "_type_name")},
        count: props.plural ? eval("p." + props.plural + "_count") : eval("p." + props.name + "s_count")
    }
}).slice(0, 10);
</script>

<template>
    <ul class="mt-6 space-y-6" role="list">
        <li v-for="(topItem, topItemIdx) in tops" :key="topItem.id" class="relative flex gap-x-4">
            <div :class="[topItemIdx === tops.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
                <div class="w-px bg-gray-200"/>
            </div>

            <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"/>
            </div>
            <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                <span class="font-medium text-gray-900">{{ topItem.item.name }}</span>
            </p>
            <p class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ topItem.count }}</p>
        </li>
    </ul>
</template>

