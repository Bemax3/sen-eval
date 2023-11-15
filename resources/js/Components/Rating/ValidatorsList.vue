<script setup>

import {capitalized, moment} from "@/helpers/helper.js";
import SimpleTable from "@/Components/Common/Tables/SimpleTable.vue";
import TableHeading from "@/Components/Common/Tables/TableHeading.vue";
import TableData from "@/Components/Common/Tables/TableData.vue";

defineProps({
	validators: {},
	rating: {}
})
</script>

<template>
	<SimpleTable>
		<table class="min-w-full divide-y divide-gray-300">
			<thead class="bg-gray-50">
			<tr>
				<TableHeading :first="true">Agent</TableHeading>
				<TableHeading>Commentaire</TableHeading>
				<TableHeading>Date de validation</TableHeading>
			</tr>
			</thead>
			<tbody class="divide-y divide-gray-200 bg-white">
			<tr v-for="validator in validators" :key="validator.rating_validator_id">
				<TableData :first="true" class="flex items-start gap-x-2">
					<p class="text-base leading-6 text-gray-900">{{ validator.user.user_display_name }}</p>
					<p v-if="validator.validator_id === rating.evaluated_id"
					   class=" text-white bg-gray-500 ring-gray-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
						Évalué
					</p>
					<p v-if="validator.validator_id === rating.evaluator_id"
					   class=" text-white bg-gray-500 ring-gray-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
						Évaluateur
					</p>
				</TableData>
				<TableData class="whitespace-pre-line">{{ validator.rating_validator_comment || 'Pas de commentaire.' }}</TableData>
				<TableData class="flex items-start gap-x-3">
					<template v-if="validator.validated_at">
						<p class="text-white bg-green-600 ring-green-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
							Validé le
						</p>
						{{ capitalized(moment(validator.validated_at).format('DD MMMM YYYY á HH:mm')) }}
					</template>
					<p v-else
					   class="text-white bg-red-600 ring-red-600/20 rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium ring-1 ring-inset">
						Non Validé
					</p>
				</TableData>
			</tr>
			</tbody>
		</table>
	</SimpleTable>
</template>

<style scoped>

</style>
