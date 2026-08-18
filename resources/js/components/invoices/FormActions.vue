<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    indexUrl: string;
    deleteLabel?: string;
    saveLabel?: string;
    showDelete?: boolean;
    processing?: boolean;
    error?: string;
}>();

const emit = defineEmits<{
    delete: [];
}>();
</script>

<template>
    <div
        class="mt-6 flex items-center justify-end gap-3 rounded-xl border bg-muted/20 p-4 shadow-sm"
    >
        <!-- Cancel -->
        <Link :href="indexUrl" class="btnWhite"> Cancel </Link>

        <!-- Delete -->
        <button
            v-if="showDelete"
            type="button"
            :disabled="processing"
            class="btnDelete"
            @click="emit('delete')"
        >
            {{ deleteLabel ?? 'Delete' }}
        </button>

        <!-- Save -->
        <button type="submit" :disabled="processing" class="btnBlack">
            {{ saveLabel ?? 'Save changes' }}
        </button>
    </div>
    <div
        v-if="error"
        class="mt-2 rounded-xl border border-red-200 bg-red-50 px-6 py-4 text-sm text-red-600 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400"
    >
        {{ error }}
    </div>
</template>
