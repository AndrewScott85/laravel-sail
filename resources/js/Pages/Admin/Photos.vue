<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

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
                    <Link class="flex items-center px-1 bg-sky-600 text-white rounded-md" :href="route('admin.photos.create')">Create New</Link>
                </div>
                    <div class="flex flex-col">
                        <div class="my-2 overflow-x-auto">
                    <table class="min-w-full divide-y">
                        <thead class="text-xs font-semibold uppercase">
                            <tr>
                                <th scope="col" >ID</th>
                                <th scope="col">Photo</th>
                                <th scope="col" class="p-2 ">Description</th>
                                <th scope="col" class="relative">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="photo in photos">
                            <td class="px-4">{{photo.id}}</td>
                            <td><img width="100" :src=" '/storage/' + photo.path" alt=""></td>
                            <td class="px-4 py-4 ">{{photo.description.slice(0,100) + "..."}}</td>
                            <td class="px-4 flex align-bottom">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-1 py-1 rounded">
                                    View
                                </button>
                                <Link class="bg-green-600 hover:bg-green-700 text-white font-bold px-1 py-1 rounded"
                                :href="route('admin.photos.edit', photo.id)">
                                    Edit
                            </Link>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold px-1 py-1 rounded">
                                    Delete
                                </button>
                            
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                </div>

                    <!-- <table>
                        <template #header>  
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </template>
                        <template #body> 
                            <tr v-for="photo in photos"></tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{photo.id}}</td>
                            <td class="px-6 py-4"><img :src="photo.path" alt=""></td>
                            <td class="px-6 py-4">
                            <div class="text-sm text-gray-500">{{photo.description.slice(0,100) + '...'}}</div>
                        </td>
                        </template>
                    </table> -->
                </div>
            </div>
       
    </AppLayout>
</template>
