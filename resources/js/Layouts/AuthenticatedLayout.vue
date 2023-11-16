<script setup>

import SideBar from "@/Components/LayoutParts/SideBar.vue";
import NavBar from "@/Components/LayoutParts/NavBar.vue";
import {computed, ref} from "vue";
import Alert from "@/Components/LayoutParts/Alert.vue";
import {usePage} from "@inertiajs/vue3";

let sidebarOpen = ref(false)

const openSidebar = () => {
    sidebarOpen.value = true;
}
const closeSidebar = () => {
    sidebarOpen.value = false;
}

const notification = computed(() => usePage().props.flash.notify);

</script>

<template>
    <div>
        <SideBar :opened="sidebarOpen" @close-sidebar="closeSidebar"/>
        <div class="lg:pl-64">
            <NavBar @open-sidebar="openSidebar"/>
            <main class="py-5">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot/>
                    <Alert :notification="notification"/>
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>

</style>
