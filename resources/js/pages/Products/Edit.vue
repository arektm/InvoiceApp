<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import FormActions from '@/components/invoices/FormActions.vue';
import PageHeader from '@/components/invoices/PageHeader.vue';
import { edit, index } from '@/routes/products/index.js';
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
    <Head title="Edit product" />

    <div class="space-y-6">
        <!-- Header -->
        <PageHeader
            title="Edit"
            :item="product?.product_name"
            description="Update product details"
            actionButton="← Back to products"
            actionButtonAddress="/products"
            variant="btnWhite"
        />

        <!-- Form card -->
        <form
            @submit.prevent="submit"
            class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
        >
            <!-- Product information -->
            <div class="space-y-6">
                <div class="mb-6">
                    <h2
                        class="mb-4 flex items-center gap-2 text-sm font-medium text-muted-foreground"
                    >
                        Product information
                    </h2>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <!-- Product code -->
                    <div>
                        <FormInput
                            v-model="form.product_code"
                            id="product_code"
                            label="Product code"
                            :error="errors?.product_code"
                        />
                    </div>

                    <!-- Product name -->
                    <div>
                        <FormInput
                            v-model="form.product_name"
                            id="product_name"
                            label="Product name"
                            :error="errors?.product_name"
                        />
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label
                            for="description"
                            class="mb-2 block text-sm font-medium text-foreground"
                        >
                            Product description
                        </label>

                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            placeholder="Enter product description..."
                            class="w-full rounded-lg border border-border bg-background px-3 py-2.5 text-sm text-foreground transition outline-none placeholder:text-muted-foreground focus:border-primary focus:ring-2 focus:ring-primary/20"
                        ></textarea>

                        <p
                            v-if="errors?.description"
                            class="mt-1.5 text-sm text-red-500"
                        >
                            {{ errors.description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pricing & inventory -->
            <div class="border-b border-border p-6">
                <div class="mb-5">
                    <h2 class="text-lg font-semibold text-foreground">
                        Pricing & inventory
                    </h2>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Configure pricing, VAT and stock information.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    <!-- Net price -->
                    <div class="mt-3">
                        <label
                            for="net_price"
                            class="mb-2 block text-sm font-medium text-foreground"
                        >
                            Net price
                        </label>

                        <div class="relative">
                            <span
                                class="absolute top-1/2 left-3 -translate-y-1/2 text-sm text-muted-foreground"
                            >
                                €
                            </span>

                            <input
                                id="net_price"
                                v-model="form.net_price"
                                type="number"
                                step="0.01"
                                min="0"
                                placeholder="0.00"
                                class="w-full rounded-lg border border-border bg-background py-2.5 pr-3 pl-8 text-sm text-foreground transition outline-none placeholder:text-muted-foreground focus:border-primary focus:ring-2 focus:ring-primary/20"
                            />
                        </div>

                        <p
                            v-if="errors?.net_price"
                            class="mt-1.5 text-sm text-red-500"
                        >
                            {{ errors.net_price }}
                        </p>
                    </div>

                    <!-- VAT -->
                    <div class="mt-3">
                        <label
                            for="vat_rate"
                            class="mb-2 block text-sm font-medium text-foreground"
                        >
                            VAT rate
                        </label>

                        <select
                            id="vat_rate"
                            v-model="form.vat_rate"
                            class="w-full rounded-lg border border-border bg-background px-3 py-2.5 text-sm text-foreground transition outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                        >
                            <option :value="23">23%</option>
                            <option :value="8">8%</option>
                            <option :value="5">5%</option>
                            <option :value="0">0%</option>
                        </select>

                        <p
                            v-if="errors?.vat_rate"
                            class="mt-1.5 text-sm text-red-500"
                        >
                            {{ errors.vat_rate }}
                        </p>
                    </div>

                    <!-- Stock -->
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
            </div>

            <!-- Actions -->
            <FormActions
                :index-url="index().url"
                delete-label="Delete Product"
                save-label="Save Changes"
                :processing="form.processing"
                show-delete
                @delete="remove"
            />

            <!-- Delete error -->
            <div
                v-if="$page.props.errors.delete"
                class="border-t border-red-200 bg-red-50 px-6 py-4 text-sm text-red-600 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400"
            >
                {{ $page.props.errors.delete }}
            </div>
        </form>
    </div>
</template>
