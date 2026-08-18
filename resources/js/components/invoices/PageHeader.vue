<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const {
    title = '',
    item,
    description = '',
    actionButton = '← Back',
    actionButtonAddress = '#',
    variant = 'btnWhite',
} = defineProps<{
    title?: string;
    item?: string;
    description?: string;
    actionButton?: string;
    actionButtonAddress?: string;
    variant?: 'btnBlack' | 'btnWhite';
}>();

const styles = {
    // btnWhite: `inline-flex items-center justify-center rounded-lg bg-background px-4 py-2.5 text-sm font-medium border border-border text-foreground transition hover:bg-muted`,
    // btnBlack: `inline-flex items-center justify-center rounded-lg bg-primary px-4 py-2.5 text-sm font-medium text-primary-foreground transition hover:bg-primary/90`,
    btnWhite: 'btnWhite',
    btnBlack: 'btnBlack',
} as const;

const currentClass = computed(() => styles[variant]);
</script>
<template>
    <div
        class="flex flex-col gap-4 p-3 sm:flex-row sm:items-center sm:justify-between"
    >
        <div>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-foreground">
                {{ title }} {{ item }}
            </h1>

            <p class="mt-1 text-sm text-muted-foreground">
                {{ description }}
            </p>
        </div>

        <Link :href="actionButtonAddress" :class="currentClass">
            <slot>{{ actionButton }}</slot>
        </Link>
    </div>
</template>
