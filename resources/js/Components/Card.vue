<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import FullScreenphoto from "@/Components/FullScreenPhoto.vue";

defineProps({
    photo: Object,
});

const form = useForm({
    _method: "DELETE",
});

const confirmingPhotoDeletion = ref(false);
const openingPhotoModal = ref(false);

const closeModal = () => {
    confirmingPhotoDeletion.value = false;

    form.reset();
};

const closePhotoModal = () => {
    openingPhotoModal.value = false;

};

const confirmPhotoDeletion = () => {
    confirmingPhotoDeletion.value = true;
};

const deletePhoto = (photo) => {
    form.delete(route("admin.photos.delete", photo.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });

};

const openPhotoModal = () => {
    openingPhotoModal.value = true;
};

</script>

<template>
    <div class="flex flex-col shadow-lg bg-black">
        <img class=" h-60 object-contain py-4" :src="'/storage/' + photo.path" alt="" />
            <div class="text-white text-base  px-2 py-2 h-32 overflow-hidden">{{ photo.description }}</div>
        <div class="flex items-center justify-center">
            <button @click="openPhotoModal"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-1 py-1 rounded">
                View
            </button>
            <Link
                class="bg-green-600 hover:bg-green-700 text-white font-bold px-1 py-1 rounded"
                :href="route('admin.photos.edit', photo.id)"
            >
                Edit
            </Link>
            <DangerButton @click="confirmPhotoDeletion"> Delete </DangerButton>
        </div>
    </div>
    <DialogModal :show="confirmingPhotoDeletion" @close="closeModal">
                <template #title>
                    <div class="font-bold bg-gray-100">
                        <p class="px-4 py-4"> Are you sure you want to delete this photo?</p>
                        </div>
                </template>
                <template #content>
                    <div class="flex flex-col items-center gap-4 py-4 mx-20 bg-slate-900">
                        <img class="h-48 px-4" :src="'/storage/' + photo.path" alt="" />
                        <p class="text-lg text-white">{{ photo.description.slice(0, 50) + "..." }}</p>

                    </div>
                </template>
                <template #footer>
                    <button @click="closeModal" class="px-4 py-2 bg-gray-600">
                        Cancel
                    </button>
                    <DangerButton @click="deletePhoto(photo)"
                        >Delete</DangerButton
                    >
                </template>
    </DialogModal>
    <FullScreenphoto :show="openingPhotoModal" @close="closePhotoModal">
        
        <template #content>
                    <div class="flex flex-col gap-4">
                        <img class="" :src="'/storage/' + photo.path" alt="" @click="closePhotoModal"/>
                        <p class="text-lg">{{ photo.description}}</p>
                    </div>
                </template>
    </FullScreenphoto>
</template>
