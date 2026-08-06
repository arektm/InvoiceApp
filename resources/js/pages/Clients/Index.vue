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
    <Head>
        <title>Clients</title>
    </Head>

    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Clients</h1>

        <Link :href="create()" class="rounded bg-blue-600 px-4 py-2 text-white">
            New client
        </Link>
    </div>

    <div class="mb-6">
        <input
            v-model="search"
            type="text"
            placeholder="Search for client ..."
            class="w-full rounded border p-2"
        />
    </div>

    <div class="overflow-hidden rounded shadow">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100 dark:text-black">
                    <th class="p-3 text-left">Company name</th>

                    <th class="p-3 text-left">Tax number</th>

                    <th class="p-3 text-left">E-mail</th>

                    <th class="p-3 text-left">Phone</th>

                    <th class="p-3 text-left">City</th>

                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="client in clients?.data"
                    :key="client.id"
                    class="border-t"
                >
                    <td class="p-3">
                        {{ client.name }}
                    </td>

                    <td class="p-3">
                        {{ client.tax_number }}
                    </td>

                    <td class="p-3">
                        {{ client.email }}
                    </td>

                    <td class="p-3">
                        {{ client.phone }}
                    </td>

                    <td class="p-3">
                        {{ client.city }}
                    </td>

                    <td class="p-3 text-center">
                        <div class="flex justify-center gap-3">
                            <Link
                                :href="show(client.id)"
                                class="rounded bg-green-600 px-5 py-1 text-white"
                            >
                                View
                            </Link>

                            <Link
                                :href="edit(client.id)"
                                class="rounded bg-orange-600 px-5 py-1 text-white"
                            >
                                Edit
                            </Link>
                        </div>
                    </td>
                </tr>

                <tr v-if="clients?.data.length === 0">
                    <td colspan="6" class="p-6 text-center">No clients</td>
                </tr>
            </tbody>
        </table>
    </div>

    <Pagination :links="clients?.links" />
</template>
