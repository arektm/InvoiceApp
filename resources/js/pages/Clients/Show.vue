<script setup>


import { Head, Link } from '@inertiajs/vue3'
import { edit } from '@/routes/clients'

defineProps({
    client: Object
})


</script>

<template>

<Head :title="client.name" />

<div class="p-6 rounded shadow">

    <h1 class="text-3xl font-bold mb-6">

        {{ client.name }}

    </h1>

    <div class="grid grid-cols-2 gap-4">

        <p><strong>Tax number:</strong> {{ client.tax_number }}</p>

        <p><strong>Phone:</strong> {{ client.phone }}</p>

        <p><strong>E-mail:</strong> {{ client.email }}</p>

        <p><strong>City:</strong> {{ client.city }}</p>

        <p><strong>Country:</strong> {{ client.country }}</p>

    </div>

    <div class="mt-4">

        <strong>Address:</strong>

        {{ client.street }}

        {{ client.postal_code }}

    </div>

    <div class="mt-6">

        <Link
            :href="edit(client.id)"
            class="bg-orange-600 text-white px-4 py-2 rounded"
        >
            Edit
        </Link>

    </div>

</div>

</template>