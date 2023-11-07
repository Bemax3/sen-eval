<script setup>

import {Link, usePage} from '@inertiajs/vue3';
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {ChevronDownIcon, MagnifyingGlassIcon} from "@heroicons/vue/20/solid/index.js";
import {Bars3Icon, BellIcon} from "@heroicons/vue/24/outline/index.js";
import {computed} from "vue";

defineEmits(['openSidebar']);


const user = computed(() => usePage().props.auth.user);

const userNavigation = [
    { name: 'Mon profil', href: route('profile.index') },
]

</script>

<template>
    <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="$emit('openSidebar')">
            <span class="sr-only">Open sidebar</span>
            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
        </button>
        <!-- Separator -->
        <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true" />

        <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
            <div class="relative flex flex-1 items-center">
<!--                <h1 class="text-xl text-cyan-700 font-bold">Sen Rating</h1>-->
            </div>
            <div class="flex items-center gap-x-4 lg:gap-x-6">
                <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                    <span class="sr-only">View notifications</span>
                    <BellIcon class="h-6 w-6" aria-hidden="true" />
                </button>

                <!-- Separator -->
                <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true" />

                <!-- Profile dropdown -->
                <Menu as="div" class="relative">
                    <MenuButton class="-m-1.5 flex items-center p-1.5">
                        <span class="sr-only">Open user menu</span>
<!--                        <img class="h-8 w-8 rounded-full bg-gray-50" src="" alt="" />-->
                        <span class="hidden lg:flex lg:items-center">
                  <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{user.user_display_name}}</span>
                  <ChevronDownIcon class="ml-2 h-5 w-5 text-gray-400" aria-hidden="true" />
                </span>
                    </MenuButton>
                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                            <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                <Link :href="item.href" :class="[active ? 'bg-cyan-500 text-white' : 'text-gray-900', 'block px-3 py-1 text-sm leading-6 ']" as="span">{{ item.name }}</Link>
                            </MenuItem>
                            <MenuItem v-slot="{active}">
	                            <Link :href="route('logout')" method="post" :class="[active ? 'bg-cyan-500 text-white' : 'text-gray-900', 'block px-3 py-1 text-sm leading-6 ']" as="span">
                                    Déconnexion
                                </Link>
                            </MenuItem>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
