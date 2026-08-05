<script setup lang="ts">
import {
    computed,
    ref,
    onMounted,
    onBeforeUnmount
} from 'vue'

const props = defineProps({
    products: {
        type: Array,
        required: true
    },

    modelValue: {
        type: Object,
        required: true
    }
})

const emit = defineEmits([
    'update:modelValue'
])

const open = ref(false)
const dropdownRef = ref(null)

const filteredProducts = computed(() => {

    const q =
        props.modelValue.product_name
            ?.toLowerCase()
            .trim()

    if (!q) {
        return props.products
    }

    return props.products.filter(product =>
        product.product_name
            .toLowerCase()
            .includes(q)
    )
})

function selectProduct(product) {

    emit('update:modelValue', {
        ...props.modelValue,
        product_id: product.id,
        product_name: product.product_name
    })

    open.value = false
}

function closeOutside(event) {

    if (
        dropdownRef.value &&
        !dropdownRef.value.contains(event.target)
    ) {
        open.value = false
    }
}

onMounted(() => {
    document.addEventListener(
        'click',
        closeOutside
    )
})

onBeforeUnmount(() => {
    document.removeEventListener(
        'click',
        closeOutside
    )
})
</script>

<template>

    <div
        class="relative"
        ref="dropdownRef"
    >

        <input
            :value="modelValue.product_name"
            type="text"
            autocomplete="off"
            placeholder="Select product..."
            class="w-full border rounded p-2"
            @focus="open = true"
            @keydown.escape="open = false"
            @input="
                emit(
                    'update:modelValue',
                    {
                        ...modelValue,
                        product_name: $event.target.value
                    }
                )
            "
        >

        <div
            v-if="open"
            class="absolute z-50 bg-secondary border rounded shadow w-full max-h-60 overflow-y-auto"
        >

            <div
                v-for="product in filteredProducts"
                :key="product.id"
                class="p-2 border-b cursor-pointer hover:bg-gray-100"
                @click="selectProduct(product)"
            >

                <div class="font-medium">
                    {{ product.product_name }}
                </div>

                <div class="text-sm text-gray-500">
                    € {{ product.net_price }}

                    <span class="ml-2 text-xs">
                        VAT {{ product.vat_rate }}%
                    </span>
                </div>

            </div>

            <div
                v-if="filteredProducts.length === 0"
                class="p-2 text-gray-500"
            >
                No products found
            </div>

        </div>

    </div>

</template>