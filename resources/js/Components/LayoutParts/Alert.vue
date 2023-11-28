<script setup>

import {watch} from "vue";
import {CheckCircleIcon, XCircleIcon, XMarkIcon} from '@heroicons/vue/20/solid'

const props = defineProps({
    notification: {
        type: Object,
    },
})

const showToast = () => {
    setTimeout(function () {
        document.getElementById('notification').style.visibility = 'hidden';
        document.getElementById('notification-container').style.zIndex = '-1';
    }, 5000);
    document.getElementById('notification').style.visibility = 'visible';
    document.getElementById('notification-container').style.zIndex = '20';
}
const closeToast = () => {
    document.getElementById('notification').style.visibility = 'hidden';
    document.getElementById('notification-container').style.zIndex = '-1';
}

watch(() => props.notification, (next) => {
    if (next)
        showToast()
}, {deep: true})

</script>

<template>
    <div id="notification-container" aria-live="assertive" class="fixed bottom-1 right-1 flex items-end px-4 py-6 sm:items-start sm:p-6">
        <div
            v-show="notification?.message"
            id="notification"
            :class="notification?.type  === 'success' ? 'bg-green-600' : 'bg-red-600'"
            class="rounded-md p-4"
        >
            <div class="flex">
                <div class="flex-shrink-0">
                    <CheckCircleIcon v-if="notification?.type === 'success'" aria-hidden="true" class="h-5 w-5 text-white"/>
                    <XCircleIcon v-else aria-hidden="true" class="h-5 w-5 text-white"/>
                </div>
                <div class="ml-3">
                    <p
                        class="text-sm font-medium text-white"
                    >{{ notification?.message }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button
                            :class="notification?.type  === 'success' ? 'bg-green-600  hover:bg-green-600 focus:ring-green-600 focus:ring-offset-green-50' : 'bg-red-600 hover:bg-red-600 focus:ring-red-600 focus:ring-offset-red-50'"
                            class="inline-flex rounded-md p-1.5  focus:outline-none focus:ring-2 focus:ring-offset-2 text-white"
                            type="button"
                            @click="closeToast"
                        >
                            <span class="sr-only">Fermer</span>
                            <XMarkIcon aria-hidden="true" class="h-5 w-5"/>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
