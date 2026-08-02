<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3'
import { edit } from '@/routes/invoices'

import ComboboxClient from '../Shared/Invoices/ComboboxClient.vue'
import InvoiceItems from '../Shared/Invoices/InvoiceItems.vue'
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
})

const form = useForm({
    client_id: props.invoice.client_id,

    issue_date: props.invoice.issue_date,
    sale_date: props.invoice.sale_date,
    due_date: props.invoice.due_date,
    status: props.invoice.status,
    payment_method: props.invoice.payment_method,

    items: props.invoice.items.map(item => ({
        id: item.id,
        product_id: item.product_id,
        product_name: item.product_name,
        quantity: item.quantity,
    })),
})

const submit = () => {
    form.put(`/invoices/${props.invoice.id}`)
}

</script>

<template>

    <Head>
        <title>Edit Invoice</title>
    </Head>

    <h1 class="text-3xl mb-6">
        Edit Invoice {{ invoice.invoice_number }}
    </h1>

    <form @submit.prevent="submit">

        <!-- CLIENT -->

        <div class="mb-6">

            <label class="block mb-2 font-medium">
                Client
            </label>

            <ComboboxClient
                v-model="form.client_id"
                :clients="clients"
                :error="form.errors.client_id"
            />

        </div>

        <!-- DATES -->

        <div class="grid grid-cols-2 gap-4 mb-6">

            <div>
                <label class="block mb-1 font-medium">
                    Issue date
                </label>

                <input
                    v-model="form.issue_date"
                    type="date"
                    class="w-full border rounded p-2"
                >

                <p
                    v-if="form.errors.issue_date"
                    class="text-red-500 text-sm mt-1"
                >
                    {{ form.errors.issue_date }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium">
                    Sale date
                </label>

                <input
                    v-model="form.sale_date"
                    type="date"
                    class="w-full border rounded p-2"
                >

                <p
                    v-if="form.errors.sale_date"
                    class="text-red-500 text-sm mt-1"
                >
                    {{ form.errors.sale_date }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium">
                    Due date
                </label>

                <input
                    v-model="form.due_date"
                    type="date"
                    class="w-full border rounded p-2"
                >

                <p
                    v-if="form.errors.due_date"
                    class="text-red-500 text-sm mt-1"
                >
                    {{ form.errors.due_date }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium">
                    Payment method
                </label>

                <input
                    v-model="form.payment_method"
                    type="text"
                    class="w-full border rounded p-2"
                >

                <p
                    v-if="form.errors.payment_method"
                    class="text-red-500 text-sm mt-1"
                >
                    {{ form.errors.payment_method }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium">
                    Status {{ form.status }}
                </label>

                <select
                    v-model="form.status"
                    class="w-full border rounded p-2"
                >
                    <option value="unpaid">Unpaid</option>
                    <option value="paid">Paid</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                <p
                    v-if="form.errors.status"
                    class="text-red-500 text-sm mt-1"
                >
                    {{ form.errors.status }}
                </p>
            </div>

            

        </div>

        <!-- ITEMS -->

        <InvoiceItems
            :items="form.items"
            :products="products"
            :errors="form.errors"
        />

        <!-- BUTTONS -->

        <div class="flex gap-4 mt-6">

            <button
                type="submit"
                :disabled="form.processing"
                class="bg-blue-600 text-white px-6 py-2 rounded disabled:opacity-50"
            >
                {{
                    form.processing
                        ? 'Saving...'
                        : 'Update Invoice'
                }}
            </button>
            <Link
                href="/invoices"
                class="bg-gray-600 text-white px-4 py-2 rounded"
                >
                Cancel
            </Link>

        </div>

    </form>

</template>