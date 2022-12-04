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
    form.delete(route("admin.photos.delete", photo.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });

};

const openPhotoModal = () => {
    openingPhotoModal.value = true;
};

const photoDate = props.photo.created_at.slice(2,10).split("-").reverse().join("/");

</script>


<template>
    <div class="flex flex-col shadow-lg bg-gray-500 p-4 w-[22rem] lg:w-96 rounded-sm hover:bg-slate-600 hover:border hover:border-emerald-600">
        <div class="flex justify-between items-center text-white font-base">
            <h3 class="text-lg font-bold self-start cursor-pointer hover:underline" @click="openPhotoModal">{{photo.title}}</h3>
            <p class="text-base self-end">{{photoDate}}</p>
        </div>
        <img class=" h-60 object-contain py-4 cursor-pointer" :src="'/storage/' + photo.path" alt="" @click="openPhotoModal"/>
        <div v-if="photo.description.length > 100" class="text-white text-base px-2 py-2 h-28">
        <p>{{ photo.description.slice(0,100) + "...." }}</p>
    </div>
    <div v-else class="text-white text-base  px-2 py-4 h-28">{{ photo.description }}</div>
        <div class="flex gap-2 justify-center pt-4">
            <Link
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-16 py-1 rounded-sm"
                :href="route('admin.photos.edit', photo.id)"
            >
                EDIT
            </Link>
            <DangerButton class="font-bold rounded-sm" @click="confirmPhotoDeletion"> Delete </DangerButton>
        </div>
    </div>
    <DialogModal :show="confirmingPhotoDeletion" @close="closeModal">
                <template #title>
                    <div class="font-bold bg-gray-100">
                        <p class="px-4 py-4"> Are you sure you want to delete this photo?</p>
                        </div>
                </template>
                <template #content>
                    <div class="flex flex-col items-center gap-4 py-4 mx-20 bg-slate-500">
                        <img class="h-48 px-4" :src="'/storage/' + photo.path" alt="" />
                        <p class="text-lg text-white">{{ photo.description.slice(0, 50) + "..." }}</p>

                    </div>
                </template>
                <template #footer>
                    <button @click="closeModal" class="px-8 py-2 mr-2 text-white font-bold bg-slate-600">
                        Cancel
                    </button>
                    <DangerButton @click="deletePhoto(photo)"
                        >Delete</DangerButton
                    >
                </template>
    </DialogModal>
    <FullScreenphoto :show="openingPhotoModal" @close="closePhotoModal">
        
        <template #content>
                    <div class="flex flex-col bg-auto gap-4" >
                        <div class="flex flex-col md:flex-row items-center justify-between">
                            <h2 class="order-last md:order-first font-bold text-left pl-2 md:text-2xl md:pl-10">{{photo.title}}</h2>
                            <h3 class="text-right p-2 md:text-xl md:p-6">{{photoDate}}</h3>                        
                        </div>
                        <div class="flex justify-center">
                        <img class="object-scale-down  py-6 px-4" :src="'/storage/' + photo.path" alt="" @click="closePhotoModal"/>
                        </div>
                        <div class="flex-auto">
                        <p class="bg-white md:text-xl px-4 pb-4 text-center">{{ photo.description}}</p>
                        </div>
                    </div>
                </template>
    </FullScreenphoto>
</template>
