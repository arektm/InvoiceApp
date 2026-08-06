<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { edit } from '@/routes/products/index.js';
import FormInput from '../Shared/FormInput.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Products/Edit product',
                href: edit,
            },
        ],
    },
});

const props = defineProps({
    product: Object,
    errors: Object,
});

const form = useForm({
    product_code: props.product?.product_code,

    product_name: props.product?.product_name,

    description: props.product?.description,

    net_price: props.product?.net_price,

    vat_rate: props.product?.vat_rate,

    stock_quantity: props.product?.stock_quantity,
});

const submit = () => {
    form.put(`/products/${props.product?.id}`);
};
const remove = () => {
    if (!confirm('Are you sure you want to delete this product? ')) {
        return;
    }

    form.delete(`/products/${props.product?.id}`);
};
</script>

<template>
    <Head>
        <title>Edit product</title>
    </Head>

    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Edit product</h1>
    </div>

    <form @submit.prevent="submit" class="rounded p-6 shadow">
        <div class="grid gap-4">
            <div>
                <FormInput
                    v-model="form.product_code"
                    id="product_code"
                    label="Product code"
                    :error="errors?.product_code"
                />
            </div>

            <div>
                <FormInput
                    v-model="form.product_name"
                    id="product_name"
                    label="Product name"
                    :error="errors?.product_name"
                />
            </div>

            <div>
                <label>Product description</label>

                <textarea
                    v-model="form.description"
                    rows="4"
                    class="w-full rounded border p-2"
                />
            </div>

            <div>
                <label>Net price</label>

                <input
                    v-model="form.net_price"
                    type="number"
                    step="0.01"
                    class="w-full rounded border p-2"
                />
            </div>

            <div>
                <label>VAT</label>

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
                <FormInput
                    v-model="form.stock_quantity"
                    id="stock_quantity"
                    label="Stock quantity"
                    type="number"
                    :error="errors?.stock_quantity"
                />
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button
                :disabled="form.processing"
                class="rounded bg-blue-600 px-6 py-2 text-white"
            >
                Save changes
            </button>

            <button
                type="button"
                @click="remove"
                class="rounded bg-red-600 px-6 py-2 text-white"
            >
                Delete
            </button>
            <Link
                href="/products"
                class="rounded bg-gray-500 px-4 py-2 text-white"
            >
                Cancel
            </Link>
        </div>
        <div
            v-if="$page.props.errors.delete"
            v-text="$page.props.errors.delete"
            class="text-red-500"
        ></div>
    </form>
</template>
