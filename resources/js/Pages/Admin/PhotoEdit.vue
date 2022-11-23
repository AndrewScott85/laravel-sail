<script setup>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { propsToAttrMap } from "@vue/shared";

defineProps({
    photo: Object
});
        const form = useForm({
            _method: "PUT",
            path: null,
            description: propsToAttrMap.description,
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
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700"
                            >Description</label
                        >
                        <div class="mt-1">
                            <textarea
                                id="about"
                                name="about"
                                rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                placeholder="lorem ipsum"
                                v-model="form.description"
                            ></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Brief description for your photo.
                        </p>
                        <div class="text-red-600" v-if="form.errors.description">{{ form.errors.description }}</div>
                    </div>
                    
                    <div class="grid grid-cols-2">
                        <div class="preview">
                            <img width="300" :src="'/storage/' + photo.path" alt="">

                        </div>
                        <div>
                        <label class="block text-sm font-medium text-gray-700"
                            >Photo</label
                        >
                        <div
                            class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6"
                        >
                            <div class="space-y-1 text-center">
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
                    </div>

                    <div class="text-red-600" v-if="form.errors.path">{{ form.errors.path }}</div>

                    </div>
                                        <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                        Save
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
