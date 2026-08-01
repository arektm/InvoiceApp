<script setup>
import ComboboxProduct from './ComboboxProduct.vue'

const props = defineProps({
    items: Array,
    errors: Object,
    products: Array
})

const addItem = () => {
    props.items.push({
        product_id: '',
        product_name: '',
        quantity: 1
    })
}

const removeItem = (index) => {
    props.items.splice(index, 1)
}
</script>

<template>

<tbody>

<tr
    v-for="(item,index) in items"
    :key="index"
   class="flex"
>

    <td class="w-full p-2">

        <ComboboxProduct
            v-model="items[index]"
            :products="products"
        />

        <p
            v-if="errors[`items.${index}.product_id`]"
            class="text-red-500 text-sm mt-1"
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
            class="w-full border rounded p-2"
        >

    </td>

    <td class="p-2">

        <button
            type="button"
            class="bg-red-500 text-white px-2 py-1 rounded"
            @click="removeItem(index)"
        >
            Remove
        </button>

    </td>
    

</tr>


</tbody>
<button
    type="button"
    class="ml-3 mt-4 bg-gray-500 text-white px-4 py-2 rounded"
    @click="addItem"
>
    Add Product
</button>
</template>