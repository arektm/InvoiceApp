<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import FormActions from '@/components/invoices/FormActions.vue';
import PageHeader from '@/components/invoices/PageHeader.vue';
import { create, index } from '@/routes/products';
import FormInput from '../Shared/FormInput.vue';

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
    <div class="space-y-6">
        <!-- Header -->
        <PageHeader
            title="Add produt"
            description="Create a new product and add it to your inventory."
            actionButton="← Back to products"
            actionButtonAddress="/products"
            variant="btnWhite"
        />

        <!-- Form card -->
        <form
            @submit.prevent="submit"
            class="rounded-xl border bg-card p-6 shadow-sm"
        >
            <div class="space-y-6">
                <!-- Product information -->
                <div>
                    <h2 class="text-lg font-semibold">Product information</h2>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Basic information about the product.
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Product code -->
                    <div>
                        <FormInput
                            v-model="form.product_code"
                            id="product_code"
                            type="text"
                            label="Product code"
                            :error="form.errors.product_code"
                            class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm shadow-sm transition outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                        />
                    </div>

                    <!-- Product name -->
                    <div>
                        <FormInput
                            v-model="form.product_name"
                            id="product_name"
                            type="text"
                            label="Product name"
                            :error="form.errors.product_name"
                            class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm shadow-sm transition outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                        />
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label
                        class="mb-2 block text-sm font-medium"
                        for="description"
                    >
                        Product description
                    </label>

                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="4"
                        placeholder="Enter product description..."
                        class="w-full resize-none rounded-lg border bg-background px-3 py-2.5 text-sm shadow-sm transition outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                    />

                    <div
                        v-if="form.errors.description"
                        class="mt-1.5 text-sm text-red-500"
                    >
                        {{ form.errors.description }}
                    </div>
                </div>

                <!-- Pricing & inventory -->
                <div class="border-t pt-6">
                    <h2 class="text-lg font-semibold">Pricing & inventory</h2>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Set the product price, VAT rate and available stock.
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    <!-- Net price -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium"
                            for="net_price"
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
                                class="w-full rounded-lg border bg-background py-2.5 pr-3 pl-8 text-sm shadow-sm transition outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                            />
                        </div>

                        <div
                            v-if="form.errors.net_price"
                            class="mt-1.5 text-sm text-red-500"
                        >
                            {{ form.errors.net_price }}
                        </div>
                    </div>

                    <!-- VAT -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium"
                            for="vat_rate"
                        >
                            VAT rate
                        </label>

                        <select
                            id="vat_rate"
                            v-model="form.vat_rate"
                            class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm shadow-sm transition outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                        >
                            <option :value="23">23%</option>

                            <option :value="8">8%</option>

                            <option :value="5">5%</option>

                            <option :value="0">0%</option>
                        </select>

                        <div
                            v-if="form.errors.vat_rate"
                            class="mt-1.5 text-sm text-red-500"
                        >
                            {{ form.errors.vat_rate }}
                        </div>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium"
                            for="stock_quantity"
                        >
                            Stock quantity
                        </label>

                        <input
                            id="stock_quantity"
                            v-model="form.stock_quantity"
                            type="number"
                            min="0"
                            placeholder="0"
                            class="w-full rounded-lg border bg-background px-3 py-2.5 text-sm shadow-sm transition outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
                        />

                        <div
                            v-if="form.errors.stock_quantity"
                            class="mt-1.5 text-sm text-red-500"
                        >
                            {{ form.errors.stock_quantity }}
                        </div>
                    </div>
                </div>

                <!-- Actions -->

                <FormActions
                    :index-url="index().url"
                    save-label="Save Product"
                    :processing="form.processing"
                />
            </div>
        </form>
    </div>
</template>
