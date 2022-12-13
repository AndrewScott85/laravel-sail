<script setup>
import { ref } from "vue";
import FullScreenphoto from "@/Components/FullScreenPhoto.vue";

const props = defineProps({
    photo: Object,
});

const openingPhotoModal = ref(false);


const closePhotoModal = () => {
    openingPhotoModal.value = false;

};


const openPhotoModal = () => {
    openingPhotoModal.value = true;
};

const photoDate = props.photo.created_at.slice(2, 10).split("-").reverse().join("/");

</script>


<template class="">
    <div class="flex flex-col shadow-lg bg-neutral-800 p-4 w-[22rem] lg:w-96 rounded-sm hover:bg-neutral-900 hover:ring hover:ring-indigo-600/50 ring-offset-4 ring-offset-black cursor-pointer"
        @click="openPhotoModal">
        <div class="flex justify-between items-center text-white font-base">
            <h3 class="text-lg font-bold self-start hover:underline">{{ photo.title }}</h3>
            <p class="text-base self-end">{{ photoDate }}</p>
        </div>
        <div class="h-60 mt-4 rounded-sm flex justify-center ">
            <img class="" :src="'/storage/' + photo.path" alt="" />
        </div>
        <div v-if="photo.description.length > 185" class="text-white text-base  px-2 py-4 h-32">
            <p>{{ photo.description.slice(0, 185) + "...." }}</p>
        </div>
        <div v-else class="text-white text-base  px-2 py-4 h-32">{{ photo.description }}</div>
    </div>

    <FullScreenphoto :show="openingPhotoModal" @close="closePhotoModal">
        <template #content>
            <div class="flex flex-col bg-auto gap-4" @click="closePhotoModal">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <h2 class="order-last md:order-first font-bold text-left pl-2 md:text-2xl md:pl-10">{{ photo.title}}</h2>
                    <h3 class="text-right p-2 md:text-xl md:p-6">{{ photoDate }}</h3>
                </div>
                <div class="flex justify-center">
                    <img class="object-scale-down py-6 px-4" :src="'/storage/' + photo.path" alt=""/>
                </div>
                <div class="max-w-7xl mx-auto">
                    <p class="whitespace-pre-line md:text-xl px-4 pb-4 text-left">{{ photo.description }}</p>
                </div>
            </div>
        </template>
    </FullScreenphoto>
</template>
