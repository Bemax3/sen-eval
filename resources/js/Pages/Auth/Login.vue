<script setup>

import TextInput from "@/Components/Forms/TextInput.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import SubmitButton from "@/Components/Forms/SubmitButton.vue";
import InputError from "@/Components/Forms/InputError.vue";
import {useForm} from "@inertiajs/vue3";


const form = useForm({
    user_login: '',
    password: ''
});
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 ">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl ">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2 flex items-center justify-center">
                    <img aria-hidden="true" class="object-cover w-30 h-30 alt=Office" src="../../assets/logo1637145113.png">
                </div>
                <div class="flex items-center justify-center flex-col p-6 sm:p-12 md:w-1/2">
                    <h1 class="mb-2 font-semibold text-xl text-gray-700">
                        Se connecter
                    </h1>
                    <div class="w-full">
                        <form class="mb-0 space-y-6" @submit.prevent="submit">
                            <div>
                                <InputLabel for="login">Login</InputLabel>
                                <div class="mt-1">
                                    <TextInput v-model="form.user_login" :invalid="form.errors.user_login !== undefined" id="user_login" placeholder="Login"  autofocus />
                                </div>
                                <InputError :message="form.errors.user_login" />
                            </div>
                            <div>
                                <InputLabel for="login">Mot de Passe</InputLabel>
                                <div class="mt-1">
                                    <TextInput v-model="form.password" :invalid="form.errors.password !== undefined" id="password" type="password" placeholder="********"  />
                                </div>
                                <InputError :message="form.errors.password" />
                            </div>
                            <hr class="my-8">
                            <button :disabled="form.processing" class="block w-full px-4 py-2 mt-4 text-lg font-medium leading-5 text-center text-white transition-colors duration-150 bg-cyan-600 border border-transparent rounded-lg active:bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:shadow-outline-purple">
                                Connexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
