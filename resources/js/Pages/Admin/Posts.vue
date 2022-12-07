<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import CardEditable from '../../Components/CardEditable.vue';


defineProps({
    photos: Array,
});

</script>

<template>
    <AppLayout title="Photos">
        <template #header>
            <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
                Posts
            </h2>
                </div>
                </template>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- All posts go here -->
                <div class="flex justify-between mx-2 my-4">
                    <h2 class="text-2xl font-bold py-2">All Posts</h2>
                    <Link
                        class="py-2 px-4 bg-indigo-700 text-white text-4xl font-bold rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        :href="route('admin.photos.create')"
                        >+</Link
                    >
                </div>
                <div class="grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 3xl:grid-cols-4 gap-4 justify-items-center">
                <div class="m-2 flex flex-1" v-for="photo in photos" :key="photo.id">
                          <CardEditable :photo="photo"></CardEditable>     
                </div>
            </div>
            </div>
        </div>
    </AppLayout>
</template>
