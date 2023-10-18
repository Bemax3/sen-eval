<script setup>

import {watch} from "vue";
import { CheckCircleIcon, XMarkIcon, XCircleIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
	notify: {
		type: Object,
		default: {}
	},
})


const showToast = () => {
	setTimeout(function () {
		document.getElementById('notify').style.visibility = 'hidden';
	}, 5000);
	document.getElementById('notify').style.visibility = 'visible';
}

const closeToast = () => {
	document.getElementById('notify').style.visibility = 'hidden'
}

watch(() => props.notify, (next) => {
	if (next)
		showToast()
})

</script>

<template>
	<div aria-live="assertive" class="fixed bottom-1 right-1 flex items-end px-4 py-6 sm:items-start sm:p-6">
		<div
				v-show="notify?.message"
				id="notify"
				class="rounded-md p-4"
				:class="notify?.type  === 'success' ? 'bg-green-100' : 'bg-red-50'"
		>
			<div class="flex">
				<div class="flex-shrink-0">
					<CheckCircleIcon v-if="notify?.type === 'success'" class="h-5 w-5 text-green-400" aria-hidden="true" />
					<XCircleIcon v-else class="h-5 w-5 text-red-400" aria-hidden="true" />
				</div>
				<div class="ml-3">
					<p
						class="text-sm font-medium text-green-800"
						:class="notify?.type  === 'success' ? 'text-green-800' : 'text-red-800'"
					>{{ notify?.message }}</p>
				</div>
				<div class="ml-auto pl-3">
					<div class="-mx-1.5 -my-1.5">
						<button
							type="button"
					        class="inline-flex rounded-md p-1.5  focus:outline-none focus:ring-2 focus:ring-offset-2 "
							:class="notify?.type  === 'success' ? 'bg-green-100 text-green-500 hover:bg-green-100 focus:ring-green-600 focus:ring-offset-green-50' : 'bg-red-50 text-red-500 hover:bg-red-100 focus:ring-red-600 focus:ring-offset-red-50'"
							@click="closeToast"
						>
							<span class="sr-only">Fermer</span>
							<XMarkIcon class="h-5 w-5" aria-hidden="true" />
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--	<div-->
<!--			id="notify"-->
<!--			:class="notify?.type  === 'success' ? 'bg-success' : 'bg-danger'"-->
<!--			aria-atomic="true"-->
<!--			aria-live="assertive"-->
<!--			class="toast show text-white border-0"-->
<!--			data-bs-autohide="true"-->
<!--			data-bs-toggle="toast"-->
<!--			role="alert"-->
<!--			style="z-index: 11; position: fixed; bottom: 30px; right: 10px; visibility: hidden">-->
<!--		<div class="d-flex">-->
<!--			<div class="toast-body">{{ notify?.message }}</div>-->
<!--			<button-->
<!--					aria-label="Close"-->
<!--					class="btn-close btn-close-white me-2 m-auto"-->
<!--					data-bs-dismiss="toast"-->
<!--					type="button"></button>-->
<!--		</div>-->
<!--	</div>-->
</template>

<style scoped>

</style>
