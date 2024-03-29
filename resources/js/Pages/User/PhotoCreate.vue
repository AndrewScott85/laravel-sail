<script>
import { defineComponent} from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, Link } from "@inertiajs/inertia-vue3";



export default defineComponent({
    components: {
        AppLayout,
        Link,
    },
    setup() {
        const form = useForm({
            path: null,
            description: null,
            title: '',
            ai_service_id: null,
        });

        return { form };
    },

    data() {
        return {
            photoPrev: null
        }

    },
    methods: {
        photoPreview(e) {
            
            const reader = new FileReader();

            reader.readAsDataURL(e.target.files[0]);

            reader.onload = (e) => {
                this.photoPrev = e.target.result
            }
        }
    },

    computed: {
        countdown() {
            return 30 - this.form.title.length;
        }
    },

    props: {
        ai_services: Object,
    }
    
});

</script>

<template>
    <AppLayout title="Create Photo">
        <template #header>
            <h2 class="font-semibold text-3xl leading-tight px-4">
                Create Post
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <p class="text-red-600 text-lg px-4 lg:px-8 pb-4 font-bold" v-if="$page.props.user.id == 1 || $page.props.user.id == 2">Please Note: The Demo Account is for UI demonstration: Creation, Editing, & Deletion are disabled on this account</p>
            <div class="sm:px-4 lg:px-8 mt-5 md:col-span-2 md:mt-0">
                <form @submit.prevent="form.post(route('user.photos.store'))">
                    <div class="flex flex-col px-4">
                        <div>
                            <label for="title" class="block text-m font-bold">Title (max 30
                                characters)</label>
                            <div class="m-1">
                                <input id="title" name="title" maxlength="30"
                                    class="py-1 block w-full text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                    placeholder="  Enter a title for your post here" 
                                    v-model="form.title"
                                    v-on:click="form.clearErrors('title')"
                                    />
                                <p class="pt-2">Characters remaining: {{ countdown }} </p>
                            </div>
                        </div>
                        <div class="text-red-600" v-if="form.errors.title">{{ form.errors.title }}</div>
                        <div>
                            <label for="ai_service" class="py-2 block text-m font-bold">Image Generator used: </label>
                        <select v-model="form.ai_service_id" class="form-control text-black">
                            <option value=null selected hidden disabled>Select one:</option>
                         <option v-for="ai_service in ai_services" :key="ai_service.id" :value="ai_service.id">
                             {{ ai_service.name }}
                        </option>
                        </select>
                    </div>
                    <div class="text-red-600" v-if="form.errors.ai_service">{{ form.errors.ai_service }}</div>

                        
                        <div>
                            <label class="block text-m mt-6 font-bold">Photo</label>
                            <div
                                class="mt-1 bg-white flex justify-center rounded-md outline-2 outline-dashed outline-gray-300 outline-offset-[-10px] px-6 pt-5 pb-6">
                                <div class="space-y-1 text-center">
                                    <div v-if="!form.path">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-md text-gray-600">

                                            <label for="path"
                                                class="relative cursor-pointer rounded-md font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Upload a file</span>
                                                <input id="path" name="path" type="file" class="sr-only"  v-on:click="form.clearErrors('path')"
                                                    accept="image/*" @input="
                                                        form.path =
                                                        $event.target.files[0]" 
                                                    @change="photoPreview" />
                                                                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-md text-gray-600">
                                            PNG, JPG, GIF up to 2MB
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col lg:flex-row items-center gap-10 font-bold"
                                    v-if="form.path">
                                    <div class="flex-start" width="200"><img :src="photoPrev" /></div>
                                    <p class="font-bold text-gray-600">Selected Image: <span class="font-medium px-2"> {{
                                            form.path.name}}</span></p>
                                    <button
                                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-500 py-2 ml-4 px-2 text-lg font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                        @click="(form.path = null)">Change Image</button>
                                </div>
                            </div>
                        </div>

                        <div class="text-red-600" v-if="form.errors.path">{{ form.errors.path }}</div>
                        <label for="description" class="block text-m mt-6 font-bold ">Description</label>
                        <div class="my-2">
                            <textarea id="description" name="description" rows="3" v-on:click="form.clearErrors('description')"
                                class="mt-1 block w-full text-black rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 md:text-md"
                                placeholder="Description for this post." v-model="form.description"></textarea>
                        </div>
                        <div class="text-red-600" v-if="form.errors.description">{{ form.errors.description }}</div>
                    </div>
                    <div class="flex justify-end py-10 gap-4 px-4">
                        <div v-show="form.processing" class="text-sm text-gray-100">
                            Saving.... This can take a few seconds
                         </div>
                        <Link
                            class="inline-flex justify-center rounded-md border border-transparent py-2 px-4 text-lg font-bold text-gray-500 ring-2 ring-gray-600 shadow-sm hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2"
                            :href="route('user.manageposts')">
                        Cancel
                        </Link>
                        <button type="submit" :disabled="form.processing"
                            class="inline-flex justify-center rounded-md border border-transparent ring-2 ring-emerald-600 py-2 px-4 text-lg font-bold text-emerald-600 shadow-sm hover:bg-emerald-600 hover:text-white 
                            focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
