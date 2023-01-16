<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import DialogModal from "@/Components/DialogModal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import FullScreenphoto from "@/Components/FullScreenPhoto.vue";

const props = defineProps({
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
    form.delete(route("user.photos.delete", photo.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });

};

const openPhotoModal = () => {
    openingPhotoModal.value = true;
};

const photoDate = props.photo.created_at.slice(2, 10).split("-").reverse().join("/");


</script>


<template>
    <div
        class="flex flex-col shadow-lg bg-neutral-800 p-4 w-[22rem] lg:w-96 rounded-sm hover:bg-neutral-900 hover:ring hover:ring-indigo-600/50 ring-offset-4 ring-offset-black">
        <div class="flex justify-between items-center text-white font-base" @click="openPhotoModal">
            <h3 class="text-lg font-bold self-start cursor-pointer hover:underline">{{ photo.title }}</h3>
            <p class="text-base self-end">{{ photoDate }}</p>
        </div>
        <div class="h-60 mt-4 rounded-sm flex justify-center cursor-pointer" @click="openPhotoModal">
        <img class="" :src="photo.path" alt=""/>
        </div>
        <p class="pt-4 pb-2 font-semibold text-white">Created using: {{photo.ai_service.name }}</p>
        <div v-if="(photo.description.length > 185)" class="text-white text-base px-2 py-2 h-32 cursor-pointer" @click="openPhotoModal">
            <p>{{ photo.description.slice(0, 185) + "...." }}</p>
        </div>
        <div v-else class="text-white text-base  px-2 py-4 h-32 cursor-pointer" @click="openPhotoModal">{{ photo.description }}</div>

        <div class="flex gap-2 justify-center mt-4">
            <Link
                class="inline-flex items-center text-indigo-600 ring-2 ring-indigo-600 hover:bg-indigo-600 hover:text-white font-bold px-16 py-1 rounded-sm"
                :href="route('user.photos.edit', photo.id)">
            EDIT
            </Link>
            <DangerButton class="font-bold rounded-sm" @click="confirmPhotoDeletion"> Delete </DangerButton>
        </div>
    </div>
    <DialogModal :show="confirmingPhotoDeletion" @close="closeModal">
                <template #title>
                    <div class="font-bold">
                        <p class="px-4 py-4"> Are you sure you want to delete this photo?</p>
                        <p v-if="$page.props.user.id == 1 || $page.props.user.id == 2" class="pl-4 text-red-600 text-bold">Please note, Deletion has been disabled on Demo Account</p>
                        </div>
                </template>
                <template #content>
                    <div class="flex flex-col items-center gap-4 p-4 mx-20">
                        <img class="h-48" :src="photo.path" alt="" />
                        <p class="text-lg text-white">{{ photo.description.slice(0, 50) + "..." }}</p>
                    </div>
                </template>
                <template #footer>
                    <div class="pr-4">
                    <button @click="closeModal" class="inline-flex text-sm items-center uppercase px-8 py-2 mr-4 rounded-sm font-bold bg-white text-black">
                        CANCEL
                    </button>
                    <DangerButton  @click="deletePhoto(photo)"
                        >Delete</DangerButton>
                    </div>
                </template>
    </DialogModal>
    <FullScreenphoto :show="openingPhotoModal" @close="closePhotoModal">

        <template #content>
            <div class="flex flex-col bg-auto gap-4">
                <div class="flex justify-end">
                    <button
                        class="bg-black outline outline-gray-800 rounded-full text-white text-lg mt-4 mr-4 py-2 px-4 hover:text-red-600 hover:outline-red-600"

                        @click="closePhotoModal">X</button>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <h2 class="order-last md:order-first font-bold text-left pl-2 md:text-2xl md:pl-10">{{ photo.title }}
                    </h2>
                    <h3 class="text-right p-2 md:text-xl md:p-6">{{ photoDate }}</h3>
                </div>
                <div class="flex justify-center">
                    <img class="object-scale-down  py-6 px-4" :src="photo.path" :alt="'Image for post: ' + photo.title" />
                </div>
                <div class="max-w-7xl mx-auto">
                    <p class="whitespace-pre-line md:text-xl px-4 pb-4 text-left">{{ photo.description }}</p>
                </div>
            </div>
        </template>
    </FullScreenphoto>
</template>
