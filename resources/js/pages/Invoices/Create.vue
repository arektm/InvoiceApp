<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { create } from '@/routes/invoices';

import ComboboxClient from '../Shared/Invoices/ComboboxClient.vue';
import InvoiceItems from '../Shared/Invoices/InvoiceItems.vue';
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
function toDateString(date) {
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
    <Head>
        <title>Create Invoice</title>
    </Head>

    <h1 class="mb-6 text-3xl">New Invoice</h1>

    <form @submit.prevent="submit">
        <!-- CLIENT -->

        <div class="mb-6">
            <label class="mb-2 block font-medium"> Client </label>

            <ComboboxClient
                v-model="form.client_id"
                :clients="clients"
                :error="form.errors.client_id"
            />
        </div>

        <!-- DATES -->

        <div class="mb-6 grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1 block font-medium"> Issue date </label>

                <input
                    v-model="form.issue_date"
                    type="date"
                    class="w-full rounded border p-2"
                />

                <p
                    v-if="form.errors.issue_date"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ form.errors.issue_date }}
                </p>
            </div>

            <div>
                <label class="mb-1 block font-medium"> Sale date </label>

                <input
                    v-model="form.sale_date"
                    type="date"
                    class="w-full rounded border p-2"
                />

                <p
                    v-if="form.errors.sale_date"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ form.errors.sale_date }}
                </p>
            </div>

            <div>
                <label class="mb-1 block font-medium"> Due date </label>

                <input
                    v-model="form.due_date"
                    type="date"
                    class="w-full rounded border p-2"
                />

                <p
                    v-if="form.errors.due_date"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ form.errors.due_date }}
                </p>
            </div>

            <div>
                <label class="mb-1 block font-medium"> Payment method </label>

                <input
                    v-model="form.payment_method"
                    type="text"
                    class="w-full rounded border p-2"
                />

                <p
                    v-if="form.errors.payment_method"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ form.errors.payment_method }}
                </p>
            </div>
        </div>

        <!-- PRODUCTS -->

        <InvoiceItems
            :items="form.items"
            :products="products"
            :errors="form.errors"
        />

        <!-- SAVE -->

        <button
            type="submit"
            class="mt-5 ml-5 rounded bg-blue-500 px-6 py-2 text-white disabled:opacity-50"
            :disabled="form.processing"
        >
            {{ form.processing ? 'Saving...' : 'Save Invoice' }}
        </button>
    </form>
</template>
