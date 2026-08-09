<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { index, create, edit, show } from '@/routes/clients';
import Pagination from '../Shared/Pagination.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Clients',
                href: index(),
            },
        ],
    },
});

const props = defineProps({
    clients: Object,
    filters: Object,
});

const search = ref(props.filters?.search ?? '');

watch(search, (value) => {
    router.get(
        index(),
        {
            search: value,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
});
</script>

<template>
    <Head title="Clients" />

    <div class="space-y-6">
        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <div
                    class="flex items-center gap-2 text-sm text-muted-foreground"
                >
                    <Users class="h-4 w-4" />

                    <span>Clients</span>
                </div>

                <h1 class="mt-1 text-3xl font-semibold tracking-tight">
                    Clients
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    Manage your client list and contact information.
                </p>
            </div>

            <Link
                :href="create()"
                class="inline-flex h-9 items-center justify-center rounded-lg bg-primary px-4 text-sm font-medium text-primary-foreground text-secondary shadow-sm transition-colors hover:bg-primary/80 disabled:pointer-events-none disabled:opacity-50"
            >
                New client
            </Link>
        </div>

        <!-- Search -->
        <div
            class="rounded-xl border bg-card p-4 shadow-sm transition-shadow hover:shadow-md"
        >
            <input
                v-model="search"
                type="text"
                placeholder="Search for client..."
                class="w-full rounded-lg border bg-background px-3 py-2 text-sm shadow-sm transition-colors hover:bg-muted/40 focus-visible:ring-1 focus-visible:ring-ring focus-visible:outline-none disabled:pointer-events-none disabled:opacity-50"
            />
        </div>

        <!-- Table Card -->
        <div class="overflow-hidden rounded-xl border bg-card shadow-sm">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b bg-muted/30">
                        <th
                            class="p-4 text-sm font-medium text-muted-foreground"
                        >
                            Company name
                        </th>

                        <th
                            class="p-4 text-sm font-medium text-muted-foreground"
                        >
                            Tax number
                        </th>

                        <th
                            class="p-4 text-sm font-medium text-muted-foreground"
                        >
                            E-mail
                        </th>

                        <th
                            class="p-4 text-sm font-medium text-muted-foreground"
                        >
                            Phone
                        </th>

                        <th
                            class="p-4 text-sm font-medium text-muted-foreground"
                        >
                            City
                        </th>

                        <th
                            class="p-4 text-center text-sm font-medium text-muted-foreground"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="client in clients?.data"
                        :key="client.id"
                        class="border-t transition-colors hover:bg-muted/20"
                    >
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-semibold text-blue-600 dark:bg-blue-950 dark:text-blue-400"
                                >
                                    {{ client.name?.charAt(0).toUpperCase() }}
                                </div>

                                <p class="font-medium">{{ client.name }}</p>
                            </div>
                        </td>

                        <td class="p-4 text-sm text-muted-foreground">
                            {{ client.tax_number || '-' }}
                        </td>

                        <td class="p-4 text-sm text-muted-foreground">
                            {{ client.email || '-' }}
                        </td>

                        <td class="p-4 text-sm text-muted-foreground">
                            {{ client.phone || '-' }}
                        </td>

                        <td class="p-4 text-sm text-muted-foreground">
                            {{ client.city || '-' }}
                        </td>

                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                <Link
                                    :href="show(client.id)"
                                    class="inline-flex h-8 w-18 items-center justify-center rounded-lg border bg-background text-xs font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                                    title="View details"
                                >
                                    View
                                </Link>

                                <Link
                                    :href="edit(client.id)"
                                    class="inline-flex h-8 w-18 items-center justify-center rounded-lg bg-primary text-xs font-medium text-primary-foreground shadow-sm transition transition-colors hover:bg-primary/90 disabled:pointer-events-none disabled:opacity-50"
                                    title="Edit details"
                                >
                                    Edit
                                </Link>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="clients?.data.length === 0">
                        <td
                            colspan="6"
                            class="p-8 text-center text-sm text-muted-foreground"
                        >
                            No clients available
                        </td>
                    </tr>
                </tbody>

                <tfoot v-if="clients?.data.length > 0">
                    <tr class="bg-muted/30 font-medium">
                        <td colspan="4" class="p-4 text-right text-sm">
                            Total clients:
                        </td>

                        <td
                            colspan="2"
                            class="p-4 text-left text-sm text-blue-600"
                        >
                            {{ clients?.data.length }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Pagination -->
        <Pagination :links="clients?.links" />
    </div>
</template>

<style scoped>
:deep(th) {
    font-weight: 600;
}

:deep(td) {
    font-size: 14px;
}
</style>
