<script setup>
import Modal from './Modal.vue';

const emit = defineEmits(['close']);

defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const close = () => {
    emit('close');
};
</script>

<template>
    <Modal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <div class="bg-black text-white">
            <div class="text-lg">
                <slot name="title" />
            </div>

            <div class="my-4">
                <slot name="content" />
            </div>
        </div>

        <div class="flex flex-row justify-end py-4 bg-black border-t border-gray-100 text-white text-right">
            <slot name="footer" />
        </div>
    </Modal>
</template>
