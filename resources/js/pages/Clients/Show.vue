<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { edit, show } from '@/routes/clients';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Clients/Client view',
                href: show,
            },
        ],
    },
});
defineProps({
    client: Object,
});
</script>

<template>
    <Head :title="client?.name" />

    <div class="rounded p-6 shadow">
        <h1 class="mb-6 text-3xl font-bold">
            {{ client?.name }}
        </h1>

        <div class="grid grid-cols-2 gap-4">
            <p><strong>Tax number:</strong> {{ client?.tax_number }}</p>

            <p><strong>Phone:</strong> {{ client?.phone }}</p>

            <p><strong>E-mail:</strong> {{ client?.email }}</p>

            <p><strong>City:</strong> {{ client?.city }}</p>

            <p><strong>Country:</strong> {{ client?.country }}</p>
        </div>

        <div class="mt-4">
            <strong>Address:</strong>

            {{ client?.street }}

            {{ client?.postal_code }}
        </div>

        <div class="mt-6">
            <Link
                :href="edit(client?.id)"
                class="rounded bg-orange-600 px-4 py-2 text-white"
            >
                Edit
            </Link>
        </div>
    </div>
</template>
