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

<template>
    <tbody>
        <tr
            v-for="(item, index) in items"
            :key="index"
            class="flex items-start gap-2 border-b py-2 last:border-b-0"
        >
            <td class="mt-5 w-full p-2">
                <ComboboxProduct v-model="items[index]" :products="products" />
                <p
                    v-if="errors[`items.${index}.product_id`]"
                    class="mt-1 p-2 text-sm text-red-500"
                >
                    {{ errors[`items.${index}.product_id`] }}
                </p>
            </td>
            <td class="p-2">
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
            <td class="p-2 pt-7">
                <button
                    type="button"
                    class="btnDelete"
                    @click="removeItem(index)"
                >
                    Remove
                </button>
            </td>
        </tr>
    </tbody>
    <button type="button" class="btnBlack" @click="addItem">Add Product</button>
</template>
