<script setup>

import TextInput from "@/Components/Forms/TextInput.vue";
import InputLabel from "@/Components/Forms/InputLabel.vue";
import InputError from "@/Components/Forms/InputError.vue";
import {useForm} from "@inertiajs/vue3";

const form = useForm({
    user_login: '',
    password: '',
    remember: false,
});
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-dark-gray">
        <div class="flex-1 h-full max-w-xl mx-auto overflow-hidden bg-white dark:bg-grayish rounded-2xl shadow-xl">
            <div class="flex flex-col items-center justify-center bg-cyan-600 ">
                <div class="h-20 md:h-auto md:w-1/3 flex items-center justify-center md:p-2 p-20">
                    <img alt="" aria-hidden="true" class="object-cover sm:w-30 sm:h-30 alt=Office" src="../../assets/logo1637145113.png">
                </div>
                <div class="flex items-center justify-center flex-col p-10 md:p-8 w-full rounded-b-2xl bg-white dark:bg-grayish">
                    <h1 class="mb-4 font-bold text-3xl text-cyan-700">
                        Système d'Évaluation
                    </h1>
                    <!--                    <h1 class="mb-2 font-semibold text-xl text-gray-700 dark:text-white">-->
                    <!--                        Se connecter-->
                    <!--                    </h1>-->
                    <div class="w-full mt-4 sm:px-12">
                        <form class="mb-0 space-y-4" @submit.prevent="submit">
                            <div>
                                <InputLabel for="login">Login</InputLabel>
                                <div class="mt-2">
                                    <TextInput id="user_login" v-model="form.user_login" :invalid="form.errors.user_login !== undefined" autofocus class="h-12"
                                               placeholder="Login"/>
                                </div>
                                <InputError :message="form.errors.user_login"/>
                            </div>
                            <div>
                                <InputLabel for="login">Mot de Passe</InputLabel>
                                <div class="mt-2">
                                    <TextInput id="password" v-model="form.password" :invalid="form.errors.password !== undefined" class="h-12" placeholder="********"
                                               type="password"/>
                                </div>
                                <InputError :message="form.errors.password"/>
                            </div>
                            <div class=" mt-3 flex items-center">
                                <input id="remember-n1" v-model="form.remember" class="h-4 w-4 rounded border-gray-300 text-cyan-600 focus:ring-cyan-700"
                                       name="remember-n1"
                                       type="checkbox"/>
                                <label class="ml-3 block text-sm leading-6 text-gray-900 dark:text-white" for="remember-n1">Se souvenir de moi</label>
                            </div>
                            <hr class="my-8">
                            <button :disabled="form.processing"
                                    class="block h-12 w-full px-4 py-2 mt-4 text-lg font-medium leading-5 text-center text-white transition-colors duration-150 bg-cyan-600  border border-transparent rounded-lg active:bg-cyan-600  hover:bg-cyan-700     focus:outline-none focus:shadow-outline-cyan">
                                Connexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
