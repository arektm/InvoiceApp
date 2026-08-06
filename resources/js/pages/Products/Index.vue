<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { index } from '@/routes/products';
import Pagination from '../Shared/Pagination.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Products',
                href: index(),
            },
        ],
    },
});

const props = defineProps({
    products: Object,
    filters: Object,
});

const search = ref(props.filters.search ?? '');

watch(search, (value) => {
    router.get(
        '/products',
        {
            search: value,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
});
</script>

<template>
    <Head>
        <title>Products</title>
    </Head>

    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Products</h1>

        <Link
            href="/products/create"
            class="rounded bg-blue-600 px-4 py-2 text-white"
        >
            Add product
        </Link>
    </div>

    <div class="mb-6">
        <input
            v-model="search"
            type="text"
            placeholder="Search for product ..."
            class="w-full rounded border p-2"
        />
    </div>

    <div class="overflow-hidden rounded shadow">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100 text-gray-500">
                    <th class="p-3 text-left">Code</th>

                    <th class="p-3 text-left">Product</th>

                    <th class="p-3 text-right">Net price</th>

                    <th class="p-3 text-right">VAT</th>

                    <th class="p-3 text-right">Stock quantity</th>

                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="product in products.data"
                    :key="product.id"
                    class="border-t"
                >
                    <td class="p-3">
                        {{ product.product_code }}
                    </td>

                    <td class="p-3">
                        {{ product.product_name }}
                    </td>

                    <td class="p-3 text-right">€ {{ product.net_price }}</td>

                    <td class="p-3 text-right">{{ product.vat_rate }}%</td>

                    <td class="p-3 text-right">
                        {{ product.stock_quantity }}
                    </td>

                    <td class="p-3 text-center">
                        <div class="flex justify-center gap-3">
                            <Link
                                :href="`/products/${product.id}`"
                                class="rounded bg-blue-600 px-5 py-1 text-white"
                            >
                                View
                            </Link>

                            <Link
                                :href="`/products/${product.id}/edit`"
                                class="rounded bg-orange-600 px-5 py-1 text-white"
                            >
                                Edit
                            </Link>
                        </div>
                    </td>
                </tr>

                <tr v-if="products.data === 0">
                    <td colspan="6" class="p-6 text-center">No products</td>
                </tr>
            </tbody>
        </table>
    </div>

    <Pagination :links="products.links" />
</template>
