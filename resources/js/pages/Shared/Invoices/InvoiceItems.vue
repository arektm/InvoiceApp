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
</template>
