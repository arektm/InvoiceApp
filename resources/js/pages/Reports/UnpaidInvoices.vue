<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { unpaidInvoices } from '@/routes/reports';
import Pagination from '../Shared/Pagination.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Reports/Unpaid invoices',
                href: unpaidInvoices(),
            },
        ],
    },
});

defineProps({
    invoices: Object,
});
</script>

<template>
    <Head title="Unpaid Invoices" />

    <div
        class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
    >
        <h1 class="text-3xl font-semibold tracking-tight">Unpaid invoices</h1>

        <Link
            href="/reports"
            class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted"
        >
            Back
        </Link>
    </div>

    <div class="overflow-hidden rounded-xl border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b bg-muted/30">
                        <th
                            class="px-6 py-3 text-left text-xs font-medium tracking-wider text-muted-foreground uppercase"
                        >
                            Invoice
                        </th>

                        <th
                            class="px-6 py-3 text-left text-xs font-medium tracking-wider text-muted-foreground uppercase"
                        >
                            Client
                        </th>

                        <th
                            class="px-6 py-3 text-left text-xs font-medium tracking-wider text-muted-foreground uppercase"
                        >
                            Email
                        </th>

                        <th
                            class="px-6 py-3 text-center text-xs font-medium tracking-wider text-muted-foreground uppercase"
                        >
                            Issue Date
                        </th>

                        <th
                            class="px-6 py-3 text-center text-xs font-medium tracking-wider text-muted-foreground uppercase"
                        >
                            Due Date
                        </th>

                        <th
                            class="px-6 py-3 text-center text-xs font-medium tracking-wider text-muted-foreground uppercase"
                        >
                            Overdue
                        </th>

                        <th
                            class="px-6 py-3 text-right text-xs font-medium tracking-wider text-muted-foreground uppercase"
                        >
                            Amount
                        </th>

                        <th
                            class="px-6 py-3 text-right text-xs font-medium tracking-wider text-muted-foreground uppercase"
                        >
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    <tr
                        v-for="invoice in invoices?.data"
                        :key="invoice.id"
                        class="transition-colors hover:bg-muted/40"
                    >
                        <td
                            class="px-6 py-3 text-sm font-medium whitespace-nowrap"
                        >
                            {{ invoice.invoice_number }}
                        </td>

                        <td class="px-6 py-3">
                            <div class="text-sm font-medium">
                                {{ invoice.client_name }}
                            </div>
                        </td>

                        <td class="px-6 py-3 text-sm text-muted-foreground">
                            {{ invoice.client_email }}
                        </td>

                        <td
                            class="px-6 py-3 text-center text-sm whitespace-nowrap text-muted-foreground"
                        >
                            {{ invoice.issue_date }}
                        </td>

                        <td
                            class="px-6 py-3 text-center text-sm whitespace-nowrap text-muted-foreground"
                        >
                            {{ invoice.due_date }}
                        </td>

                        <td class="px-6 py-3 text-center">
                            <span
                                v-if="invoice.days_overdue > 0"
                                class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-950 dark:text-red-400"
                            >
                                {{ invoice.days_overdue }} days
                            </span>

                            <span
                                v-else
                                class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400"
                            >
                                {{ -invoice.days_overdue }} OK
                            </span>
                        </td>

                        <td
                            class="px-6 py-3 text-right text-sm font-semibold whitespace-nowrap"
                        >
                            € {{ Number(invoice.total_gross).toFixed(2) }}
                        </td>

                        <td class="px-6 py-3 text-right">
                            <Link
                                :href="`/invoices/${invoice.id}`"
                                class="inline-flex items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-medium transition-colors hover:bg-muted"
                            >
                                View
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <Pagination :links="invoices?.links" />
</template>
