<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import CardViewOnly from "../../Components/CardViewOnly.vue";
import ApplicationMark from '@/Components/ApplicationMark.vue';


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Array,
});
</script>

<template>

    <Head v-if="!$page.props.user" title="Posts" />
    <AppLayout v-else title="Posts">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-3xl text-gray-100 leading-tight">
                    Posts
                </h2>
            </div>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-black">
            <div v-if="!photos">Nothing to display yet!</div>
        <section class="photos">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-4 justify-items-center">
                <div class="my-2 flex flex-1" v-for="photo in photos" :key="photo.id">
                    <CardViewOnly :photo="photo"></CardViewOnly>
                </div>
            </div>
        </section>

    </div>

    </AppLayout>

    <div v-if="!$page.props.user" class="bg-black min-h-screen">
    <header class="bg-black shadow py-2 border-b border-gray-100">
        
        <div class="max-w-7xl flex mx-auto items-center py-6 sm:px-6 lg:px-8 bg-black">
            
            <ApplicationMark class="block h-14 w-auto pr-4" /> 
            <h1 class="text-4xl text-gray-100 grow">GALÈRE.AI</h1>
            
            <div v-if="canLogin" class="sm:block">
                <Link v-if="!$page.props.user" :href="route('login')"
                    class="text-sm text-gray-100 underline">Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ml-4 text-sm text-gray-100  underline">Register</Link>

            </div>
            
        </div>
        <div class="max-w-7xl mx-auto text-white sm:px-6 lg:px-8 pb-2">
        <p class="">A blog demo with content created using generative AI.</p>
            <p>Images made using <a class="font-bold" href="https://midjourney.com/home/?callbackUrl=%2Fapp%2F">Midjourney</a> and <a class="font-bold" href="https://creator.nightcafe.studio/">nightcafe</a>,
            with descriptions and titles written by <a class="font-bold" href="https://chat.openai.com/chat">ChatGPT</a>. </p>
            <p class="mt-2"><Link class="font-bold text-xl underline" href="route('login')">Login</Link> to checkout the user interface! (Details provided on Login page)</p>
        </div>
    </header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-black">
        <div class="flex flex-col justify-center pt-8 sm:justify-start">
            <h2 class="font-semibold text-3xl text-gray-100 leading-tight pb-6">Posts</h2>
        </div>
        <section class="photos">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-4 justify-items-center">
                <div class="my-2 flex flex-1" v-for="photo in photos" :key="photo.id">
                    <CardViewOnly :photo="photo"></CardViewOnly>
                </div>
            </div>
        </section>

    </div>
</div>
</template>

