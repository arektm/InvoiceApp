<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    indexUrl: string;
    deleteLabel?: string;
    saveLabel?: string;
    showDelete?: boolean;
    processing?: boolean;
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
        <Link
            :href="indexUrl"
            class="inline-flex  h-11 items-center justify-center rounded-lg border bg-background px-4 py-2.5 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
        >
            Cancel
        </Link>

        <!-- Delete -->
        <button
            v-if="showDelete"
            type="button"
            :disabled="processing"
            class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-100 disabled:pointer-events-none disabled:opacity-50 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400 dark:hover:bg-red-500/20"
            @click="emit('delete')"
        >
            {{ deleteLabel ?? 'Delete' }}
        </button>

        <!-- Save -->
        <button
            type="submit"
            :disabled="processing"
            class="inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground transition hover:bg-primary/90 disabled:pointer-events-none disabled:opacity-50"
        >
            {{ saveLabel ?? 'Save Changes' }}
        </button>
    </div>
</template>