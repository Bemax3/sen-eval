<script setup>

import {moment} from "@/helpers/helper.js";
import {computed} from "vue";
import {ChatBubbleOvalLeftEllipsisIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    history: {}
})

const activity = computed(() => {
    let activities = [];
    props.history.forEach(h => activities.push(
        {
            id: h.goal_history_id,
            type: h.comment ? 'commented' : 'a modifié',
            person: {
                name: h.updated_by.user_display_name,
            },
            comment: h.comment,
            date: moment(h.updated_at).format('DD MMMM YYYY á HH:mm'),
            dateTime: h.updated_at,
            rate: h.goal_rate
        }
    ))

    return activities;
})

</script>

<template>

    <h2 class="mt-2 text-sm font-semibold leading-6 text-gray-900">Activité</h2>
    <ul v-if="history.length > 0" class="mt-6 space-y-6" role="list">
        <li v-for="(activityItem, activityItemIdx) in activity" :key="activityItem.id" class="relative flex gap-x-4">
            <div :class="[activityItemIdx === activity.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
                <div class="w-px bg-gray-200"/>
            </div>
            <template v-if="activityItem.type === 'commented'">
                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                    <ChatBubbleOvalLeftEllipsisIcon aria-hidden="true" class="h-6 w-6 text-cyan-600"/>
                </div>
                <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                    <div class="flex justify-between gap-x-4">
                        <div class="py-0.5 text-xs leading-5 text-gray-500">
                            <span class="font-medium text-gray-900">{{ activityItem.person.name }}</span> a commenté
                            <br><span class="font-medium text-gray-900">Taux de réalisation</span>
                            <span class="ml-1 text-sm font-semibold text-cyan-600"> {{ activityItem.rate }} % </span>
                        </div>
                        <time :datetime="activityItem.dateTime" class="flex-auto text-right py-0.5 text-xs leading-5 text-gray-500">
                            {{ activityItem.date }}
                        </time>
                    </div>
                    <p class="text-sm leading-6 text-gray-500">{{ activityItem.comment }}</p>
                </div>
            </template>
            <template v-else>
                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                    <!--					<CheckCircleIcon v-if="activityItem.type === 'paid'" aria-hidden="true" class="h-6 w-6 text-indigo-600"/>-->
                    <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300"/>
                </div>
                <div class="flex-auto  p-3">
                    <div class="flex justify-between gap-x-4">
                        <div class="py-0.5 text-xs leading-5 text-gray-500">
                            <span class="font-medium text-gray-900">{{ activityItem.person.name }}</span> {{ activityItem.type }} l'objectif.
                            <br><span class="font-medium text-gray-900">Taux de réalisation</span>
                            <span class="ml-1 text-sm font-semibold text-cyan-600"> {{ activityItem.rate }} % </span>
                        </div>
                        <time :datetime="activityItem.dateTime" class="flex-auto text-right py-0.5 text-xs leading-5 text-gray-500">{{ activityItem.date }}</time>
                    </div>
                </div>
            </template>
        </li>
    </ul>
</template>

<style scoped>

</style>
