<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import CardViewOnly from "../../Components/CardViewOnly.vue";


defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    photos: Array,
});
</script>

<template>
    <Head title="Posts" />

    <div
        class="relative flex items-top justify-center bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
    >
        <div
            v-if="canLogin"
            class="hidden fixed top-0 right-0 px-6 py-4 sm:block"
        >
            <Link
                v-if="$page.props.user"
                :href="route('admin.posts')"
                class="text-sm text-gray-700 dark:text-gray-500 underline"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-700 dark:text-gray-500 underline"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                    >Register</Link
                >
            </template>
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
