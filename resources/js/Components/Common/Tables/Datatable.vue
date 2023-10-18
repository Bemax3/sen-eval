<script setup>
	import {MagnifyingGlassIcon, ChevronLeftIcon, ChevronRightIcon} from '@heroicons/vue/20/solid/index.js';
	import {Link} from '@inertiajs/vue3';
	defineProps({
		pagination: Object,
		modelValue: {
			type: String,
			required: true,
		},
	});

	defineEmits(['update:modelValue']);
</script>

<template>
	<div class="mt-8 flow-root">
		<div class="-mx-4 -my-2 overflow-x-scroll  sm:-mx-6 lg:-mx-8">
			<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
				<div class="overflow-y-visible shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
					<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
						<form class=" relative flex flex-1">
							<label for="search-field" class="sr-only">Recherche</label>
							<MagnifyingGlassIcon
								class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
								aria-hidden="true" />
							<input
								:value="modelValue"
								@input="$emit('update:modelValue', $event.target.value)"
								class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
								placeholder="Recherche..."
								type="search"
								name="search" />
						</form>
					</div>
					<slot />
					<div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
						<template v-if="!modelValue">
							<div class="flex flex-1 justify-between sm:hidden">
								<template v-for="link in pagination.links">
									<Link
										v-if="link.label === 'p'"
										:href="link.url ? link.url : '#'"
										class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-cyan-600 hover:text-white"
										:key="link.label"
										>Précedent</Link
									>
									<Link
										v-if="link.label === 'n'"
										:href="link.url ? link.url : '#'"
										class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-cyan-600 hover:text-white"
										:key="link.label"
										>Suivant</Link
									>
								</template>
							</div>
							<div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
								<div>
									<p class="text-sm text-gray-700">
										Montre

										<span class="font-medium">{{ pagination.from }}</span>

										à

										<span class="font-medium">{{ pagination.to }}</span>

										de

										<span class="font-medium">{{ pagination.total }}</span>

										résultats
									</p>
								</div>
								<div>
									<nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
										<template v-for="link in pagination.links">
											<Link
												v-if="link.label === 'p'"
												:href="link.url ? link.url : '#'"
												class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-cyan-600 hover:text-white focus:z-20 focus:outline-offset-0"
												:key="link.label">
												<span class="sr-only">Previous</span>
												<ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
											</Link>
											<!-- Current: "z-10 bg-cyan-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600", Default: "" -->
											<Link
												v-if="link.label !== 'p' && link.label !== 'n'"
												:href="link.url"
												:key="link.label"
												class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-cyan-600 hover:text-white focus:z-20 focus:outline-offset-0"
												:class="
													link.active
														? 'z-10 bg-cyan-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-600'
														: ''
												"
												>{{ link.label }}</Link>
											<Link
												v-if="link.label === 'n'"
												:href="link.url ? link.url : '#'"
												class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-cyan-600 hover:text-white focus:z-20 focus:outline-offset-0"
												:key="link.label">
												<span class="sr-only">Next</span>
												<ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
											</Link>
										</template>
									</nav>
								</div>
							</div>
						</template>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<style scoped></style>
