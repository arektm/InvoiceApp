<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PageHeader from '@/components/invoices/PageHeader.vue';
import ShowActions from '@/components/invoices/ShowActions.vue';
import { show, index } from '@/routes/products';

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
    <Head :title="`Product - ${product?.product_name}`" />

    <div class="space-y-6">
        <!-- Header -->
        <PageHeader
            title="Product Details"
            :item="product?.product_name"
            description="View product information and inventory details."
            actionButton="← Back to products"
            actionButtonAddress="/products"
            variant="btnWhite"
        />

        <!-- Product overview -->
        <div class="overflow-hidden rounded-xl border border-border bg-card">
            <!-- Product title -->
            <div class="border-b border-border px-6 py-5">
                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div class="flex items-center gap-4">
                        <!-- Product icon -->
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary"
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
                                    d="M20 7.5 12 3 4 7.5m16 0v9L12 21l-8-4.5v-9m16 0-8 4.5m-8-4.5 8 4.5m0 0V21"
                                />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-xl font-semibold text-foreground">
                                {{ product?.product_name }}
                            </h2>

                            <p class="mt-1 text-sm text-muted-foreground">
                                Product code:
                                <span class="font-medium text-foreground">
                                    {{ product?.product_code || '—' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Stock badge -->
                    <div>
                        <span
                            v-if="product?.stock_quantity > 0"
                            class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400"
                        >
                            <span
                                class="mr-2 h-1.5 w-1.5 rounded-full bg-emerald-500"
                            ></span>

                            In stock
                        </span>

                        <span
                            v-else
                            class="inline-flex items-center rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-500/10 dark:text-red-400"
                        >
                            <span
                                class="mr-2 h-1.5 w-1.5 rounded-full bg-red-500"
                            ></span>

                            Out of stock
                        </span>
                    </div>
                </div>
            </div>

            <!-- Product information -->
            <div class="p-6">
                <div
                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <!-- Net price -->
                    <div
                        class="rounded-xl border border-border bg-muted/30 p-5"
                    >
                        <p class="text-sm font-medium text-muted-foreground">
                            Net price
                        </p>

                        <p
                            class="mt-2 text-2xl font-bold tracking-tight text-foreground"
                        >
                            € {{ Number(product?.net_price ?? 0).toFixed(2) }}
                        </p>
                    </div>

                    <!-- VAT -->
                    <div
                        class="rounded-xl border border-border bg-muted/30 p-5"
                    >
                        <p class="text-sm font-medium text-muted-foreground">
                            VAT rate
                        </p>

                        <p
                            class="mt-2 text-2xl font-bold tracking-tight text-foreground"
                        >
                            {{ product?.vat_rate }}%
                        </p>
                    </div>

                    <!-- Stock -->
                    <div
                        class="rounded-xl border border-border bg-muted/30 p-5"
                    >
                        <p class="text-sm font-medium text-muted-foreground">
                            Stock quantity
                        </p>

                        <p
                            class="mt-2 text-2xl font-bold tracking-tight text-foreground"
                        >
                            {{ product?.stock_quantity ?? 0 }}
                        </p>
                    </div>

                    <!-- Created -->
                    <div
                        class="rounded-xl border border-border bg-muted/30 p-5"
                    >
                        <p class="text-sm font-medium text-muted-foreground">
                            Created
                        </p>

                        <p class="mt-2 text-lg font-semibold text-foreground">
                            {{ product?.created_at || '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="rounded-xl border border-border bg-card">
            <div class="border-b border-border px-6 py-5">
                <h2 class="text-lg font-semibold text-foreground">
                    Description
                </h2>

                <!-- <p class="mt-1 text-sm text-muted-foreground">
                    Additional information about this product.
                </p> -->
            </div>

            <div class="p-6">
                <div
                    class="rounded-lg border border-border bg-muted/30 p-5 text-sm leading-6 text-muted-foreground"
                >
                    {{ product?.description || 'No description available.' }}
                </div>
            </div>
        </div>

        <!-- Actions -->
        <ShowActions
            :indexUrl="index().url"
            showEdit
            editLabel="Edit Product"
            :edit-url="`/products/${product?.id}/edit`"
        />
    </div>
</template>
