<script setup>
import { ref } from "vue";
import FullScreenphoto from "@/Components/FullScreenPhoto.vue";
import { Link } from "@inertiajs/inertia-vue3";

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
    <div class="flex flex-col shadow-lg bg-neutral-800 p-4 w-[22rem] lg:w-96 rounded-sm hover:bg-neutral-900 hover:ring hover:ring-indigo-600/50 ring-offset-4 ring-offset-black">
        <div class="flex justify-end pb-2"> 
        <Link class="hover:underline underline-offset-4" :href="'/user/' + photo.user.id + '/posts'">
        <div class="flex items-center">
            <img class="h-4 rounded-full mr-2" :src="photo.user.profile_photo_url" alt="">
            <p class="text-white hover:underline underline-offset-4">{{ photo.user.name }}</p>
        </div>
        </Link>
    </div>
        <div class="flex justify-between items-center text-white font-base">
            <h3 class="cursor-pointer text-lg font-bold self-start hover:underline underline-offset-2" @click="openPhotoModal">{{ photo.title }}</h3>
            <p class="text-base self-end">{{ photoDate }}</p>
        </div>
        <div class="h-60 mt-4 rounded-sm flex justify-center ">
            <img class="cursor-pointer" :src="photo.path" alt="" @click="openPhotoModal"/>
        </div>
        <p class="pt-4 px-2 font-semibold text-white">Created using: <Link v-if="!$page.props.singleAi" class="font-bold underline" :href="route('aiservice', photo.ai_service.id)">{{photo.ai_service.name }}</Link><span v-else> {{ photo.ai_service.name }}</span></p>
        <div v-if="photo.description.length > 185" class="text-white text-base  px-2 py-4 h-32 cursor-pointer" @click="openPhotoModal">
            <p>{{ photo.description.slice(0, 185) + "...." }}</p>
        </div>
        <div v-else class="text-white text-base  px-2 py-4 h-32 cursor-pointer" @click="openPhotoModal">{{ photo.description }}</div>
</div>

    <FullScreenphoto :show="openingPhotoModal" @close="closePhotoModal">
        <template #content>
            <div class="flex flex-col bg-auto gap-4">
                <div class="flex justify-end">
                    <button class="outline outline-gray-800 rounded-full text-white text-lg mt-4 mr-4 py-2 px-4 hover:text-red-600 hover:outline-red-600" @click="closePhotoModal">X</button>
                </div>
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <h2 class="order-last md:order-first font-bold text-left pl-2 md:text-2xl md:pl-10">{{ photo.title}}</h2>
                    <h3 class="text-right p-2 md:text-xl md:p-6">{{ photoDate }}</h3>
                </div>
                <div class="flex justify-center">
                    <img class="object-scale-down py-6 px-4" :src="photo.path" :alt="'Image for post: ' + photo.title"/>
                </div>
                <div class="max-w-7xl mx-auto">
                    <p class="whitespace-pre-line md:text-xl px-4 pb-4 text-left">{{ photo.description }}</p>
                </div>
            </div>
        </template>
    </FullScreenphoto>
</template>
