<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { CheckCircle2, CircleAlert, Info, TriangleAlert } from '@lucide/vue';
import { computed, ref, watch } from 'vue';

type FlashType = 'success' | 'error' | 'warning' | 'info';

type Flash = {
    success?: string;
    error?: string;
    warning?: string;
    info?: string;
};
const visible = ref(false);

let timeout: ReturnType<typeof setTimeout> | null = null;

const showMessage = () => {
    if (timeout) {
        clearTimeout(timeout);
    }

    if (!message.value) {
        visible.value = false;

        return;
    }

    visible.value = true;

    timeout = setTimeout(() => {
        visible.value = false;
    }, 5000);
};

const page = usePage();

const flash = computed(() => {
    return (page.props.flash as Flash | undefined) ?? {};
});

const type = computed<FlashType | null>(() => {
    if (flash.value.success) {
        return 'success';
    }

    if (flash.value.error) {
        return 'error';
    }

    if (flash.value.warning) {
        return 'warning';
    }

    if (flash.value.info) {
        return 'info';
    }

    return null;
});

const message = computed(() => {
    if (!type.value) {
        return '';
    }

    return flash.value[type.value] ?? '';
});

const config = {
    success: {
        classes:
            'border-green-200 bg-green-50 text-green-700 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-400',
        icon: CheckCircle2,
    },

    error: {
        classes:
            'border-red-200 bg-red-50 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400',
        icon: CircleAlert,
    },

    warning: {
        classes:
            'border-yellow-200 bg-yellow-50 text-yellow-700 dark:border-yellow-500/20 dark:bg-yellow-500/10 dark:text-yellow-400',
        icon: TriangleAlert,
    },

    info: {
        classes:
            'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400',
        icon: Info,
    },
};

const currentConfig = computed(() => {
    if (!type.value) {
        return null;
    }

    return config[type.value];
});
watch(
    message,
    () => {
        showMessage();
    },
    { immediate: true },
);
</script>

<template>
    <div
        v-if="type && currentConfig && visible"
        class="mb-6 flex items-center gap-3 rounded-xl border px-4 py-3 text-sm shadow-sm"
        :class="currentConfig.classes"
    >
        <component :is="currentConfig.icon" class="h-5 w-5 shrink-0" />

        <span class="font-medium">
            {{ message }}
        </span>
    </div>
</template>
