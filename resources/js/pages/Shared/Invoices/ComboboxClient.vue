<script setup>
import {
    ref,
    computed,
    onMounted,
    onBeforeUnmount
} from 'vue'

const props = defineProps({
    clients: {
        type: Array,
        required: true
    },
    modelValue: {
        type: [String, Number],
        default: ''
    },
    error: String
})

const emit = defineEmits([
    'update:modelValue',
    'selected'
])

const dropdownRef = ref(null)
const search = ref('')
const open = ref(false)

const filteredClients = computed(() => {

    const q = search.value.trim().toLowerCase()

    if (!q) {
        return props.clients
    }

    return props.clients.filter(client =>
        client.name?.toLowerCase().includes(q) ||
        client.email?.toLowerCase().includes(q) ||
        client.tax_number?.toLowerCase().includes(q)
    )
})

function selectClient(client) {

    search.value = client.name

    emit('update:modelValue', client.id)
    emit('selected', client)

    open.value = false
}

function clearClient() {

    search.value = ''

    emit('update:modelValue', '')

    open.value = false
}

function handleClickOutside(event) {

    if (
        dropdownRef.value &&
        !dropdownRef.value.contains(event.target)
    ) {
        open.value = false
    }
}

onMounted(() => {

    const selectedClient = props.clients.find(
        client => client.id == props.modelValue
    )

    if (selectedClient) {
        search.value = selectedClient.name
    }

    document.addEventListener(
        'click',
        handleClickOutside
    )
})

onBeforeUnmount(() => {
    document.removeEventListener(
        'click',
        handleClickOutside
    )
})
</script>

<template>

    <div
        class="relative"
        ref="dropdownRef"
    >

        <div class="flex gap-1">

            <input
                v-model="search"
                type="text"
                autocomplete="off"
                placeholder="Search client..."
                class="w-full border rounded p-2"
                @focus="open = true"
                @keydown.escape="open = false"
            >

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
            class="absolute z-50 bg-secondary border rounded shadow mt-1 w-full max-h-60 overflow-y-auto"
        >

            <div
                v-for="client in filteredClients"
                :key="client.id"
                class="p-2 border-b cursor-pointer hover:bg-gray-100"
                @click="selectClient(client)"
            >
                <div class="font-medium">
                    {{ client.name }}
                </div>

                <div
                    v-if="client.email"
                    class="text-sm text-gray-500"
                >
                    {{ client.email }}
                </div>
            </div>

            <div
                v-if="filteredClients.length === 0"
                class="p-2 text-gray-500"
            >
                No clients found
            </div>

        </div>

        <p
            v-if="error"
            class="text-red-500 text-sm mt-1"
        >
            {{ error }}
        </p>

    </div>

</template>