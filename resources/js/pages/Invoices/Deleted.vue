<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import Pagination from '../Shared/Pagination.vue'


defineOptions({
    layout: AppLayout,
})

type Invoice = {
    id: number
    invoice_number: string
    issue_date: string
    due_date: string
    status: string
    total_gross: number | string
    name?: string | null
    email?: string | null
    deleted_at?: string | null
}

type PaginationLink = {
    url: string | null
    label: string
    active: boolean
}

type PaginatedInvoices = {
    data: Invoice[]
    links: PaginationLink[]
}

const props = defineProps<{
    invoices: PaginatedInvoices
    filters: {
        search?: string
    }
}>()

const search = ref(props.filters?.search ?? '')

let timeout: ReturnType<typeof setTimeout>

watch(search, (value) => {
    clearTimeout(timeout)

    timeout = setTimeout(() => {
        router.get(
            '/invoices/deleted',
            {
                search: value || undefined,
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            },
        )
    }, 300)
})
</script>

<template>
    <Head title="Deleted invoices" />

    <div class="space-y-6">

        <!-- Header -->
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <div
                    class="flex items-center gap-2 text-sm text-muted-foreground"
                >
                    <span>Invoices</span>
                    <span>/</span>
                    <span>Deleted</span>
                </div>

                <h1 class="mt-2 text-3xl font-bold tracking-tight">
                    Deleted invoices
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    View invoices that have been moved to the recycle bin.
                </p>
            </div>

            <Link
                href="/invoices"
                class="inline-flex items-center justify-center rounded-lg border px-4 py-2.5 text-sm font-medium transition hover:bg-muted"
            >
                Back to invoices
            </Link>
        </div>

        <!-- Search -->
        <div
            class="rounded-xl border bg-card p-4 shadow-sm"
        >
            <div class="relative">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search by invoice number, client or email..."
                    class="w-full rounded-lg border bg-background px-4 py-2.5 text-sm outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20"
                />
            </div>
        </div>

        <!-- Table -->
        <div
            class="overflow-hidden rounded-xl border bg-card shadow-sm"
        >
            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr
                            class="border-b bg-muted/40 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground"
                        >
                            <th class="px-6 py-4">
                                Invoice
                            </th>

                            <th class="px-6 py-4">
                                Client
                            </th>

                            <th class="px-6 py-4">
                                Issue date
                            </th>

                            <th class="px-6 py-4">
                                Due date
                            </th>

                            <th class="px-6 py-4 text-right">
                                Total
                            </th>

                            <th class="px-6 py-4">
                                Deleted
                            </th>

                            <th class="px-6 py-4 text-center">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody
                        v-if="invoices?.data?.length"
                        class="divide-y"
                    >
                        <tr
                            v-for="invoice in invoices.data"
                            :key="invoice.id"
                            class="transition hover:bg-muted/30"
                        >

                            <!-- Invoice -->
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium">
                                    {{ invoice.invoice_number }}
                                </div>

                                <div
                                    class="mt-1 text-xs text-muted-foreground"
                                >
                                    ID #{{ invoice.id }}
                                </div>
                            </td>

                            <!-- Client -->
                            <td class="px-6 py-4">
                                <div class="font-medium">
                                    {{ invoice.name || '—' }}
                                </div>

                                <div
                                    v-if="invoice.email"
                                    class="mt-1 text-xs text-muted-foreground"
                                >
                                    {{ invoice.email }}
                                </div>
                            </td>

                            <!-- Issue date -->
                            <td
                                class="whitespace-nowrap px-6 py-4 text-muted-foreground"
                            >
                                {{ invoice.issue_date }}
                            </td>

                            <!-- Due date -->
                            <td
                                class="whitespace-nowrap px-6 py-4 text-muted-foreground"
                            >
                                {{ invoice.due_date }}
                            </td>

                            <!-- Total -->
                            <td
                                class="whitespace-nowrap px-6 py-4 text-right font-semibold"
                            >
                                €
                                {{
                                    Number(
                                        invoice.total_gross ?? 0
                                    ).toFixed(2)
                                }}
                            </td>

                            <!-- Deleted -->
                            <td
                                class="whitespace-nowrap px-6 py-4 text-muted-foreground"
                            >
                                {{ invoice.deleted_at }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <Link
                                        :href="`/invoices/${invoice.id}`"
                                        class="rounded-lg border px-3 py-1.5 text-xs font-medium transition hover:bg-muted"
                                    >
                                        View
                                    </Link>
                                </div>
                            </td>

                        </tr>
                    </tbody>

                    <!-- Empty -->
                    <tbody v-else>
                        <tr>
                            <td
                                colspan="7"
                                class="px-6 py-16 text-center"
                            >
                                <div
                                    class="text-sm font-medium"
                                >
                                    No deleted invoices found
                                </div>

                                <p
                                    class="mt-1 text-sm text-muted-foreground"
                                >
                                    {{
                                        search
                                            ? 'Try changing your search.'
                                            : 'The recycle bin is empty.'
                                    }}
                                </p>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <!-- Pagination -->
        <Pagination
            :links="invoices?.links"
        />

    </div>
</template>