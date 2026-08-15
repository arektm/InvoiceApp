<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { create, index } from '@/routes/invoices';

import ComboboxClient from '../Shared/Invoices/ComboboxClient.vue';
import InvoiceItems from '../Shared/Invoices/InvoiceItems.vue';
import PageHeader from '@/components/invoices/PageHeader.vue';
import FormActions from '@/components/invoices/FormActions.vue';
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Invoices/New invoice',
                href: create,
            },
        ],
    },
});
defineProps({
    clients: Array,
    products: Array,
});

// Date helpers
function toDateString(date: Date) {
    return date.toISOString().split('T')[0];
}

const today = new Date();

const defaultIssueDate = toDateString(today);

const defaultDueDate = toDateString(
    new Date(today.getTime() + 14 * 24 * 60 * 60 * 1000),
);

const form = useForm({
    client_id: '',

    issue_date: defaultIssueDate,
    sale_date: defaultIssueDate,
    due_date: defaultDueDate,

    payment_method: 'bank transfer',

    items: [
        {
            product_id: '',
            product_name: '',
            quantity: 1,
        },
    ],
});

const submit = () => {
    form.post('/invoices');
};
// ----------------------------------
</script>

<template>
    <Head title="New Invoice" />

    <div class="space-y-8">
        <!-- Header -->
        <!-- <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight">
                    New Invoice
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    Create a new invoice record in the system.
                </p>
            </div>

            <Link
                href="/invoices"
                class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted"
            >
                Cancel
            </Link>
        </div> -->
        <PageHeader
            title="New invoice"
            description="Create a new invoice record in the system."
            actionButton="← Back to invoices"
            actionButtonAddress="/invoices"
            variant="btnWhite"
        />

        <!-- Form -->
        <form @submit.prevent="submit">
            <div class="space-y-6">
                <!-- CLIENT CARD -->
                <div
                    class="rounded-xl border bg-card p-3 shadow-sm transition-shadow hover:shadow-md"
                >
                    <div class="mb-4 flex items-center justify-between">
                        <div
                            class="flex items-center gap-2 text-muted-foreground"
                        >
                            <Users class="h-5 w-5" />
                            <h2
                                class="text-sm font-medium tracking-tight text-muted-foreground uppercase"
                            >
                                Client Information
                            </h2>
                        </div>
                    </div>
                    <ComboboxClient
                        v-model="form.client_id"
                        :clients="clients ?? []"
                        :error="form.errors.client_id"
                        class="flex w-full items-center gap-2 rounded-lg border bg-background px-6 py-3 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                    />

                    <div
                        v-if="form.errors.client_id"
                        class="mt-1 text-xs text-red-500"
                    >
                        {{ form.errors.client_id }}
                    </div>
                </div>

                <!-- DATES CARD -->
                <div
                    class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
                >
                    <div
                        class="mb-4 flex items-center gap-2 text-muted-foreground"
                    >
                        <CalendarDays class="h-5 w-5" />
                        <h2
                            class="text-sm font-medium tracking-tight text-muted-foreground uppercase"
                        >
                            Dates & Payment Method
                        </h2>
                    </div>

                    <div
                        class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4"
                    >
                        <!-- Issue Date -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Issue date</label
                            >

                            <input
                                v-model="form.issue_date"
                                type="date"
                                class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <p
                                v-if="form.errors.issue_date"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.issue_date }}
                            </p>
                        </div>

                        <!-- Sale Date -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Sale date</label
                            >

                            <input
                                v-model="form.sale_date"
                                type="date"
                                class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <p
                                v-if="form.errors.sale_date"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.sale_date }}
                            </p>
                        </div>

                        <!-- Due Date -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Due date</label
                            >

                            <input
                                v-model="form.due_date"
                                type="date"
                                class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <p
                                v-if="form.errors.due_date"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.due_date }}
                            </p>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label
                                class="mb-1.5 block text-sm font-medium text-muted-foreground"
                                >Payment method</label
                            >

                            <input
                                v-model="form.payment_method"
                                type="text"
                                placeholder="e.g. Transfer, Cash..."
                                class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                            />

                            <p
                                v-if="form.errors.payment_method"
                                class="mt-1 text-xs text-red-500"
                            >
                                {{ form.errors.payment_method }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ITEMS CARD -->
                <div
                    class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
                >
                    <div
                        class="mb-4 flex items-center gap-2 text-muted-foreground"
                    >
                        <Package class="h-5 w-5" />
                        <h2
                            class="text-sm font-medium tracking-tight text-muted-foreground uppercase"
                        >
                            Items
                        </h2>
                    </div>

                    <!-- Comment: Keep your component as is inside this styled wrapper -->
                    <InvoiceItems
                        :items="form.items"
                        :products="products ?? []"
                        :errors="form.errors"
                    />

                    <p
                        v-if="!form.items.length"
                        class="mt-4 text-sm text-muted-foreground"
                    >
                        Items list is currently empty.
                    </p>
                </div>

                <FormActions
                    :index-url="index().url"
                    save-label="Save Changes"
                    :processing="form.processing"
                />
            </div>
        </form>
    </div>
</template>
