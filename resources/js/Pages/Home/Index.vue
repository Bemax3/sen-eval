<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link} from "@inertiajs/vue3";
import {PlusIcon} from "@heroicons/vue/20/solid/index.js";
</script>

<template>
    <AuthenticatedLayout>
        <div class=" space-x-2 mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <Link
                :href="route('home.ldap')"
                class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                Test Ldap
                <PlusIcon class="-mr-0.5 h-5 w-5"/>
            </Link>
            <Link
                :href="route('home.oracle')"
                class="inline-flex gap-x-1.5 rounded-md bg-cyan-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-cyan-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600">
                Test Oracle
                <PlusIcon class="-mr-0.5 h-5 w-5"/>
            </Link>

        </div>
    </AuthenticatedLayout>
</template>

