<script setup lang="ts">
import { Head, useForm, Link } from '@inertiajs/vue3';
import { edit } from '@/routes/invoices';
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
    client_id: props.invoice.client_id,

    issue_date: props.invoice.issue_date,
    sale_date: props.invoice.sale_date,
    due_date: props.invoice.due_date,
    status: props.invoice.status,
    payment_method: props.invoice.payment_method,

    items: props.invoice.items.map((item) => ({
        id: item.id,
        product_id: item.product_id,
        product_name: item.product_name,
        quantity: item.quantity,
    })),
});

const submit = () => {
    form.put(`/invoices/${props.invoice.id}`);
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

<template>
    <Head>
        <title>Edit Invoice</title>
    </Head>

    <h1 class="mb-6 text-3xl">Edit Invoice {{ invoice.invoice_number }}</h1>

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

            <div>
                <label class="mb-1 block font-medium">
                    Status {{ form.status }}
                </label>

                <select v-model="form.status" class="w-full rounded border p-2">
                    <option value="unpaid">Unpaid</option>
                    <option value="paid">Paid</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <p v-if="form.errors.status" class="mt-1 text-sm text-red-500">
                    {{ form.errors.status }}
                </p>
            </div>
        </div>

        <!-- ITEMS -->

        <!-- <InvoiceItems
            :items="form.items"
            :products="products"
            :errors="form.errors"
        /> -->
        <InvoiceItems
            :items="form.items"
            :products="products"
            :errors="form.errors"
            @add-item="addItem"
            @remove-item="removeItem"
        />

        <!-- BUTTONS -->

        <div class="mt-6 flex gap-4">
            <button
                type="submit"
                :disabled="form.processing"
                class="rounded bg-blue-600 px-6 py-2 text-white disabled:opacity-50"
            >
                {{ form.processing ? 'Saving...' : 'Update Invoice' }}
            </button>
            <Link
                href="/invoices"
                class="rounded bg-gray-600 px-4 py-2 text-white"
            >
                Cancel
            </Link>
        </div>
    </form>
</template>
