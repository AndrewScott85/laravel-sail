<script setup>
import { ref } from 'vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import DialogModal from '@/Components/DialogModal.vue';
import DangerButton from '@/Components/DangerButton.vue';


defineProps({
    photos: Array,
});

const form = useForm({
    _method: "DELETE",
});

const confirmingPhotoDeletion = ref(false);

const closeModal = () => {
    confirmingPhotoDeletion.value = false;

    form.reset();
};

const confirmPhotoDeletion = () => {
    confirmingPhotoDeletion.value = true;
};

const deletePhoto = (photo) => {
    form.delete(route('admin.photos.delete', photo.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

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
                <div class="flex flex-col">
                    <div class="my-2 overflow-x-auto">
                        <table class="min-w-full divide-y">
                            <thead class="text-xs font-semibold uppercase">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col" class="p-2">Description</th>
                                    <th scope="col" class="relative">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="photo in photos">
                                    <td class="px-4">{{ photo.id }}</td>
                                    <td>
                                        <img
                                            width="100"
                                            :src="'/storage/' + photo.path"
                                            alt=""
                                        />
                                    </td>
                                    <td class="px-4 py-4">
                                        {{
                                            photo.description.slice(0, 100) +
                                            "..."
                                        }}
                                    </td>
                                    <td class="px-4 flex align-bottom">
                                        <button
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-1 py-1 rounded"
                                        >
                                            View
                                        </button>
                                        <Link
                                            class="bg-green-600 hover:bg-green-700 text-white font-bold px-1 py-1 rounded"
                                            :href="
                                                route(
                                                    'admin.photos.edit',
                                                    photo.id
                                                )
                                            "
                                        >
                                            Edit
                                        </Link>
                                        <DangerButton @click="confirmPhotoDeletion">
                    Delete
                </DangerButton>
                                        <DialogModal
                                            :show="confirmingPhotoDeletion"
                                            @close="closeModal"
                                        >
                                            <template #title>
                                                Delete {{photo.description.slice(0,20) + '...'}}
                                            </template>
                                            <template #content>
                                                <div>Are you sure you want to delete this photo?</div>
                                            </template>
                                                <template #footer>
                                                <button @click="closeModal" class="px-4 py-2 bg-gray-600">Cancel</button>
                                            <DangerButton @click="deletePhoto(photo)">Delete</DangerButton>
                                        </template>
                                    
                                        </DialogModal>

                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
