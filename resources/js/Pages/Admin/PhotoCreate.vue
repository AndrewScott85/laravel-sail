<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({

});
</script>

<template>
    <AppLayout title="Create Photo">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Create Photo
            </h2>
        </template>
<div class="py-12">
    <template>
  <form @submit.prevent="submit">
    <label for="first_name">First name:</label>
    <input id="first_name" v-model="form.first_name" />
    <label for="last_name">Last name:</label>
    <input id="last_name" v-model="form.last_name" />
    <label for="email">Email:</label>
    <input id="email" v-model="form.email" />
    <button type="submit">Submit</button>
  </form>
</template>
</div>


    </AppLayout>
</template>
