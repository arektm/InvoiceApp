<script setup>
import { create } from '@/routes/products';
import { Head, Link, useForm } from '@inertiajs/vue3'

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Products/Add product',
                href: create,
            },
        ],
    },
});

const form = useForm({

    product_code: 'PR-000',

    product_name: '',

    description: '',

    net_price: '',

    vat_rate: 23,

    stock_quantity: 0,
})

const submit = () => {

    form.post('/products')
}
</script>

<template>

<Head>
    <title>Add product</title>
</Head>

<div class="flex justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Add product
    </h1>

</div>

<form
    @submit.prevent="submit"
    class="shadow rounded p-6"
>

    <div class="grid gap-4">

        <div>

            <label class="block mb-1">
                Product code
            </label>

            <input
                v-model="form.product_code"
                type="text"
                class="w-full border rounded p-2"
            >

            <div
                v-if="form.errors.product_code"
                class="text-red-500 text-sm mt-1"
            >
                {{ form.errors.product_code }}
            </div>

        </div>

        <div>

            <label class="block mb-1">
                Product name
            </label>

            <input
                v-model="form.product_name"
                type="text"
                class="w-full border rounded p-2"
            >

            <div
                v-if="form.errors.product_name"
                class="text-red-500 text-sm mt-1"
            >
                {{ form.errors.product_name }}
            </div>

        </div>

        <div>

            <label class="block mb-1">
                Product description
            </label>

            <textarea
                v-model="form.description"
                rows="4"
                class="w-full border rounded p-2"
            />

        </div>

        <div>

            <label class="block mb-1">
                 Net price
            </label>

            <input
                v-model="form.net_price"
                type="number"
                step="0.01"
                class="w-full border rounded p-2"
            >

            <div
                v-if="form.errors.net_price"
                class="text-red-500 text-sm mt-1"
            >
                {{ form.errors.net_price }}
            </div>

        </div>

        <div>

            <label class="block mb-1">
                VAT %
            </label>

            <select
                v-model="form.vat_rate"
                class="w-full bg-secondary border rounded p-2"
            >
                <option :value="23">23%</option>
                <option :value="8">8%</option>
                <option :value="5">5%</option>
                <option :value="0">0%</option>
            </select>

        </div>

        <div>

            <label class="block mb-1">
                Stock quantity
            </label>

            <input
                v-model="form.stock_quantity"
                type="number"
                min="0"
                class="w-full border rounded p-2"
            >

        </div>

    </div>

    <div class="flex gap-4 mt-6">

        <button
            :disabled="form.processing"
            class="bg-blue-600 text-white px-6 py-2 rounded"
        >
            Save
        </button>
        <Link
            href="/products"
            class="bg-gray-500 text-white px-4 py-2 rounded"
        >
            Cancel
        </Link>

    </div>

</form>

</template>