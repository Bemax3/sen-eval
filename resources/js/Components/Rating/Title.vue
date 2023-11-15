<script setup>
import {computed} from "vue";

const props = defineProps({agent: Object, rating: Object})
const color = computed(() => {
	let mark = props.rating.rating_mark
	switch (true) {
		case (mark < 50):
			return 0;
		case (mark >= 50 && mark < 75):
			return 1;
		case (mark >= 75):
			return 2;
	}
})
</script>

<template>
	<div class="sm:flex sm:items-center">
		<div class="sm:flex-auto">
			<div class="flex justify-between items-center">
				<div class="sm:flex sm:justify-between sm:items-center gap-2">
					<h1 class="text-2xl font-semibold leading-6 text-gray-900">
						Évaluation de {{ agent.user_display_name }}
					</h1>
					<p v-if="rating.rating_is_contested"
					   class="text-white bg-red-600 ring-red-600/20 rounded-md mt-0.5 px-1.5 py-0.5 text-xs font-bold ring-1 ring-inset max-w-fit">
						Contesté
					</p>
				</div>
				<span class="flex-shrink-0">
                    <span :class="color === 0 ? 'border-red-600' : (color === 1 ? 'border-amber-600' : 'border-green-600')"
                          class="flex h-20 w-20 items-center justify-center rounded-full border-4">
                        <span :class="color === 0 ? 'text-red-600' : (color === 1 ? 'text-amber-600' : 'text-green-600')" class="text-2xl font-bold">
	                        {{ rating.rating_mark }}
                        </span>
                    </span>
                </span>
			</div>
			Matricule : {{ agent.user_matricule }}
			Année : {{ rating.phase.phase_year }}
			<div class="sm:flex sm:items-center gap-2">
				Évaluateur:
				<p class="text-sm text-gray-700">
					{{ rating.evaluator.user_display_name }}. Matricule : {{ rating.evaluator.user_matricule }}.
				</p>

			</div>
			<div v-if="rating.validated_by_n2" class="sm:flex sm:items-center gap-2">
				(N + 2):
				<p class="text-sm text-gray-700">
					{{ rating.validator.user_display_name }}. Matricule : {{ rating.validator.user_matricule }}.
				</p>
			</div>
		</div>
	</div>
</template>

<style scoped>

</style>
