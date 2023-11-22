<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import TextInput from "@/Components/Forms/TextInput.vue";
import TextArea from "@/Components/Forms/TextArea.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import {isEmpty} from "@/helpers/helper.js";
import InputError from "@/Components/Forms/InputError.vue";
import {CheckIcon, ChevronUpDownIcon} from "@heroicons/vue/20/solid/index.js";
import {Listbox, ListboxButton, ListboxOption, ListboxOptions} from "@headlessui/vue";
import Breadcrumbs from "@/Components/Common/Breadcrumbs.vue";
import FormIndications from "@/Components/Forms/FormIndications.vue";
import NumberInput from "@/Components/Forms/NumberInput.vue";
import Switch from "@/Components/Forms/Switch.vue";
import {computed} from "vue";

const props = defineProps({
    skill: {
        type: Object,
        default: {}
    },
    types: {type: Array}
})

const title = computed(() => isEmpty(props.skill) ? 'Nouvelle Compétence' : 'Modifier la Compétence')
const pages = [
    {name: 'Compétences', href: route('skills.index'), current: false},
    {name: isEmpty(props.skill) ? 'Nouveau' : 'Modifier', href: '#', current: true},
]
let form;

const setForm = () => {
    form = useForm((isEmpty(props.skill)) ?
        {
            skill_name: '',
            skill_marking: 5,
            skill_desc: '',
            skill_type_id: props.types[0].skill_type_id,
            skill_is_active: 1
        } :
        {
            skill_name: props.skill.skill_name || '',
            skill_marking: props.skill.skill_marking || 5,
            skill_desc: props.skill.skill_desc || '',
            skill_type_id: props.skill.skill_type_id || props.types[0].skill_type_id,
            skill_is_active: props.skill.skill_is_active
        }
    );
}
const submit = () => {
    if (isEmpty(props.skill))
        form.post(route('skills.store'), {
            onSuccess: () => setForm()
        });
    else
        form.put(route('skills.update', {skill: props.skill.skill_id}), {
            onSuccess: () => setForm()
        });
}

setForm();

</script>
<template>
    <AuthenticatedLayout>
        <Head title="Nouvelle Compétence"/>
        <div class="px-4 sm:px-6 lg:px-8">
            <Breadcrumbs :pages="pages"/>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-2xl font-semibold leading-6 text-gray-900">{{ title }}</h1>
                    <p class="mt-2 text-sm text-gray-700">Ajouter ou modifier une compétence qui sera notée lors de l'évaluation.</p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <form class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2" @submit.prevent="submit">
                    <div class="px-4 py-6 sm:p-8">
                        <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <InputLabel for="name" required>Nom de la compétence</InputLabel>
                                <div class="mt-2">
                                    <TextInput
                                        id="name"
                                        v-model="form.skill_name"
                                        :invalid="form.errors.skill_name !== undefined"
                                        autofocus placeholder="Nom"/>
                                </div>
                                <InputError :message="form.errors.skill_name"/>
                            </div>

                            <div class="sm:col-span-4">
                                <InputLabel for="name" required>Barème</InputLabel>
                                <div class="mt-2">
                                    <NumberInput
                                        id="marking"
                                        v-model="form.skill_marking"
                                        :invalid="form.errors.skill_marking !== undefined"
                                        placeholder="Barème"/>
                                </div>
                                <InputError :message="form.errors.skill_marking"/>
                            </div>

                            <div class="col-span-full">
                                <InputLabel for="description" required>Description</InputLabel>
                                <div class="mt-2">
                                <TextArea
                                    id="description"
                                    v-model="form.skill_desc"
                                    :invalid="form.errors.skill_desc !== undefined"
                                    placeholder="Description"
                                />
                                </div>
                                <InputError :message="form.errors.skill_desc"/>
                                <!--                            <p class="mt-3 text-sm leading-6 text-gray-600">Optionnel</p>-->
                            </div>

                            <div class="sm:col-span-4">
                                <InputLabel>Type</InputLabel>
                                <div class="mt-2">
                                    <Listbox v-model="form.skill_type_id" as="div">
                                        <div class="relative mt-2">
                                            <ListboxButton
                                                class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-s-pink-800 sm:text-sm sm:leading-6">
                                                <span class="block truncate">{{ types.filter((type) => type.skill_type_id === form.skill_type_id)[0].skill_type_name
                                                    }}</span>
                                                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                                <ChevronUpDownIcon aria-hidden="true" class="h-5 w-5 text-gray-400"/>
                                            </span>
                                            </ListboxButton>
                                            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                                                <ListboxOptions
                                                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                                                    <ListboxOption v-for="type in types" :key="type.skill_type_id" v-slot="{ active, selected }"
                                                                   :value="type.skill_type_id"
                                                                   as="template">
                                                        <li :class="[active ? 'bg-s-pink-800  text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                                                            <span :class="[selected ? 'font-semibold' : 'font-normal', 'block truncate']">{{ type.skill_type_name
                                                                }}</span>
                                                            <span v-if="selected"
                                                                  :class="[active ? 'text-white' : 'text-s-pink-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                                                            <CheckIcon aria-hidden="true" class="h-5 w-5"/>
                                                        </span>
                                                        </li>
                                                    </ListboxOption>
                                                </ListboxOptions>
                                            </transition>
                                        </div>
                                    </Listbox>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <div class="mt-2">
                                    <Switch v-model="form.skill_is_active" desc="Sera t-il possible de proposer ou demander ce type de formation lors des évaluations"
                                            label="Actif"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                        <FormIndications/>
                        <SubmitButton :processing="form.processing">
                            Enregistrer
                        </SubmitButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
