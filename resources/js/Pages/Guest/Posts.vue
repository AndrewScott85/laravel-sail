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
        <!-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col justify-center pt-8 sm:justify-start">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight pb-6">Posts</h2>
            </div>
            <section class="photos">
                <div
                    class="grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-4 justify-items-center">
                    <div class="my-2 flex flex-1" v-for="photo in photos" :key="photo.id">
                        <CardViewOnly :photo="photo"></CardViewOnly>
                    </div>
                </div>
            </section>

        </div> -->
    </AppLayout>

    <div class="bg-black min-h-screen">
    <header v-if="!$page.props.user" class="bg-black shadow">
        
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-black">
            <ApplicationMark class="block h-14 w-auto" /> 
            <h1 class="text-4xl text-gray-100">GALERE.AI</h1>
            <p class="text-white">Welcome to GALERE.AI, an AI created blog demo with images made with images created using midjourney and nightcafe and descriptions written by chatgpt.</p>
            <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <Link v-if="!$page.props.user" :href="route('login')"
                    class="text-sm text-gray-100 dark:text-gray-500 underline">Log in</Link>

                <Link v-if="canRegister" :href="route('register')"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-100 underline">Register</Link>

            </div>
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

