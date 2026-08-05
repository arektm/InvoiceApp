<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'
import { index } from '@/routes/reports';

// import { reports_unpaid_invoices } from '@/routes/reports';
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Reports',
                href: index(),
            },
        ],
    },
});
 defineProps({

    todaySales: Number,

    monthSales: Number,

    yearSales: Number,

    invoiceCount: Number,

    unpaidInvoices: Number,

    overdueInvoices: Number,

    topClients: Array,

    topProducts: Array,
})

</script>

<template>

<Head title="Reports" />

<h1 class="text-3xl font-bold mb-6">
    Reports
</h1>

<div
    class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"
>

    <div
        class="shadow rounded p-6"
    >
        <h3>Today's Sales</h3>

        <div class="text-3xl font-bold">
            € {{ todaySales }}
        </div>
    </div>

    <div
        class="shadow rounded p-6"
    >
        <h3>This Month</h3>

        <div class="text-3xl font-bold">
            € {{ monthSales }}
        </div>
    </div>

    <div
        class="shadow rounded p-6"
    >
        <h3>This Year</h3>

        <div class="text-3xl font-bold">
            € {{ yearSales }}
        </div>
    </div>

</div>

<div
    class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"
>

    <div
        class="shadow rounded p-6"
    >
        <h3>Invoices</h3>

        <div class="text-3xl font-bold">
            {{ invoiceCount }}
        </div>
    </div>

    <div
        class="shadow rounded p-6"
    >
        <h3>Unpaid</h3>

        <div class="text-3xl font-bold">
            <Link
                href="/reports/unpaid-invoices"
            >
                {{ unpaidInvoices }}
            </Link>

        </div>
    </div>

    <div
        class=" shadow rounded p-6"
    >
        <h3>Overdue</h3>

        <div class="text-3xl font-bold text-red-600">
            <Link
                href="/reports/overdue-invoices"
            >
           {{ overdueInvoices }}
            </Link>
        </div>
    </div>

</div>

<div
    class="grid grid-cols-1 lg:grid-cols-2 gap-6"
>

    <div
        class=" shadow rounded p-6"
    >

        <h2 class="text-xl font-bold mb-4">
            Top Clients
        </h2>

        <table class="w-full">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Revenue</th>
                </tr>
            </thead>

            <tbody>

                <tr
                    v-for="client in topClients"
                    :key="client.id"
                >

                    <td>
                        {{ client.name }}
                    </td>

                    <td class="text-right">
                        €
                        {{
                            Number(
                                client.invoices_sum_total_gross ?? 0
                            ).toFixed(2)
                        }}
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

    <div
        class=" shadow rounded p-6"
    >

        <h2 class="text-xl font-bold mb-4">
            Top Products
        </h2>

        <table class="w-full">

            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
            </thead>

            <tbody>

                <tr
                    v-for="item in topProducts"
                    :key="item.product_id"
                >

                    <td>
                        {{ item.product?.product_name }}
                    </td>

                    <td class="text-center">
                        {{ item.total_quantity }}
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</div>

</template>