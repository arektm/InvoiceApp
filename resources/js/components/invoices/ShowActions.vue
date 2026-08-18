<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    indexUrl: string;
    editUrl: string;
    editLabel?: string;
    showEdit?: boolean;
}>();
</script>

<template>
    <div
        class="mt-6 flex items-center justify-end gap-3 rounded-xl border bg-muted/20 p-4 shadow-sm"
    >
        <!-- Cancel -->
        <Link :href="indexUrl" class="btnWhite"> Cancel </Link>

        <!-- Edit -->
        <Link v-if="showEdit" :href="editUrl" class="btnBlack">
            {{ editLabel ?? 'Edit' }}
        </Link>
    </div>
</template>
