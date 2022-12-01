<script setup>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    photo: Object
});
        const form = useForm({
            _method: "PUT",
            path: null,
            description: props.photo.description,
            title: props.photo.title,
        });

</script>

<template>
    <AppLayout title="Edit Photo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Photo
            </h2>
        </template>
        <div class="py-12">
            <div class="sm:px-4 lg:px-8 mt-5 md:col-span-2 md:mt-0">
                <form @submit.prevent="form.post(route('admin.photos.update', photo.id))">
                    <div class="flex flex-col">
                        <div>
                        <label
                            for="title"
                            class="block text-m font-bold text-gray-700"
                            >Title</label
                        >
                        <div class="m-1">
                            <input
                                id="title"
                                name="title"
                                class="py-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                placeholder="lorem ipsum"
                                v-model="form.title"
                            />
                        </div>
                        </div>
                        <div class="flex items-center py-10 gap-10">
                            <img class="flex-start" width="300" :src="'/storage/' + photo.path" alt="">
  
                        <div class="flex flex-col grow justify-center">
                        <label class="self-center text-lg font-bold text-gray-700 pt-4"
                            >Want to change this photo?</label
                        >
                        <div
                            class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"
                        >
                            <div class="space-y-1 text-center">
                                <div v-if="!form.path">
                                <svg
                                    class="mx-auto h-12 w-12 text-gray-400"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 48 48"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    
                                    <label
                                        for="path"
                                        class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500"
                                    >
                                        <span>Upload a file</span>
                                        <input
                                            id="path"
                                            name="path"
                                            type="file"
                                            class="sr-only"
                                            @input="
                                                form.path =
                                                    $event.target.files[0]
                                            "
                                        />
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 10MB
                                </p>
                            </div>
                            </div>
                            <div class="flex justify-center items-center gap-10 text-slate-800 font-bold" v-if="form.path">
                                <p class="">Selected Image: {{ form.path.name }}</p>
                                <button class="inline-flex justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-lg font-bold text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2" @click="(form.path=null)">Change Image</button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="text-red-600" v-if="form.errors.path">{{ form.errors.path }}</div>
                    <div>
                        <label
                            for="description"
                            class="block text-m font-bold text-gray-700 pt-8"
                            > Edit Description Here</label
                        >
                        <div class="mt-1">
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                v-model="form.description"
                            ></textarea>
                        </div>
                        <div class="text-red-600" v-if="form.errors.description">{{ form.errors.description }}</div>
                    </div>
                    </div>
                    <div class="pt-6 flex justify-end gap-4">
                        <Link
                        class="bg-slate-700 hover:bg-slate-800 text-white font-bold px-4 py-2 rounded-md"
                        :href="route('admin.photos')"
                        >
                        Cancel
                        </Link>
                        <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex  justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                        Save Changes
                    </button>
                </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
