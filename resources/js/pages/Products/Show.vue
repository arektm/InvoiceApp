<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { show, edit } from '@/routes/products';

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
    product: Object,
});
</script>

<template>
    <Head>
        <title>{{ product?.product_name }}</title>
    </Head>

    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Product details</h1>
    </div>

    <div class="rounded p-6 shadow">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <strong>Product code:</strong>
                <p>{{ product?.product_code }}</p>
            </div>

            <div>
                <strong>Product name:</strong>
                <p>{{ product?.product_name }}</p>
            </div>

            <div>
                <strong>Net price:</strong>
                <p>€ {{ product?.net_price }}</p>
            </div>

            <div>
                <strong>VAT:</strong>
                <p>{{ product?.vat_rate }}%</p>
            </div>

            <div>
                <strong>Stock quantity:</strong>
                <p>{{ product?.stock_quantity }}</p>
            </div>

            <div>
                <strong>Created at:</strong>
                <p>{{ product?.created_at }}</p>
            </div>
        </div>

        <div class="mt-6">
            <strong>Description:</strong>

            <div class="mt-2 rounded border p-4">
                {{ product?.description || 'No description' }}
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <Link
                :href="edit(product?.id)"
                class="rounded bg-green-600 px-4 py-2 text-white"
            >
                Edit
            </Link>

            <Link
                href="/products"
                class="rounded bg-gray-500 px-4 py-2 text-white"
            >
                Cancel
            </Link>
        </div>
    </div>
</template>
