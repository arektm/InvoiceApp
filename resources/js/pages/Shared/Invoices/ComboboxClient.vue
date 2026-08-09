<script setup lang="js">
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
    clients: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: [String, Number],
        default: '',
    },
    error: String,
});

const emit = defineEmits(['update:modelValue', 'selected']);

const dropdownRef = ref(null);
const search = ref('');
const open = ref(false);

const filteredClients = computed(() => {
    const q = search.value.trim().toLowerCase();

    if (!q) {
        return props.clients;
    }

    return props.clients.filter(
        (client) =>
            client.name?.toLowerCase().includes(q) ||
            client.email?.toLowerCase().includes(q) ||
            client.tax_number?.toLowerCase().includes(q),
    );
});

function selectClient(client) {
    search.value = client.name;

    emit('update:modelValue', client.id);
    emit('selected', client);

    open.value = false;
}

function clearClient() {
    search.value = '';

    emit('update:modelValue', '');

    open.value = false;
}

function handleClickOutside(event) {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
        open.value = false;
    }
}

onMounted(() => {
    const selectedClient = props.clients.find(
        (client) => client.id == props.modelValue,
    );

    if (selectedClient) {
        search.value = selectedClient.name;
    }

    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<!-- <template>
    <div class="relative" ref="dropdownRef">
        <div class="flex gap-1">
            <input
                v-model="search"
                type="text"
                autocomplete="off"
                placeholder="Search client..."
                class="w-full rounded border p-2"
                @focus="open = true"
                @keydown.escape="open = false"
            />

            <button
                v-if="modelValue"
                type="button"
                class="px-2 text-gray-400 hover:text-gray-600"
                @click="clearClient"
            >
                ✕
            </button>
        </div>

        <div
            v-if="open"
            class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded border bg-secondary shadow"
        >
            <div
                v-for="client in filteredClients"
                :key="client.id"
                class="cursor-pointer border-b p-2 hover:bg-gray-100"
                @click="selectClient(client)"
            >
                <div class="font-medium">
                    {{ client.name }}
                </div>

                <div v-if="client.email" class="text-sm text-gray-500">
                    {{ client.email }}
                </div>
            </div>

            <div v-if="filteredClients.length === 0" class="p-2 text-gray-500">
                No clients found
            </div>
        </div>

        <p v-if="error" class="mt-1 text-sm text-red-500">
            {{ error }}
        </p>
    </div>
</template> -->
<template>
    <div class="relative" ref="dropdownRef">
        <div class="flex w-full gap-2">
            <input
                v-model="search"
                type="text"
                autocomplete="off"
                placeholder="Search client..."
                class="w-full items-center rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors placeholder:text-muted-foreground hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
                @focus="open = true"
                @keydown.escape="open = false"
            />

            <button
                v-if="modelValue"
                type="button"
                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border bg-background text-sm text-muted-foreground shadow-sm transition-colors hover:bg-muted hover:text-foreground focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none"
                @click="clearClient"
            >
                ✕
            </button>
        </div>

        <div
            v-if="open"
            class="absolute z-50 mt-1 max-h-60 w-full overflow-y-auto rounded-lg border bg-background shadow-lg"
        >
            <div
                v-for="client in filteredClients"
                :key="client.id"
                class="cursor-pointer border-b px-3 py-2.5 transition-colors last:border-b-0 hover:bg-muted/60"
                @click="selectClient(client)"
            >
                <div class="text-sm font-medium text-foreground">
                    {{ client.name }}
                </div>

                <div
                    v-if="client.email"
                    class="mt-0.5 text-sm text-muted-foreground"
                >
                    {{ client.email }}
                </div>
            </div>

            <div
                v-if="filteredClients.length === 0"
                class="px-3 py-3 text-sm text-muted-foreground"
            >
                No clients found
            </div>
        </div>

        <p v-if="error" class="mt-1 text-xs text-red-500">
            {{ error }}
        </p>
    </div>
</template>
