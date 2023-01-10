<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import CardViewOnly from "../../Components/CardViewOnly.vue";
import ApplicationMark from '@/Components/ApplicationMark.vue';


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Array,
    singleUser: Boolean
});
</script>

<template>

    <Head v-if="!$page.props.user" title="Posts" />
    <AppLayout v-else title="Posts">
        <template #header>
                <div class="flex flex-col items-center pt-4" v-if="singleUser">
                <Link class="self-start rounded-md text-2xl text-bold text-indigo-600 ring-1 ring-indigo-600 p-2" :href="route('allposts')">&lt All Posts</Link>
                <h2 class="font-semibold text-3xl text-gray-100 pt-10" v-if="$page.props.user.id == photos[0].user.id">Your Posts</h2>
                <h2 class="font-semibold text-3xl text-gray-100 pt-10" v-else>{{ photos[0].user.name }}'s Posts</h2>
                </div>
                <div class="flex flex-col items-center" v-else>
                <h2 class="font-semibold text-3xl text-gray-100">
                  All Posts
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
    <header class="bg-black flex flex-col items-center shadow pt-2 pb-6 border-b border-indigo-600">
        
        <div class="max-w-7xl flex items-center py-6 sm:px-6 lg:px-8 bg-black">
            <ApplicationMark class="h-14 w-auto pr-4" /> 
            <h1 class="text-4xl text-gray-100 grow">GALÈRE.AI</h1>
        </div>
            <div v-if="canLogin" class="sm:block absolute top-4 right-4">
                <Link v-if="!$page.props.user" :href="route('login')"
                    class="text-sm text-gray-100 underline">Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ml-4 text-sm text-gray-100  underline">Register</Link>

            </div>
            
        <div class="max-w-7xl flex flex-col self-start items-start px-2 text-white sm:px-6 lg:px-8 pb-2">
        <p class="">A blogging site with demo content created using generative AI.</p>
            <p>Images made using <a class="font-bold" href="https://midjourney.com/home/?callbackUrl=%2Fapp%2F">Midjourney</a> and <a class="font-bold" href="https://creator.nightcafe.studio/">nightcafe</a>,
            with descriptions and titles written by <a class="font-bold" href="https://chat.openai.com/chat">ChatGPT</a>. </p>
            <p class="mt-2"><Link class="font-bold underline" :href="route('register')">Register</Link>
                or <Link class="font-bold underline" :href="route('login')">Login</Link> to checkout the user interface! (Login Details provided on Login page for Demo Account)</p>
        </div>
    </header>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-black">
        <div class="justify-center items-center py-8 sm:justify-start">
            <div class="pt-4 flex flex-col" v-if="singleUser">
                <Link class="mx-2 lg:mx-8 self-start rounded-md text-lg lg:text-2xl text-bold text-white bg-indigo-900 p-2" :href="route('allposts')">&lt All Posts</Link>
                <h2 class="font-semibold self-center text-xl lg:text-3xl text-gray-100 pt-4 lg:pt-0 lg:pb-4">{{ photos[0].user.name }}'s Posts</h2>
                </div>
                <h2 class="font-semibold self-center text-xl lg:text-3xl text-gray-100" v-else>
                  All Posts
                </h2>
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

