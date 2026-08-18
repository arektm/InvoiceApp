<script setup>
import { watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    item: {
        type: String,
        default: '',
    },
    title: {
        type: String,
        default: 'Confirmation',
    },
    message: {
        type: String,
        default: 'Are you sure you want to perform this action?',
    },
    cancel: {
        type: String,
        default: 'Cancel',
    },
    confirm: {
        type: String,
        default: 'Confirm',
    },
});

const emit = defineEmits(['close', 'confirm']);

watch(
    () => props.show,
    (value) => {
        if (value) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    },
);
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto p-4"
    >
        <div
            @click="emit('close')"
            class="fixed inset-0 bg-gray-500/75 transition-opacity"
        ></div>

        <div
            class="relative z-10 w-full max-w-md transform rounded-lg bg-white p-6 shadow-xl transition-all"
        >
            <div class="mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ title }}
                </h3>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-500">{{ message }} {{ item }} ?</p>
            </div>

            <div class="flex justify-end space-x-3">
                <button
                    type="button"
                    @click="emit('close')"
                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                >
                    {{ cancel }}
                </button>
                <button
                    type="button"
                    @click="emit('confirm')"
                    class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:outline-none"
                >
                    {{ confirm }}
                </button>
            </div>
        </div>
    </div>
</template>
