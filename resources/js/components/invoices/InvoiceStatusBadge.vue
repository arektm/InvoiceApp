<script setup lang="ts">
type InvoiceStatus = 'paid' | 'unpaid' | 'overdue' | 'cancelled';

const props = defineProps<{
    status: InvoiceStatus | string;
    overdue?: boolean;
}>();

const statusClasses: Record<string, string> = {
    // paid: 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400',
    // unpaid: 'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-400',
    // overdue: 'bg-red-200 text-red-700 dark:bg-red-950 dark:text-red-400',
    // cancelled:'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
    paid: 'paid',
    unpaid: 'unpaid',
    overdue: 'overdue',
    cancelled: 'cancelled',
};
</script>

<template>
    <div class="flex flex-wrap items-center gap-2">
        <span
            class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
            :class="statusClasses[props.status] ?? statusClasses.unpaid"
        >
            {{ props.status }}
        </span>

        <span
            v-if="props.status === 'unpaid' && props.overdue"
            class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
            :class="statusClasses.overdue"
        >
            overdue
        </span>
    </div>
</template>
