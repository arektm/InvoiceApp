<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Eye, Pencil, Plus } from '@lucide/vue';
import { ref, watch } from 'vue';
import { create, show, index, edit } from '@/routes/invoices';
import Pagination from '../Shared/Pagination.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Invoices',
                href: index(),
            },
        ],
    },
});

const props = defineProps({
    invoices: Object,
    filters: Object,
});
const search = ref(props.filters?.search ?? '');

watch(search, (value) => {
    router.get(
        '/invoices',
        {
            search: value,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
});
</script>

<template>
    <Head title="Invoices"></Head>

    <div class="space-y-4">
        <!-- Header -->
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="mt-3 ml-3 text-3xl font-semibold tracking-tight">
                    Invoices
                </h1>
            </div>

            <Link
                :href="create()"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90"
            >
                <Plus class="h-4 w-4" />

                New Invoice
            </Link>
        </div>

        <!-- Search -->
        <div class="rounded-xl border bg-card p-5 shadow-sm">
            <div class="flex items-center gap-2">
                <Search class="h-4 w-4 text-muted-foreground" />

                <label for="invoice-search" class="text-sm font-medium">
                    Search invoices by invoice number, client name or email
                    address.
                </label>
            </div>

            <!-- <p class="mt-1 text-xs text-muted-foreground">
                Search by invoice number, client name or email address.
            </p> -->

            <div class="relative mt-4">
                <Search
                    class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                />

                <input
                    id="invoice-search"
                    v-model="search"
                    type="text"
                    placeholder="Invoice number, client name, e-mail..."
                    class="w-full rounded-lg border bg-background py-2.5 pr-4 pl-9 text-sm transition-colors outline-none placeholder:text-muted-foreground focus:border-ring focus:ring-2 focus:ring-ring/20"
                />
            </div>
        </div>

        <!-- Invoices table -->
        <div class="overflow-hidden rounded-xl border bg-card shadow-sm">
            <!-- Table header -->
            <div class="border-b px-6 py-4">
                <div class="flex items-center gap-2">
                    <FileText class="h-5 w-5 text-muted-foreground" />

                    <h2 class="font-semibold">Invoice list</h2>
                </div>
            </div>

            <!-- Desktop table -->
            <div class="hidden overflow-x-auto md:block">
                <table class="w-full">
                    <thead>
                        <tr class="border-b bg-muted/30">
                            <th
                                class="px-6 py-3 text-left text-xs font-medium tracking-wider text-muted-foreground uppercase"
                            >
                                Number
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-medium tracking-wider text-muted-foreground uppercase"
                            >
                                Client
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-medium tracking-wider text-muted-foreground uppercase"
                            >
                                Issue Date
                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-medium tracking-wider text-muted-foreground uppercase"
                            >
                                Gross
                            </th>

                            <th
                                class="px-6 py-3 text-left text-xs font-medium tracking-wider text-muted-foreground uppercase"
                            >
                                Status
                            </th>

                            <th
                                class="px-6 py-3 text-right text-xs font-medium tracking-wider text-muted-foreground uppercase"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        <tr
                            v-for="invoice in invoices?.data"
                            :key="invoice.id"
                            class="transition-colors hover:bg-muted/40"
                        >
                            <!-- Number -->
                            <td class="px-6 py-2 whitespace-nowrap">
                                <Link
                                    :href="show(invoice.id)"
                                    class="text-sm font-medium hover:underline"
                                >
                                    {{ invoice.invoice_number }}
                                </Link>
                            </td>

                            <!-- Client -->
                            <td class="px-6 py-2">
                                <div class="text-sm font-medium">
                                    {{ invoice.name }}
                                </div>
                            </td>

                            <!-- Issue date -->
                            <td
                                class="px-6 py-2 text-sm whitespace-nowrap text-muted-foreground"
                            >
                                {{ invoice.issue_date }}
                            </td>

                            <!-- Gross -->
                            <td
                                class="px-6 py-2 text-right text-sm font-semibold whitespace-nowrap"
                            >
                                € {{ invoice.total_gross }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-2">
                                <span
                                    class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
                                    :class="{
                                        'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400':
                                            invoice.status === 'paid',

                                        'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-400':
                                            invoice.status === 'unpaid',

                                        'bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-400':
                                            invoice.status === 'overdue',

                                        'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300':
                                            invoice.status === 'cancelled',
                                    }"
                                >
                                    {{ invoice.status }}
                                </span>
                                <span
                                    v-if="
                                        invoice.status === 'unpaid' &&
                                        invoice.overdue
                                    "
                                    class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-950 dark:text-red-400"
                                    >overdue</span
                                >
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-2">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="show(invoice.id).url"
                                        class="inline-flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-sm font-medium transition-colors hover:bg-muted"
                                    >
                                        <Eye class="h-4 w-4" />

                                        View
                                    </Link>

                                    <Link
                                        :href="edit(invoice.id)"
                                        class="inline-flex items-center gap-1.5 rounded-lg bg-primary px-3 py-1.5 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
                                    >
                                        <Pencil class="h-4 w-4" />

                                        Edit
                                    </Link>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Mobile cards -->
            <div class="divide-y md:hidden">
                <div
                    v-for="invoice in invoices?.data"
                    :key="invoice.id"
                    class="p-5 transition-colors hover:bg-muted/40"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <Link
                                :href="show(invoice.id)"
                                class="font-medium hover:underline"
                            >
                                {{ invoice.invoice_number }}
                            </Link>

                            <p
                                class="mt-1 truncate text-sm text-muted-foreground"
                            >
                                {{ invoice.name }}
                            </p>
                        </div>

                        <span
                            class="shrink-0 rounded-full px-2.5 py-1 text-xs font-medium"
                            :class="{
                                'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400':
                                    invoice.status === 'paid',

                                'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-400':
                                    invoice.status === 'unpaid',

                                'bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-400':
                                    invoice.status === 'overdue',

                                'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300':
                                    invoice.status === 'cancelled',
                            }"
                        >
                            {{ invoice.status }}
                        </span>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-xs text-muted-foreground">
                                Issue date
                            </p>

                            <p class="mt-1 font-medium">
                                {{ invoice.issue_date }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-muted-foreground">Gross</p>

                            <p class="mt-1 font-semibold">
                                € {{ invoice.total_gross }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <Link
                            :href="show(invoice.id).url"
                            class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg border px-3 py-2 text-sm font-medium transition-colors hover:bg-muted"
                        >
                            <Eye class="h-4 w-4" />

                            View
                        </Link>

                        <Link
                            :href="edit(invoice.id)"
                            class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-primary px-3 py-2 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90"
                        >
                            <Pencil class="h-4 w-4" />

                            Edit
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Empty state -->
            <div v-if="!invoices?.data?.length" class="px-6 py-12 text-center">
                <FileText class="mx-auto h-8 w-8 text-muted-foreground" />

                <p class="mt-3 text-sm font-medium">No invoices found</p>

                <p class="mt-1 text-xs text-muted-foreground">
                    Try changing your search or create a new invoice.
                </p>
            </div>
        </div>

        <!-- Pagination -->
        <Pagination :links="invoices?.links" />
    </div>
</template>
