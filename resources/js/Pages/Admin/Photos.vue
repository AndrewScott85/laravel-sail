<script setup>
import { ref } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import DialogModal from '@/Components/DialogModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Card from '../../Components/App/Card.vue';


defineProps({
    photos: Array,
});

</script>

<template>
    <AppLayout title="Photos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Photos
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- All posts go here -->
                <div class="flex justify-between mb-4">
                    <h2 class="text-2xl font-bold py-2">Photos</h2>
                    <Link
                        class="flex items-center px-1 bg-sky-600 text-white rounded-md"
                        :href="route('admin.photos.create')"
                        >Create New</Link
                    >
                </div>
                <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 sm:gap-4 lg:gap-8">
                <div v-for="photo in photos">
                          <Card :photo="photo"></Card>     
                </div>
            </div>
            </div>
        </div>
    </AppLayout>
</template>
