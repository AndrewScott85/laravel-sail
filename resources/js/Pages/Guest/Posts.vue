<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import CardViewOnly from "../../Components/CardViewOnly.vue";


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Array,
});
</script>

<template>

    <Head v-if="!$page.props.user" title="Posts" />
    <AppLayout v-else title="Photos">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                    Posts
                </h2>
                <Link
                    class="py-2 px-4 bg-indigo-700 text-white text-4xl font-bold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    :href="route('admin.photos.create')">+</Link>
            </div>
        </template>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

        </div>
    </AppLayout>
    <div class="relative flex items-top justify-center bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</Link>

            <Link v-if="canRegister" :href="route('register')"
                class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</Link>

        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col justify-center pt-8 sm:justify-start">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight pb-6">Posts</h2>
        </div>
        <section class="photos">
            <div class="grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-4 justify-items-center">
                <div class="my-2 flex flex-1" v-for="photo in photos" :key="photo.id">
                    <CardViewOnly :photo="photo"></CardViewOnly>
                </div>
            </div>
        </section>

    </div>

</template>

