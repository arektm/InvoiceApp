<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
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
const props = defineProps({

    todaySales: Number,

    monthSales: Number,

    yearSales: Number,

    invoiceCount: Number,

    unpaidInvoices: Number,

    overdueInvoices: Number,

    topClients: Array,

    topProducts: Array,
});
</script>

<template>
    <Head title="Reports" />

    <h1 class="mb-6 text-3xl font-bold">Reports</h1>

    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded p-6 shadow">
            <h3>Today's Sales</h3>

            <div class="text-3xl font-bold">€ {{ todaySales?.toFixed(2) }}</div>
        </div>

        <div class="rounded p-6 shadow">
            <h3>This Month</h3>

            <div class="text-3xl font-bold">€ {{ monthSales?.toFixed(2) }}</div>
        </div>

        <div class="rounded p-6 shadow">
            <h3>This Year</h3>

            <div class="text-3xl font-bold">€ {{ yearSales?.toFixed(2) }}</div>
        </div>
    </div>

    <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded p-6 shadow">
            <h3>Invoices</h3>

            <div class="text-3xl font-bold">
                {{ props.invoiceCount }}
            </div>
        </div>

        <div class="rounded p-6 shadow">
            <h3>Unpaid</h3>

            <div class="text-3xl font-bold">
                <Link href="/reports/unpaid-invoices">
                    {{ unpaidInvoices }}
                </Link>
            </div>
        </div>

        <div class="rounded p-6 shadow">
            <h3>Overdue</h3>

            <div class="text-3xl font-bold text-red-600">
                <Link href="/reports/overdue-invoices">
                    {{ overdueInvoices }}
                </Link>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded p-6 shadow">
            <h2 class="mb-4 text-xl font-bold">Top Clients</h2>

            <table class="w-full">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Revenue</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="client in topClients" :key="client.id">
                        <td>
                            {{ client.name }}
                        </td>

                        <td class="text-right">
                            €
                            {{
                                Number(
                                    client.invoices_sum_total_gross ?? 0,
                                ).toFixed(2)
                            }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="rounded p-6 shadow">
            <h2 class="mb-4 text-xl font-bold">Top Products</h2>

            <table class="w-full">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in topProducts" :key="item.product_id">
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
