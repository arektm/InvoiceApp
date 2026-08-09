<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { edit, update } from '@/routes/invoices';
import ComboboxClient from '../Shared/Invoices/ComboboxClient.vue';
import InvoiceItems from '../Shared/Invoices/InvoiceItems.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Invoices/Edit invoice',
                href: edit,
            },
        ],
    },
});
const props = defineProps({
    invoice: Object,
    clients: Array,
    products: Array,
});

const form = useForm({
    client_id: props.invoice?.client_id,
    issue_date: props.invoice?.issue_date,
    sale_date: props.invoice?.sale_date,
    due_date: props.invoice?.due_date,
    status: props.invoice?.status,
    payment_method: props.invoice?.payment_method,

    items: props.invoice?.items?.map((item: any) => ({
        id: item.id,
        product_id: item.product_id,
        product_name: item.product_name,
        quantity: item.quantity,
    })),
});

const submit = () => {
    // form.put(`/invoices/${props.invoice.id}`);
    form.put(update(props.invoice?.id).url);
};
const addItem = () => {
    form.items.push({
        product_id: '',
        product_name: '',
        quantity: 1,
    });
};

const removeItem = (index: number) => {
    form.items.splice(index, 1);
};
</script>

Here is the modified Laravel Inertia Vue template. The styling has been
completely overhauled to match the **Reports** dashboard style you provided,
using consistent Tailwind classes (e.g., `bg-card`, `rounded-xl`,
`border-border`, `text-muted-foreground`) and Lucide icons throughout. ```html
<template>
    <Head title="Edit Invoice" />

    <!-- Header Section -->
    <div
        class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
    >
        <div>
            <div class="flex items-center gap-2 text-sm text-muted-foreground">
                <FileText class="h-4 w-4" />

                <span>Invoices</span>
            </div>

            <h1 class="mt-1 text-3xl font-semibold tracking-tight">
                Edit Invoice {{ invoice?.invoice_number }}
            </h1>
        </div>

        <!-- Actions / Breadcrumbs style -->
        <div class="flex gap-2">
            <Link
                href="/invoices"
                :aria-label="'Cancel and go back'"
                class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted"
            >
                Back to list
            </Link>
        </div>
    </div>

    <form @submit.prevent="submit">
        <div class="space-y-8">
            <!-- Client Card -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <Users class="h-5 w-5 text-muted-foreground" />
                        <h2 class="font-semibold">Client</h2>
                    </div>
                </div>

                <ComboboxClient
                    v-model="form.client_id"
                    :clients="clients ?? []"
                    :error="form.errors.client_id"
                    class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                />
            </div>

            <!-- Dates & Details Grid -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                <!-- Issue Date -->
                <div
                    class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
                >
                    <label class="mb-2 block font-medium text-muted-foreground"
                        >Issue date</label
                    >

                    <div class="flex flex-col gap-2">
                        <input
                            v-model="form.issue_date"
                            type="date"
                            class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                        />

                        <p
                            v-if="form.errors.issue_date"
                            class="-mt-2 text-xs text-red-500"
                        >
                            {{ form.errors.issue_date }}
                        </p>
                    </div>
                </div>

                <!-- Sale Date -->
                <div
                    class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
                >
                    <label class="mb-2 block font-medium text-muted-foreground"
                        >Sale date</label
                    >

                    <div class="flex flex-col gap-2">
                        <input
                            v-model="form.sale_date"
                            type="date"
                            class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                        />

                        <p
                            v-if="form.errors.sale_date"
                            class="-mt-2 text-xs text-red-500"
                        >
                            {{ form.errors.sale_date }}
                        </p>
                    </div>
                </div>

                <!-- Due Date -->
                <div
                    class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
                >
                    <label class="mb-2 block font-medium text-muted-foreground"
                        >Due date</label
                    >

                    <div class="flex flex-col gap-2">
                        <input
                            v-model="form.due_date"
                            type="date"
                            class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                        />

                        <p
                            v-if="form.errors.due_date"
                            class="-mt-2 text-xs text-red-500"
                        >
                            {{ form.errors.due_date }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Payment & Status Row -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Payment Method -->
                <div
                    class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
                >
                    <label class="mb-2 block font-medium text-muted-foreground"
                        >Payment method</label
                    >

                    <div class="flex flex-col gap-2">
                        <input
                            v-model="form.payment_method"
                            type="text"
                            placeholder="e.g. Bank Transfer, Credit Card"
                            class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                        />

                        <p
                            v-if="form.errors.payment_method"
                            class="-mt-2 text-xs text-red-500"
                        >
                            {{ form.errors.payment_method }}
                        </p>
                    </div>
                </div>

                <!-- Status -->
                <div
                    class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
                >
                    <label class="mb-2 block font-medium text-muted-foreground"
                        >Status</label
                    >

                    <div class="flex flex-col gap-2">
                        <select
                            v-model="form.status"
                            class="flex w-full items-center gap-2 rounded-lg border bg-background px-3 py-2 text-sm shadow-sm focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                        >
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>

                        <p
                            v-if="form.errors.status"
                            class="text-xs text-red-500"
                        >
                            {{ form.errors.status }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="mb-4 flex items-center gap-2 text-muted-foreground">
                    <Package class="h-5 w-5" />
                    <h2 class="font-semibold">Items</h2>
                </div>

                <!-- Comment: Keeping the original logic but wrapped in a card for style consistency -->
                <!-- <InvoiceItems ... /> -->
                <InvoiceItems
                    :items="form.items"
                    :products="products ?? []"
                    :errors="form.errors"
                    @add-item="addItem"
                    @remove-item="removeItem"
                />
            </div>

            <!-- Footer / Buttons -->
            <div
                class="flex items-center justify-between gap-4 rounded-xl border bg-muted/30 p-5 shadow-sm"
            >
                <div class="text-sm text-muted-foreground">
                    All changes will be saved upon submission.
                </div>

                <div class="flex gap-4">
                    <Link
                        href="/invoices"
                        :aria-label="'Cancel'"
                        class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-4 text-sm font-medium text-white shadow-sm transition-colors hover:bg-blue-600/90 disabled:pointer-events-none disabled:opacity-50"
                    >
                        {{ form.processing ? 'Saving...' : 'Update Invoice' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</template>
