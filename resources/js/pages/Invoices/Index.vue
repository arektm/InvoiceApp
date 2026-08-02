<script setup>

import { Head, Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

import { create, show, index } from '@/routes/invoices'

import Pagination from '../Shared/Pagination.vue'

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Invoices',
                href: index(),
            },
        ],
    },
});

const props = defineProps({
    invoices: Object,
    filters: Object,
})
const search = ref(props.filters.search ?? '')

watch(search, value => {

    router.get(
        '/invoices',
        {
            search: value,
        },
        {
            preserveState: true,
            replace: true,
        }
    )
})
</script>

<template>
<Head title="Invoices" ></Head>

<div class="flex justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Invoices
    </h1>

    <Link
    
        :href="create()"
        class="bg-blue-500 text-white px-4 py-2 rounded"
    >
        New Invoice
    </Link>

</div>
<div class="mb-6">

    <input
        v-model="search"
        type="text"
        placeholder=" Invoice number, client name, e-mail..."
        class="w-full border rounded p-2"
    >

</div>
<table class="w-full border-collapse border">

    <thead>
        <tr class="bg-gray-200 dark:text-black">

            <th class="border p-2 text-left">
                Number
            </th>

            <th class="border p-2 text-left">
                Client
            </th>

            <th class="border p-2 text-left">
                Issue Date
            </th>

            <th class="border p-2 text-right">
                Gross
            </th>

            <th class="border p-2 text-left">
                Status
            </th>

            <th class="border p-2">
                Actions
            </th>

        </tr>
    </thead>

    <tbody>

        <tr
            v-for="invoice in invoices.data"
            :key="invoice.id"
        >

            <td class="border p-2 hover:underline">
                <Link
                    :href="show(invoice.id)"
                >
                    {{ invoice.invoice_number }}
                </Link>

                
            </td>

            <td class="border p-2">
                {{ invoice.name }}
            </td>

            <td class="border p-2">
                {{ invoice.issue_date}}
            </td>

            <td class="border p-2 text-right">
                € {{ invoice.total_gross }}
            </td>

            <td class="border p-2">
                {{ invoice.status }}
            </td>

            <td class="flex gap-2 p-2">
                

                    <Link
                        
                        :href="`/invoices/${invoice.id}`"
                        class="bg-blue-600 text-white px-5 py-1 rounded"
                    >
                        View
                    </Link>
                    <Link
                        
                        :href="`/invoices/${invoice.id}/edit`"
                        class="bg-red-600 text-white px-5 py-1 rounded"
                    >
                        Edit
                    </Link>
                
            </td>

        </tr>

    </tbody>

</table>


<Pagination :links="invoices.links" /> 


</template>