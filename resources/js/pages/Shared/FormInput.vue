<script setup lang="ts">
defineProps({
    modelValue: {
        type: [String, Number],
        default: '',
    },
    label: {
        type: String,
        required: true,
    },
    id: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'text',
    },
    step: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue']);

const handleInput = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target) {
        emit('update:modelValue', target.value);
    }
};
</script>

<template>
    <div class="flex flex-col gap-1">
        <label :for="id" class="p-2 text-sm font-medium">
            {{ label }}
        </label>

        <input
            :id="id"
            :type="type"
            :value="modelValue"
            @input="handleInput"
            class="rounded border p-2"
        />

        <div v-if="error" class="text-sm text-red-500">
            {{ error }}
        </div>
    </div>
</template>
