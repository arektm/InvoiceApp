<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import PageHeader from '@/components/invoices/PageHeader.vue';
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

const props = defineProps<{
    products: {
        data: Array<{
            id: number;
            product_code: string;
            product_name: string;
            net_price: number | string;
            vat_rate: number | string;
            stock_quantity: number;
        }>;
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
    };
    filters?: {
        search?: string;
    };
}>();

const search = ref(props.filters?.search ?? '');
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
    <Head title="Products" />

    <div class="space-y-6">
        <!-- Header -->
        <PageHeader
            title="Products"
            description="Manage your products, prices and inventory."
            actionButton="+ Add product"
            actionButtonAddress="/products/create"
            variant="btnBlack"
        />
        <!-- Main card -->
        <div class="overflow-hidden rounded-xl border border-border bg-card">
            <!-- Search -->
            <div class="border-b border-border p-5">
                <div class="relative max-w-xl">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                        />
                    </svg>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search products..."
                        class="w-full rounded-lg border border-border bg-background py-2.5 pr-4 pl-10 text-sm text-foreground transition outline-none placeholder:text-muted-foreground focus:border-primary focus:ring-2 focus:ring-primary/20"
                    />
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-border bg-muted/40">
                            <th
                                class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >
                                Code
                            </th>

                            <th
                                class="px-5 py-3 text-left text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >
                                Product
                            </th>

                            <th
                                class="px-5 py-3 text-right text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >
                                Net price
                            </th>

                            <th
                                class="px-5 py-3 text-right text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >
                                VAT
                            </th>

                            <th
                                class="px-5 py-3 text-right text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >
                                Stock
                            </th>

                            <th
                                class="px-5 py-3 text-center text-xs font-semibold tracking-wider text-muted-foreground uppercase"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="product in products?.data"
                            :key="product.id"
                            class="border-b border-border transition last:border-0 hover:bg-muted/30"
                        >
                            <!-- Code -->
                            <td class="px-5 py-3">
                                <span
                                    class="font-mono text-xs text-muted-foreground"
                                >
                                    {{ product.product_code || '—' }}
                                </span>
                            </td>

                            <!-- Product -->
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-primary/10 text-primary"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M20 7.5 12 3 4 7.5m16 0v9L12 21l-8-4.5v-9m16 0-8 4.5m0 0V21"
                                            />
                                        </svg>
                                    </div>

                                    <div>
                                        <p class="font-medium text-foreground">
                                            {{ product.product_name }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Net price -->
                            <td
                                class="px-5 py-3 text-right font-medium text-foreground"
                            >
                                € {{ Number(product.net_price).toFixed(2) }}
                            </td>

                            <!-- VAT -->
                            <td
                                class="px-5 py-3 text-right text-muted-foreground"
                            >
                                {{ product.vat_rate }}%
                            </td>

                            <!-- Stock -->
                            <td class="px-5 py-3 text-right">
                                <span
                                    v-if="product.stock_quantity > 0"
                                    class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400"
                                >
                                    <span
                                        class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"
                                    ></span>

                                    {{ product.stock_quantity }}
                                </span>

                                <span
                                    v-else
                                    class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400"
                                >
                                    <span
                                        class="mr-1.5 h-1.5 w-1.5 rounded-full bg-red-500"
                                    ></span>

                                    Out of stock
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-3">
                                <div class="flex justify-center gap-2">
                                    <Link
                                        :href="`/products/${product.id}`"
                                        class="inline-flex items-center rounded-lg border border-border bg-background px-3 py-1.5 text-xs font-medium text-foreground transition hover:bg-muted"
                                    >
                                        View
                                    </Link>

                                    <Link
                                        :href="`/products/${product.id}/edit`"
                                        class="inline-flex items-center rounded-lg bg-primary px-3 py-1.5 text-xs font-medium text-primary-foreground transition hover:bg-primary/90"
                                    >
                                        Edit
                                    </Link>
                                </div>
                            </td>
                        </tr>

                        <!-- Empty state -->
                        <tr v-if="!products?.data?.length">
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div
                                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-muted text-muted-foreground"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M20 13V7.5L12 3 4 7.5V13m16 0-8 4.5M20 13l-8 4.5M4 13l8 4.5m0 0V21"
                                        />
                                    </svg>
                                </div>

                                <p class="mt-4 font-medium text-foreground">
                                    No products found
                                </p>

                                <p class="mt-1 text-sm text-muted-foreground">
                                    Try changing your search or add a new
                                    product.
                                </p>

                                <Link
                                    href="/products/create"
                                    class="mt-4 inline-flex items-center rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground transition hover:bg-primary/90"
                                >
                                    Add product
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div
                v-if="products?.data?.length"
                class="border-t border-border px-5 py-4"
            >
                <Pagination :links="products?.links" />
            </div>
        </div>
    </div>
</template>
