<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { unpaidInvoices } from '@/routes/reports';
import Pagination from '../Shared/Pagination.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Reports/Unpaid invoices',
                href: unpaidInvoices(),
            },
        ],
    },
});



defineProps({
    invoices: Object
})

</script>

<template>

<Head title="Unpaid Invoices" />

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Unpaid invoices
    </h1>

    <Link
        href="/reports"
        class="bg-gray-600 text-white px-4 py-2 rounded"
    >
        Back
    </Link>

</div>

<div
    class="bg-white rounded shadow overflow-hidden"
>

    <table class="w-full">

        <thead>

            <tr
                class="bg-gray-100"
            >

                <th class="p-3 text-left">
                    Invoice
                </th>

                <th class="p-3 text-left">
                    Client
                </th>

                <th class="p-3 text-left">
                    Email
                </th>

                <th class="p-3">
                    Issue Date
                </th>

                <th class="p-3">
                    Due Date
                </th>

                <th class="p-3">
                    Overdue
                </th>

                <th class="p-3">
                    Amount
                </th>

                <th class="p-3">
                    Action
                </th>

            </tr>

        </thead>

        <tbody>

            <tr
                v-for="invoice in invoices.data"
                :key="invoice.id"
                class="border-t"
            >

                <td class="p-3">
                    {{ invoice.invoice_number }}
                </td>

                <td class="p-3">
                    {{ invoice.client_name }}
                </td>

                <td class="p-3">
                    {{ invoice.client_email }}
                </td>

                <td class="p-3 text-center">
                    {{ invoice.issue_date }}
                </td>

                <td class="p-3 text-center">
                    {{ invoice.due_date }}
                </td>

                <td
                    class="p-3 text-center"
                >

                    <span
                        v-if="invoice.days_overdue > 0"
                        class="text-red-600 font-bold"
                    >
                        {{ invoice.days_overdue }} days
                    </span>

                    <span
                        v-else
                        class="text-green-600"
                    >
                    {{ invoice.days_overdue }}
                        OK
                    </span>

                </td>

                <td class="p-3 text-right">
                    €
                    {{ Number(invoice.total_gross).toFixed(2) }}
                </td>

                <td class="p-3 text-center">

                    <Link
                        :href="`/invoices/${invoice.id}`"
                        class="text-blue-600"
                    >
                        View
                    </Link>

                </td>

            </tr>

        </tbody>

    </table>

</div>


<Pagination :links="invoices.links"/>
</template>