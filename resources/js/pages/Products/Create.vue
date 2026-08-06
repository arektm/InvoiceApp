<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { create } from '@/routes/products';

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
});

const submit = () => {
    form.post('/products');
};
</script>

<template>
    <Head>
        <title>Add product</title>
    </Head>

    <div class="mb-6 flex justify-between">
        <h1 class="text-3xl font-bold">Add product</h1>
    </div>

    <form @submit.prevent="submit" class="rounded p-6 shadow">
        <div class="grid gap-4">
            <div>
                <label class="mb-1 block"> Product code </label>

                <input
                    v-model="form.product_code"
                    type="text"
                    class="w-full rounded border p-2"
                />

                <div
                    v-if="form.errors.product_code"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ form.errors.product_code }}
                </div>
            </div>

            <div>
                <label class="mb-1 block"> Product name </label>

                <input
                    v-model="form.product_name"
                    type="text"
                    class="w-full rounded border p-2"
                />

                <div
                    v-if="form.errors.product_name"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ form.errors.product_name }}
                </div>
            </div>

            <div>
                <label class="mb-1 block"> Product description </label>

                <textarea
                    v-model="form.description"
                    rows="4"
                    class="w-full rounded border p-2"
                />
            </div>

            <div>
                <label class="mb-1 block"> Net price </label>

                <input
                    v-model="form.net_price"
                    type="number"
                    step="0.01"
                    class="w-full rounded border p-2"
                />

                <div
                    v-if="form.errors.net_price"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ form.errors.net_price }}
                </div>
            </div>

            <div>
                <label class="mb-1 block"> VAT % </label>

                <select
                    v-model="form.vat_rate"
                    class="w-full rounded border bg-secondary p-2"
                >
                    <option :value="23">23%</option>
                    <option :value="8">8%</option>
                    <option :value="5">5%</option>
                    <option :value="0">0%</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block"> Stock quantity </label>

                <input
                    v-model="form.stock_quantity"
                    type="number"
                    min="0"
                    class="w-full rounded border p-2"
                />
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button
                :disabled="form.processing"
                class="rounded bg-blue-600 px-6 py-2 text-white"
            >
                Save
            </button>
            <Link
                href="/products"
                class="rounded bg-gray-500 px-4 py-2 text-white"
            >
                Cancel
            </Link>
        </div>
    </form>
</template>
