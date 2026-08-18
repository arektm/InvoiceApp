<script setup lang="ts">
type Role = 'admin' | 'accountant' | 'user';

defineProps<{
    role: Role;
}>();

const classes: Record<Role, string> = {
    admin: 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400',

    accountant:
        'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400',

    user: 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
};
</script>

<template>
    <span
        class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
        :class="classes[role]"
    >
        {{ role }}
    </span>
</template>
