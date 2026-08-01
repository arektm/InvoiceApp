<script setup>
import { Head, useForm } from '@inertiajs/vue3'

import ComboboxClient from '../Shared/Invoices/ComboboxClient.vue'
import InvoiceItems from '../Shared/Invoices/InvoiceItems.vue'

const props = defineProps({
    clients: Array,
    products: Array,
})

// ------------------------------------------------------------------
// Date helpers
// ------------------------------------------------------------------
function toDateString(date) {
    return date.toISOString().split('T')[0]
}

const today = new Date()

const defaultIssueDate = toDateString(today)

const defaultDueDate = toDateString(
    new Date(
        today.getTime() +
        14 * 24 * 60 * 60 * 1000
    )
)

// ------------------------------------------------------------------
// Form
// ------------------------------------------------------------------
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
        }
    ]
})

const submit = () => {
    form.post('/invoices')
}
</script>

<template>

    <Head>
        <title>Create Invoice</title>
    </Head>

    <h1 class="text-3xl mb-6">
        New Invoice
    </h1>

    <form @submit.prevent="submit">

        <!-- CLIENT -->

        <div class="mb-6">

            <label
                class="block mb-2 font-medium"
            >
                Client
            </label>

            <ComboboxClient
                v-model="form.client_id"
                :clients="clients"
                :error="form.errors.client_id"
            />

        </div>

        <!-- DATES -->

        <div
            class="grid grid-cols-2 gap-4 mb-6"
        >

            <div>

                <label
                    class="block mb-1 font-medium"
                >
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

                <label
                    class="block mb-1 font-medium"
                >
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

                <label
                    class="block mb-1 font-medium"
                >
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

                <label
                    class="block mb-1 font-medium"
                >
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
            class="ml-5 mt-5 bg-blue-500 text-white px-6 py-2 rounded disabled:opacity-50"
            :disabled="form.processing"
        >
            {{
                form.processing
                    ? 'Saving...'
                    : 'Save Invoice'
            }}
        </button>

    </form>

</template>