<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import FullScreenphoto from "@/Components/FullScreenPhoto.vue";
import { Inertia } from "@inertiajs/inertia";

const openingPhotoModal = ref(false);


const closePhotoModal = () => {
    openingPhotoModal.value = false;

};


const openPhotoModal = () => {
    openingPhotoModal.value = true;
};

const props = defineProps({
    moderation: Object,
    description: Object,
    image: Object,
    flagged: Object,
    title: String,
});

const form = useForm({
    prompt: null,
    title: '',
    style: null,
});

const usePost = () => {

    let url = props.image.data[0].url;
    const regex = /img-(.*)\.png/;
    const result = url.match(regex);
    const filename = result[0];

    Inertia.post(route('user.openai.store'), {
        _method: "POST",
        url: props.image.data[0].url,
        name: filename,
        description: props.description.choices[0].text,
        title: props.title,
        ai_service_id: 2,
    });
};

let postTitle = props.title;

const updateTitle = (event) => {
      postTitle = event.target.value
    }

let editTitle = ref(false);
let editImage = ref(false);
let editDescription = ref(false);

const countdown = () => {
    return 30 - form.title.length;
}

const countdownStyle = () => {
    return 30 - form.title.length;
}

</script>

<template>
    <AppLayout title="Edit Photo">
        <template #header>
            <h2 class="font-semibold text-3xl leading-tight">
                Review and Edit Your Creation
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <!-- <p class="text-red-600 text-lg px-4 lg:px-8 pb-4 font-bold"
                v-if="$page.props.user.id == 1 || $page.props.user.id == 2">Please Note: The Demo Account is for UI
                demonstration: Creation, Editing, & Deletion are disabled on this account</p> -->


            <div class="flex flex-col px-4">
                <div v-if="flagged">
                    <p>{{ flagged }}</p>
                </div>
                <h2 class="text-xl text-center">{{ postTitle }}</h2>

                <div v-if="image.data">
                    <img id="image" class="h-72 w-auto" :src="image.data[0].url" alt="" @click="openPhotoModal">
                </div>
                <div v-if="description.choices">
                    <p class="whitespace-pre">{{ description.choices[0].text }}</p>
                </div>
                <div v-else>{{ description }}</div>
            </div>

                <div class="sm:px-4 lg:px-8 mt-5 md:col-span-2 md:mt-0">
                    <div class="flex p-4 gap-4">
                    <button class="ring-2 ring-white p-2" @click="editTitle=!editTitle"> {{ editTitle ? 'Cancel' : 'Edit Title' }}</button>
                    <button class="ring-2 ring-white p-2" @click="editImage=!editImage">{{ editImage ? 'Cancel' : 'Edit Image' }}</button>
                    <button class="ring-2 ring-white p-2" @click="editDescription=!editDescription">{{ editDescription ? 'Cancel' : 'Edit Description' }}</button>
                </div>
                    
                    <div v-if="editTitle">
                        <label for="title" class="block text-m font-bold">New Title (max 30
                            characters)</label>
                        <div class="m-1">
                            <input id="title" name="title" maxlength="30"
                                class="py-1 px-2 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                v-model="postTitle" @input="updateTitle" v-on:keydown="countdown" />
                            <p class="pt-2">Characters remaining: <countdown></countdown>
                            </p>
                        </div>
                        <div class="text-red-600" v-if="form.errors.title">{{ form.errors.title }}</div>
                    </div>


                    
                    <div v-if="editImage">
                        <label for="prompt" class="block text-m font-bold text-white pt-8"> Describe what you want
                            to see here!</label>
                        <div class="mt-1">
                            <textarea id="prompt" name="prompt" rows="3" v-on:click="form.clearErrors('prompt')"
                                class="mt-1 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                v-model="form.prompt"></textarea>
                        </div>
                        <div class="text-red-600" v-if="form.errors.prompt">{{ form.errors.prompt }}</div>
                    </div>

                    
                    <div v-if="editDescription">
                        <label for="title" class="block text-m font-bold">Writing style (max 30
                            characters)</label>
                        <div class="m-1">
                            <input id="style" name="style" maxlength="30" v-on:click="form.clearErrors('style')"
                                class="py-1 px-2 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                v-model="form.style" v-on:keydown="countdownStyle" />
                            <p class="pt-2">Characters remaining: <countdownStyle></countdownStyle>
                            </p>
                        </div>
                    <div class="text-red-600" v-if="form.errors.style">{{ form.errors.style }}</div>
                </div>
            </div>


                <div class="pt-6 flex justify-end gap-4 px-4">
                    <div v-show="form.processing" class="text-sm text-gray-100">
                        Saving.... This can take a while, please be patient!
                    </div>
                    <div v-if="form.processing"></div>

                </div>
          
        </div>
        <Link
            class="text-gray-500  ring-2 ring-gray-500 hover:bg-gray-600 hover:text-white font-bold px-4 py-2 rounded-md"
            :href="route('user.manageposts')">
        Cancel
        </Link>
        <div>
            <button class="m-4 bg-emerald-600 p-2 ring-2 ring-white" @click="usePost">Use this photo</button>
            <!-- <form @submit.prevent="saveForm.post(route('user.photos.store'))">
                        
                        <button type="submit"  :disabled="saveForm.processing"
                    class="inline-flex justify-center rounded-md border border-transparent ring-2 ring-emerald-600 text-emerald-600 py-2 px-4 font-bold hover:text-white shadow-sm hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Save Post
                </button>
                <div class="text-red-600" v-if="form.errors">{{ form.errors }}</div>
            </form> -->

        </div>

    </AppLayout>
    <FullScreenphoto :show="openingPhotoModal" @close="closePhotoModal">
        <template #content>
            <div class="flex flex-col bg-auto gap-4">
                <div class="flex justify-end">
                    <button
                        class="outline outline-gray-800 rounded-full text-white text-lg mt-4 mr-4 py-2 px-4 hover:text-red-600 hover:outline-red-600"
                        @click="closePhotoModal">X</button>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-bold text-2xl pl-4">{{ title }}</div>
                    <img class="object-scale-down py-6 px-4" :src="image.data[0].url" alt="" />
                </div>
                <div class="max-w-7xl mx-auto">
                    <p class="whitespace-pre-line md:text-xl px-4 pb-4 text-left">{{ description.choices[0].text }}</p>
                </div>
            </div>
        </template>
    </FullScreenphoto>
</template>
