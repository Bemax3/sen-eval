<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
<span v-show="message" class="text-xs text-red-600">
    {{ message }}
</span>
</template>

