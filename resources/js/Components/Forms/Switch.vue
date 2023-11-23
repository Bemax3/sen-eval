<script setup>
import {ref, watch} from 'vue'
import {Switch, SwitchDescription, SwitchGroup, SwitchLabel} from '@headlessui/vue'

const props = defineProps({
    modelValue: {
        type: Number,
        required: true,
    },
    label: {
        type: String,
    },
    desc: {
        type: String
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const enabled = ref(props.modelValue === 1)

watch(() => enabled.value, function (next) {
    emit('update:modelValue', next ? 1 : 0)
})

watch(() => props.modelValue, function (next) {
    enabled.value = next === 1;
})

const emit = defineEmits(['update:modelValue']);

</script>

<template>
    <SwitchGroup as="div" class="flex items-center justify-between">
        <span class="flex flex-grow flex-col">
            <SwitchLabel as="span" class="text-sm font-medium leading-6 text-gray-900" passive>{{ label }}</SwitchLabel>
            <SwitchDescription as="span" class="text-sm text-gray-500">{{ desc }}</SwitchDescription>
        </span>
        <Switch v-model="enabled"
                :class="[enabled ? 'bg-cyan-600 ' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-cyan-700 focus:ring-offset-2']"
                :disabled="disabled">
            <span
                :class="[enabled ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']"
                aria-hidden="true"/>
        </Switch>
    </SwitchGroup>
</template>

