<script setup lang="js">
import { computed, ref, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },

    modelValue: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue']);

const open = ref(false);
const dropdownRef = ref(null);

const filteredProducts = computed(() => {
    const q = props.modelValue.product_name?.toLowerCase().trim();

    if (!q) {
        return props.products;
    }

    return props.products.filter((product) =>
        product.product_name.toLowerCase().includes(q),
    );
});

function selectProduct(product) {
    emit('update:modelValue', {
        ...props.modelValue,
        product_id: product.id,
        product_name: product.product_name,
    });

    open.value = false;
}

function closeOutside(event) {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        open.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', closeOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', closeOutside);
});
</script>

<!-- <template>
    <div class="relative" ref="dropdownRef">
        <input
            :value="modelValue.product_name"
            type="text"
            autocomplete="off"
            placeholder="Select product..."
            class="w-full rounded border p-2"
            @focus="open = true"
            @keydown.escape="open = false"
            @input="
                emit('update:modelValue', {
                    ...modelValue,
                    product_name: $event.target.value,
                })
            "
        />

        <div
            v-if="open"
            class="absolute z-50 max-h-60 w-full overflow-y-auto rounded border bg-secondary shadow"
        >
            <div
                v-for="product in filteredProducts"
                :key="product.id"
                class="cursor-pointer border-b p-2 hover:bg-gray-100"
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

            <div v-if="filteredProducts.length === 0" class="p-2 text-gray-500">
                No products found
            </div>
        </div>
    </div>
</template> -->

<template>
    <div class="relative" ref="dropdownRef">
        <input
            :value="modelValue.product_name"
            type="text"
            autocomplete="off"
            placeholder="Select product..."
            class="flex w-full items-center rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-muted-foreground hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
            @focus="open = true"
            @keydown.escape="open = false"
            @input="
                emit('update:modelValue', {
                    ...modelValue,
                    product_name: $event.target.value,
                })
            "
        />

        <div
            v-if="open"
            class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-lg border bg-background shadow-lg"
        >
            <div
                v-for="product in filteredProducts"
                :key="product.id"
                class="cursor-pointer border-b px-3 py-2.5 transition-colors last:border-b-0 hover:bg-muted/60"
                @click="selectProduct(product)"
            >
                <div class="text-sm font-medium text-foreground">
                    {{ product.product_name }}
                </div>

                <div class="mt-0.5 text-sm text-muted-foreground">
                    € {{ product.net_price }}

                    <span class="ml-2 text-xs">
                        VAT {{ product.vat_rate }}%
                    </span>
                </div>
            </div>

            <div
                v-if="filteredProducts.length === 0"
                class="px-3 py-3 text-sm text-muted-foreground"
            >
                No products found
            </div>
        </div>
    </div>
</template>
