<script setup>
import { ref } from "vue";
import FullScreenphoto from "@/Components/FullScreenPhoto.vue";

defineProps({
    photo: Object,
});

const openingPhotoModal = ref(false);

const closeModal = () => {
    confirmingPhotoDeletion.value = false;

    form.reset();
};

const closePhotoModal = () => {
    openingPhotoModal.value = false;

};


const openPhotoModal = () => {
    openingPhotoModal.value = true;
};

</script>


<template>
    <div class="flex flex-col px-4 shadow-lg bg-gray-500 rounded-md">
        <div class="flex justify-between items-center text-white py-4 font-base">
            <p class="text-lg font-bold">{{photo.title}}</p>
            <p>{{photo.created_at.slice(0,10)}}</p>
        </div>
        <img class=" h-60 object-auto p-2" :src="'/storage/' + photo.path" alt="" @click="openPhotoModal"/>
        <div v-if="photo.description.length > 100" class="text-white text-base  px-2 py-2 h-28">
            <p>{{ photo.description.slice(0,100) + "...." }}</p>
        </div>    
        <div v-else class="text-white text-base  px-2 py-4 h-28">{{ photo.description }}</div>
        <div class="flex justify-center py-2">
      <button @click="openPhotoModal"
                class="bg-blue-500 hover:bg-blue-700 mb-4 text-white font-bold px-2 py-1 rounded">
                View Post
            </button>
        </div>
    </div>
   
    <FullScreenphoto :show="openingPhotoModal" @close="closePhotoModal"> 
        <template #content>
                    <div class="flex flex-col bg-auto gap-4" >
                        <h2 class="text-xl font-bold p-4">{{photo.created_at.slice(0,10)}}</h2>
                        <div class="flex justify-center">
                        <img class="object-scale-down  py-6 px-4" :src="'/storage/' + photo.path" alt="" @click="closePhotoModal"/>
                        </div>
                        <div class="flex-auto">
                        <p class="text-lg bg-white px-4 flex-wrap">{{ photo.description}}</p>
                        </div>
                    </div>
                </template>
    </FullScreenphoto>
</template>
