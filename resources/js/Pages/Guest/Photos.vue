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
    <Head title="Photos" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
    >
        <div
            v-if="canLogin"
            class="hidden fixed top-0 right-0 px-6 py-4 sm:block"
        >
            <Link
                v-if="$page.props.user"
                :href="route('admin.dashboard')"
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

        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col justify-center pt-8 sm:justify-start">
           <h1>Photos</h1>
           <section class="photos">
            <div class="grid sm:grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
            <div class="my-2" v-for="photo in photos" :key="photo.id">
                          <CardViewOnly :photo="photo"></CardViewOnly>     
                </div>
            </div>
        </section>
            </div>

        </div>
    </div>
</template>
