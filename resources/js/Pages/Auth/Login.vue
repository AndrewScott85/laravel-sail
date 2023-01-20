<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue'; 
import { ref } from 'vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

let errorMsg = ref(null);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const handleError = (error) => {
    console.log(errorMsg);
}

</script>

<template>

    <Head title="Log in" />

    <AuthenticationCard>
        <Link :href="route('register')" class="sm:block absolute top-4 right-4 ml-4 text-sm text-gray-100  underline">Register</Link>
        <template #logo>
            <AuthenticationCardLogo />
            <h1 class="text-4xl text-white font-bold text-center pb-10">GALÈRE.AI</h1>
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <h2 class="text-white font-bold text-xl pb-4">Login with your account details below</h2>
        <form @submit.prevent="submit" class="bg-neutral-800 p-4 rounded-md">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
                    autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-white">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')"
                    class="underline text-sm text-white hover:text-gray-200">
                Forgot your password?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
        <div class="flex flex-col w-full sm:max-w-md px-2 py-4">
        <h2 class="font-bold text-white text-2xl py-4">OR</h2>
            <Link class="self-center bg-orange-600 rounded-md px-4 py-2 text-md text-white font-bold hover:bg-orange-500"
             :href="route('demologin')" method="post" as="button" :onError="handleError">
            <p>LOG IN with Demo Account</p>
            <p>(Reduced functionality)</p>
            </Link>
        </div>

        <div v-if="errorMsg" class="text-2xl text-red-500">{{ errorMsg }}</div>
    </AuthenticationCard>

</template>
