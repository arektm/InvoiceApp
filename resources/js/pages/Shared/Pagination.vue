<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

defineProps<{
    links: PaginationLink[];
}>();
</script>

<template>
    <div class="mt-6 flex gap-2" v-if="links.length > 3">
        <template v-for="link in links" :key="link.label">
            <span
                v-if="!link.url"
                class="rounded border px-3 py-2 text-gray-400"
                v-html="link.label"
            />
            <Link
                v-else
                :href="link.url"
                class="rounded border px-3 py-2"
                :class="{
                    'bg-primary text-primary-foreground shadow-sm transition-colors hover:bg-primary/90':
                        link.active,
                }"
            >
                <span v-html="link.label"></span>
            </Link>
        </template>
    </div>
</template>
