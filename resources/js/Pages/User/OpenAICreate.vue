<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

const form = useForm({
    prompt: null,
    title: '',
    text: null,
    style: null,
});

// const styles = [
//     {"id": 1, "name": "noir fiction"},
//     {"id": 2, "name": "children's story"},
//     {"id": 3, "name": "scientific article"},
//     {"id": 4, "name": "newspaper report"},
//     {"id": 5, "name": "blog post"},
//     {"id": 6, "name": "instagram post"},
//     {"id": 7, "name": "tabloid report"},
//     {"id": 1, "name": "highbrow magazine"},
// ]



const countdown = () => {
    return 30 - form.title.length;
}

</script>

<template>
    <AppLayout title="Create with OpenAI">
        <template #header>
            <h2 class="font-semibold text-3xl leading-tight">
                Create Photo and Description using OpenAI!
            </h2>
        </template>
        <div class="py-12 max-w-7xl mx-auto">
            <!-- <p class="text-red-600 text-lg px-4 lg:px-8 pb-4 font-bold"
                v-if="$page.props.user.id == 1 || $page.props.user.id == 2">Please Note: The Demo Account is for UI
                demonstration: Creation, Editing, & Deletion are disabled on this account</p> -->
            <div class="sm:px-4 lg:px-8 mt-5 md:col-span-2 md:mt-0">
                <form @submit.prevent="form.post(route('user.openai.post'))">
                    <div class="flex flex-col px-4">
                        <div>
                            <label for="title" class="block text-m font-bold">Title (max 30
                                characters)</label>
                            <div class="m-1">
                                <input id="title" name="title" maxlength="30" v-on:click="form.clearErrors('title')"
                                    class="py-1 px-2 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                    v-model="form.title" v-on:keydown="countdown" />
                                <p class="pt-2">Characters remaining: <countdown></countdown>
                                </p>
                            </div>
                        </div>
                        <div class="text-red-600" v-if="form.errors.title">{{ form.errors.title }}</div>



                        <div>
                            <label for="prompt" class="block text-m font-bold text-white pt-8"> Describe what you want
                                to see here!</label>
                            <div class="mt-1">
                                <textarea id="prompt" name="prompt" rows="3" v-on:click="form.clearErrors('prompt')"
                                    class="mt-1 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                    v-model="form.prompt"></textarea>
                            </div>
                            <div class="text-red-600" v-if="form.errors.prompt">{{ form.errors.prompt }}</div>
                            <div>
                                <label for="text" class="block text-m font-bold">Write a: (e.g. haiku, blogpost, film script, newspaper article, communist slogan etc) max 30
                                    characters</label>
                                <div class="m-1">
                                    <input id="text" name="text" maxlength="30" v-on:click="form.clearErrors('text')"
                                        class="py-1 px-2 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                        v-model="form.text" />
                                </div>
                            
                            <div class="text-red-600" v-if="form.errors.text">{{ form.errors.text }}</div>
                        </div>
                        <div>
                                <label for="style" class="block text-m font-bold">In the style of: ( e.g. a robot, mr T, donald trump, etc.) max 30
                                    characters</label>
                                <div class="m-1">
                                    <input id="style" name="style" maxlength="50" v-on:click="form.clearErrors('style')"
                                        class="py-1 px-2 block w-full text-gray-600 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-m"
                                        v-model="form.style" />
                                </div>
                            </div>
                            <div class="text-red-600" v-if="form.errors.style">{{ form.errors.style }}</div>
                        </div>
                    
            </div>
            <div class="pt-6 flex justify-end gap-4 px-4">
                <div v-show="form.processing" class="text-base text-gray-100">
                    Creating.... This can take a while, please be patient!
                </div>
                <div v-if="form.processing "></div>
                <Link
                    class="text-gray-500  ring-2 ring-gray-500 hover:bg-gray-600 hover:text-white font-bold px-4 py-2 rounded-md"
                    :href="route('user.manageposts')">
                Cancel
                </Link>
                <button type="submit" :disabled="form.processing"
                    class="inline-flex justify-center rounded-md border border-transparent ring-2 ring-emerald-600 text-emerald-600 py-2 px-4 font-bold hover:text-white shadow-sm hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    Create!
                </button>
            </div>
            </form>
        </div>
        </div>
    </AppLayout>
</template>
