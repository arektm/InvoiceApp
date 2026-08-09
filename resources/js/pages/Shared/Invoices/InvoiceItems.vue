<script setup lang="ts">
import ComboboxProduct from './ComboboxProduct.vue';

const items = defineModel<any[]>('items', { default: () => [] });
defineProps<{
    errors: Record<string, string>;
    products: any[];
}>();
const addItem = () => {
    items.value.push({ product_id: '', product_name: '', quantity: 1 });
};

const removeItem = (index: number) => {
    items.value.splice(index, 1);
};
</script>

<!-- <template> 
    <tbody>
        <tr v-for="(item, index) in items" :key="index" class="flex">
            <td class="w-full p-2">
                <ComboboxProduct v-model="items[index]" :products="products" />
                <p
                    v-if="errors[`items.${index}.product_id`]"
                    class="mt-1 text-sm text-red-500"
                >
                    {{ errors[`items.${index}.product_id`] }}
                </p>
            </td>
            <td class="p-2">
                <input
                    v-model="item.quantity"
                    type="number"
                    min="1"
                    step="1"
                    class="w-full rounded border p-2"
                />
            </td>
            <td class="p-2">
                <button
                    type="button"
                    class="rounded bg-red-500 px-2 py-1 text-white"
                    @click="removeItem(index)"
                >
                    Remove
                </button>
            </td>
        </tr>
    </tbody>
    <button
        type="button"
        class="mt-4 ml-3 rounded bg-gray-500 px-4 py-2 text-white"
        @click="addItem"
    >
        Add Product
    </button>
</template> -->

<template>
    <tbody>
        <tr
            v-for="(item, index) in items"
            :key="index"
            class="flex items-start gap-2 border-b py-2 last:border-b-0"
        >
            <!-- Product -->
            <td class="w-100 min-w-0 flex-1 p-5">
                <ComboboxProduct
                    v-model="items[index]"
                    :products="products"
                    class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                />

                <p
                    v-if="errors[`items.${index}.product_id`]"
                    class="mt-1 text-xs text-red-500"
                >
                    {{ errors[`items.${index}.product_id`] }}
                </p>
            </td>

            <!-- Quantity -->
            <td class="w-28 p-2">
                <label
                    class="mb-1.5 block text-xs font-medium text-muted-foreground"
                >
                    Quantity
                </label>

                <input
                    v-model="item.quantity"
                    type="number"
                    min="1"
                    step="1"
                    class="flex h-9 w-full items-center rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                />
            </td>

            <!-- Remove -->
            <td class="p-2 pt-7">
                <button
                    type="button"
                    class="inline-flex h-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 px-3 text-sm font-medium text-red-600 shadow-sm transition-colors hover:bg-red-100 dark:border-red-900 dark:bg-red-950/30 dark:text-red-400 dark:hover:bg-red-950/50"
                    @click="removeItem(index)"
                >
                    Remove
                </button>
            </td>
        </tr>
    </tbody>

    <button
        type="button"
        class="mt-4 inline-flex h-9 items-center justify-center rounded-lg bg-blue-600 px-4 text-sm font-medium text-white shadow-sm transition-colors hover:bg-blue-600/90 disabled:pointer-events-none disabled:opacity-50"
        @click="addItem"
    >
        Add Product
    </button>
</template>
