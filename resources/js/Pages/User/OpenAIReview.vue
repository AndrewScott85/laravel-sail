<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref, onMounted, onUnmounted } from "vue";
import FullScreenphoto from "@/Components/FullScreenPhoto.vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

const openingPhotoModal = ref(false);


const closePhotoModal = () => {
    openingPhotoModal.value = false;

};


const openPhotoModal = () => {
    openingPhotoModal.value = true;
};

const form = useForm({
    prompt: null,
    title: '',
    style: null,
});


const props = defineProps({
    description: Object,
    image: Object,
    flagged: Object,
    title: String,
});

const currentProps = ref(props)
const previousProps = JSON.parse(window.sessionStorage.getItem('previousProps'))



const handleUpdate = () => {
    if (props.length != 0) {
  window.sessionStorage.setItem('previousProps', JSON.stringify(currentProps.value))
}
}

onMounted(() => {
  handleUpdate();
  if (previousProps && Object.keys(props).length === 0) {
  props.value = previousProps;
  Object.assign(currentProps.value, previousProps)
}
    console.log('previousProps =')
  console.log(previousProps);
  console.log('Props = :')
  console.log(props.value)
})

// onUnmounted(() => {
//   currentProps.value.$off('update', handleUpdate)
// })


let postTitle = ref(props.title);
let previousTitle = props.title;

const updateTitle = (event) => {
    postTitle = event.target.value
}

let editTitle = ref(false);
let editDescription = ref(false);


const editTitleHandler = () => {
    if (!editTitle.value) {
        previousTitle = postTitle.value;
        editTitle.value = !editTitle.value;
    } else {
        postTitle.value = previousTitle;
        editTitle.value = !editTitle.value
    }
};


const postImage = ref(props.image?.data?.[0]?.url || null);
const postDesc = ref(props.description?.choices?.[0]?.message?.content || null);
const imgName = ref(props.image?.data?.[0]?.url.match(/img-(.*)\.png/)?.[0] || null);

let instruction = '';
let updatedDesc = ref(null);
let originalDesc = ref(false);

let updatedImage = ref(null);
let originalImage = ref(false);

const editImageForm = useForm({
    url: postImage,
    prompt: null,
    name: imgName
});

const updateInstruction = (event) => {
    instruction = event.target.value
}

const editDesc = () => {
    axios.post(route('user.openai.editDescription'), {
        text: postDesc.value,
        instruction: instruction,
    }).then(response => {
        postDesc.value = response.data.newDesc;
        updatedDesc.value = response.data.newDesc;
        originalDesc.value = false;
        editDescription = ref(false);
        instruction = '';

    }).catch(error => {
        console.log('oopsydoodle - something went wrong')
    })
};

const switchDesc = () => {
    if (postDesc.value == props.description.choices[0].text) {
        postDesc.value = updatedDesc.value;
        originalDesc.value = false;
    }
    else {
        postDesc.value = props.description.choices[0].text
        originalDesc.value = true;
    }
}

const variationImage = () => {
    axios.post(route('user.openai.variationImage'), {
        url: postImage.value
    }).then(response => {
        postImage.value = response.data.newImage;
        updatedImage.value = response.data.newImage;
    });
}

const switchImage = () => {
    if (postImage.value == props.image.data[0].url) {
        postImage.value = updatedImage.value;
        originalImage.value = false;
    }
    else {
        postImage.value = props.image.data[0].url
        originalImage.value = true;
    }
}

const saveNewTitle = () => {
    editTitle.value = !editTitle.value
};

const countdown = () => {
    return 30 - postTitle.value.length;
}

const usePost = () => {

    let url = props.image.data[0].url;
    const regex = /img-(.*)\.png/;
    const result = url.match(regex);
    const filename = result[0];

    Inertia.post(route('user.openai.store'), {
        url: props.image.data[0].url,
        name: filename,
        description: props.description.choices[0].text,
        title: props.title,
        ai_service_id: 2,
    });
};

</script>

<template>
    <AppLayout title="OpenAI Review">
        <template #header>
            <h2 class="font-semibold text-3xl leading-tight">
                Review and Edit Your Creation
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <!-- <p class="text-red-600 text-lg px-4 lg:px-8 pb-4 font-bold"
                    v-if="$page.props.user.id == 1 || $page.props.user.id == 2">Please Note: The Demo Account is for UI
                    demonstration: Creation, Editing, & Deletion are disabled on this account</p> -->
            <div class="flex flex-col px-4 gap-4 items-center">
                <div v-if="flagged">
                    <p>{{ flagged }}</p>
                </div>
                <div v-if="editTitle">
                    <!-- <label for="title" class="block text-m font-bold">New Title (max 30
                        characters)</label> -->
                    <div class="m-1">
                        <div class="flex gap-2">
                        <input id="title" name="title" maxlength="30"
                            class="py-1 px-2 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                            v-model="postTitle" @keyup="updateTitle, countdown" />
                            <button class="my-2 ring-2 text-emerald-600 ring-emerald-600 p-2" @click="saveNewTitle">&#10004</button>
                            <button class="ring-2 ring-red-600 text-red-600 px-2 my-2" @click="editTitleHandler">X</button>
                        </div>
                        <p class="pt-2">Characters remaining: <countdown></countdown>
                        </p>   
                    </div>
                </div>
                <div v-else class="self-stretch grid grid-cols-5">
                <h2 class="text-2xl col-start-2 col-end-5 text-center" >{{ postTitle }} </h2>
                <button class="ring-2 ring-white px-2 my-2 col-start-5 justify-self-start" @click="editTitleHandler">Edit</button>
            </div>
                <div v-if="postImage" class="flex flex-col gap-4">
                    <img id="postImage" class="h-80 w-auto" :src="postImage" alt="" @click="openPhotoModal">
                    {{  }}
                </div>
                <div v-else class="text-white">Uh-Oh! It Looks like something went wrong with the image generation, please try again!</div>
                <div v-if="postDesc" class="">
                    <p class="whitespace-pre-wrap">{{ postDesc }}</p>
                </div>
                <div v-else>Uh-Oh! It Looks like something went wrong with the description, please try again!</div>
            </div>

            <div class="sm:px-4 lg:px-8 mt-5 md:col-span-2 md:mt-0">
                <div class="flex flex-col p-4 gap-4">
                    
                    <div v-if="postImage" class="flex gap-4">
                    <button class="ring-2 text-indigo-600 ring-indigo-600 p-2" @click="variationImage">Variation of this Image?</button>
                    <button v-if="updatedImage" class="ring-2 ring-white p-2" @click="switchImage">{{ originalImage ? 'Updated Image >' : '< Original Image' }}</button>
                    </div>
                    <button class="ring-2 ring-white p-2" @click="editDescription = !editDescription">{{ editDescription ? 'Cancel' : 'Edit Description' }}</button>
                    <button v-if="updatedDesc" class="ring-2 ring-white p-2" @click="switchDesc">{{ originalDesc ? 'Redo' :'Original Text' }}</button>
                </div>

                


                <div v-if="editDescription">
                    <label for="instruction" class="block text-m font-bold">Instructions for altering text here:</label>
                    <div class="m-1">
                        <input id="instruction" name="instruction"
                            class="py-1 px-2 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                            v-model="instruction" @keyup="updateInstruction" />
                        <button @click="editDesc" :disabled="editDesc.processing"
                            class="ring-2 text-emerald-600 ring-emerald-600 p-2">Edit Description!</button>
                    </div>
                    <!-- <div class="text-red-600" v-if="editDescForm.errors.instructions">{{ editDescForm.errors }}</div> -->

                </div>
            </div>
            <div class="pt-6 flex justify-end gap-4 px-4">
                <div v-show="form.processing" class="text-sm text-gray-100">
                    Saving.... This can take a while, please be patient!
                </div>
                <div v-if="form.processing"></div>
            </div>
        </div>
        <Link class="text-gray-500  ring-2 ring-gray-500 hover:bg-gray-600 hover:text-white font-bold px-4 py-2 rounded-md"
            :href="route('user.manageposts')">
        Cancel
        </Link>
        <div>
            <button class="m-4 bg-emerald-600 p-2 ring-2 ring-white" @click="usePost">Use this photo</button>
        </div>

    </AppLayout>
    <FullScreenphoto :show="openingPhotoModal" @close="closePhotoModal">
        <template #content>
            <div v-if="title && postImage" class="flex flex-col bg-auto gap-4">
                <div class="flex justify-end">
                    <button
                        class="outline outline-gray-800 rounded-full text-white text-lg mt-4 mr-4 py-2 px-4 hover:text-red-600 hover:outline-red-600"
                        @click="closePhotoModal">X</button>
                </div>
                <div class="flex flex-col items-center">
                    <div class="text-bold text-2xl pl-4">{{ title }}</div>
                    <img class="object-scale-down py-6 px-4" :src="postImage" alt="" />
                </div>
                <div class="max-w-7xl mx-auto">
                    <p class="whitespace-pre-line md:text-xl px-4 pb-4 text-left">{{ postDesc }}</p>
            </div>
        </div>
    </template>
</FullScreenphoto></template>
