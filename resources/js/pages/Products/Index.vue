<script setup>

import { Head, Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { index } from '@/routes/products';
import Pagination from '../Shared/Pagination.vue'

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
})

const search = ref(props.filters.search ?? '')



watch(search, value => {

    router.get(
        '/products',
        {
            search: value
        },
        {
            preserveState: true,
            replace: true
        }
    )
})

</script>

<template>

<Head>
    <title>Products</title>
</Head>

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Products
    </h1>

    <Link
        href="/products/create"
        class="bg-blue-600 text-white px-4 py-2 rounded"
    >
        Add product
    </Link>

</div>

<div class="mb-6">

    <input
        v-model="search"
        type="text"
        placeholder="Search for product ..."
        class="border rounded p-2 w-full"
    >

</div>

<div class="shadow rounded overflow-hidden">

    <table class="w-full">

        <thead>

            <tr class="bg-gray-100 text-gray-500">

                <th class="text-left p-3">
                    Code
                </th>

                <th class="text-left p-3">
                    Product
                </th>

                <th class="text-right p-3">
                    Net price
                </th>

                <th class="text-right p-3">
                    VAT
                </th>

                <th class="text-right p-3">
                    Stock quantity
                </th>

                <th class="text-center p-3">
                    Actions
                </th>

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

                <td class="p-3 text-right">
                    € {{ product.net_price }}
                </td>

                <td class="p-3 text-right">
                    {{ product.vat_rate }}%
                </td>

                <td class="p-3 text-right">
                    {{ product.stock_quantity }}
                </td>

                <td class="p-3 text-center">

                    <div class="flex gap-3 justify-center">

                        <Link
                            :href="`/products/${product.id}`"
                            class="bg-blue-600 text-white px-5 py-1 rounded"
                        >
                            View
                        </Link>

                        <Link
                            :href="`/products/${product.id}/edit`"
                            class="bg-orange-600 text-white px-5 py-1 rounded"
                        >
                            Edit
                        </Link>

                        

                    </div>

                </td>

            </tr>

            <tr v-if="products.data === 0">

                <td
                    colspan="6"
                    class="text-center p-6"
                >
                    No products
                </td>

            </tr>

        </tbody>

    </table>

</div>



<Pagination :links="products.links" /> 



</template>