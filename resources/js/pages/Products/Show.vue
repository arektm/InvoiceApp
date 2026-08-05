<script setup lang="ts">
import { show, edit } from '@/routes/products';
import { Head, Link } from '@inertiajs/vue3'

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Products/Product view',
                href: show,
            },
        ],
    },
});

defineProps({
    product: Object
})

</script>

<template>

<Head>
    <title>{{ product.product_name }}</title>
</Head>

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Product details
    </h1>

   

</div>

<div class="shadow rounded p-6">

    <div class="grid grid-cols-2 gap-4">

        <div>
            <strong>Product code:</strong>
            <p>{{ product.product_code }}</p>
        </div>

        <div>
            <strong>Product name:</strong>
            <p>{{ product.product_name }}</p>
        </div>

        <div>
            <strong>Net price:</strong>
            <p>€ {{ product.net_price }}</p>
        </div>

        <div>
            <strong>VAT:</strong>
            <p>{{ product.vat_rate }}%</p>
        </div>

        <div>
            <strong>Stock quantity:</strong>
            <p>{{ product.stock_quantity }}</p>
        </div>

        <div>
            <strong>Created at:</strong>
            <p>{{ product.created_at }}</p>
        </div>

    </div>

    <div class="mt-6">

        <strong>Description:</strong>

        <div class="mt-2 p-4 border rounded">

            {{ product.description || 'No description' }}

        </div>

    </div>

    <div class="mt-6 flex gap-3">

        <Link
            :href="edit(product.id)"
            class="bg-green-600 text-white px-4 py-2 rounded"
        >
           Edit
        </Link>

        <Link
            href="/products"
            class="bg-gray-500 text-white px-4 py-2 rounded"
        >
        Cancel
        </Link>

    </div>

</div>

</template>