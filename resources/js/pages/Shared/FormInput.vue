<script setup>
defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    label: {
        type: String,
        required: true
    },
    id: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'text'
    },
    step:{
        type: String,
        default:''
    },
    error: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="flex flex-col gap-1">
        <label
            :for="id"
            class="text-sm font-medium"
        >
            {{ label }}
        </label>

        <input
            :id="id"
            :type="type"
            :value="modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            class="border p-2 rounded"
        >

        <div
            v-if="error"
            class="text-red-500 text-sm"
        >
            {{ error }}
        </div>
    </div>
</template>