<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    AlertCircle,
    ArrowRight,
    BarChart3,
    CalendarDays,
    CircleDollarSign,
    Clock3,
    FileText,
    Package,
    SquareX,
    Users,
} from '@lucide/vue';
import reports from '@/routes/reports';
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Reports',
                href: reports.index(),
            },
        ],
    },
});
interface TopClient {
    id: number;
    name: string;
    invoices_sum_total_gross: number | string | null;
}

interface Product {
    id: number;
    product_name: string;
}

interface TopProduct {
    product_id: number;
    total_quantity: number;
    product: Product | null;
}

const props = defineProps<{
    todaySales: number;
    monthSales: number;
    yearSales: number;
    invoiceCount: number;
    unpaidInvoices: number;
    cancelledInvoices: number;
    overdueInvoices: number;
    topClients: TopClient[];
    topProducts: TopProduct[];
}>();

const formatCurrency = (value: number | string | null) => {
    return new Intl.NumberFormat('en-IE', {
        style: 'currency',
        currency: 'EUR',
    }).format(Number(value ?? 0));
};

const formatNumber = (value: number | string | null) => {
    return new Intl.NumberFormat('en-IE').format(Number(value ?? 0));
};

const maxClientRevenue = () => {
    if (!props.topClients.length) {
        return 1;
    }

    return Math.max(
        ...props.topClients.map((client) =>
            Number(client.invoices_sum_total_gross ?? 0),
        ),
    );
};

const clientPercentage = (value: number | string | null) => {
    const max = maxClientRevenue();

    return Math.max(4, (Number(value ?? 0) / max) * 100);
};

const maxProductQuantity = () => {
    if (!props.topProducts.length) {
        return 1;
    }

    return Math.max(
        ...props.topProducts.map((item) => Number(item.total_quantity ?? 0)),
    );
};

const productPercentage = (value: number | string | null) => {
    const max = maxProductQuantity();

    return Math.max(4, (Number(value ?? 0) / max) * 100);
};
</script>

<template>
    <Head title="Reports" />

    <div class="space-y-8">
        <!-- Header -->
        <div
            class="flex flex-col gap-4 p-3 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="mt-1 text-3xl font-semibold tracking-tight">
                    Reports
                </h1>

                <p class="mt-1 text-sm text-muted-foreground">
                    Overview of your invoices, revenue and business activity.
                </p>
            </div>

            <div
                class="flex items-center gap-2 rounded-lg border bg-card px-3 py-2 text-sm text-muted-foreground shadow-sm"
            >
                <CalendarDays class="h-4 w-4" />

                <span>
                    {{
                        new Date().toLocaleDateString('en-IE', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric',
                        })
                    }}
                </span>
            </div>
        </div>

        <!-- Revenue cards -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <!-- Today -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Revenue today
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight">
                            {{ formatCurrency(todaySales) }}
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950 dark:text-blue-400"
                    >
                        <CircleDollarSign class="h-5 w-5" />
                    </div>
                </div>

                <div
                    class="mt-4 flex items-center gap-2 text-xs text-muted-foreground"
                >
                    <Clock3 class="h-3.5 w-3.5" />

                    <span>Issued today</span>
                </div>
            </div>

            <!-- Month -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Revenue this month
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight">
                            {{ formatCurrency(monthSales) }}
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50 text-violet-600 dark:bg-violet-950 dark:text-violet-400"
                    >
                        <BarChart3 class="h-5 w-5" />
                    </div>
                </div>

                <div
                    class="mt-4 flex items-center gap-2 text-xs text-muted-foreground"
                >
                    <CalendarDays class="h-3.5 w-3.5" />

                    <span>Current month</span>
                </div>
            </div>

            <!-- Year -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Revenue this year
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight">
                            {{ formatCurrency(yearSales) }}
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400"
                    >
                        <CircleDollarSign class="h-5 w-5" />
                    </div>
                </div>

                <div
                    class="mt-4 flex items-center gap-2 text-xs text-muted-foreground"
                >
                    <CalendarDays class="h-3.5 w-3.5" />

                    <span>Current year</span>
                </div>
            </div>

            <!-- Invoices -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Total invoices
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight">
                            {{ formatNumber(invoiceCount) }}
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300"
                    >
                        <FileText class="h-5 w-5" />
                    </div>
                </div>

                <div class="mt-4 text-xs text-muted-foreground">
                    All invoices in the system
                </div>
            </div>
        </div>

        <!-- Invoice status -->
        <div class="grid gap-4 lg:grid-cols-3">
            <!-- Unpaid -->
            <Link
                href="/reports/unpaid-invoices"
                class="group rounded-xl border bg-card p-6 shadow-sm transition-all hover:border-red-200 hover:shadow-md dark:hover:border-red-900"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-950 dark:text-amber-400"
                            >
                                <Clock3 class="h-4 w-4" />
                            </div>

                            <h2 class="font-semibold">Unpaid invoices</h2>
                        </div>

                        <p
                            class="mt-4 ml-7 text-3xl font-semibold tracking-tight text-amber-600"
                        >
                            {{ formatNumber(unpaidInvoices) }}
                        </p>

                        <p class="mt-1 text-sm text-muted-foreground">
                            Invoices awaiting payment
                        </p>
                    </div>

                    <!-- <span
                        class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700 dark:bg-amber-950 dark:text-amber-400"
                    >
                        Unpaid
                    </span> -->
                    <ArrowRight
                        class="h-5 w-5 text-muted-foreground transition-transform group-hover:translate-x-1"
                    />
                </div>
            </Link>
            <!-- Overdue -->
            <Link
                href="/reports/overdue-invoices"
                class="group rounded-xl border bg-card p-6 shadow-sm transition-all hover:border-red-200 hover:shadow-md dark:hover:border-red-900"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600 dark:bg-red-950 dark:text-red-400"
                            >
                                <AlertCircle class="h-4 w-4" />
                            </div>

                            <h2 class="font-semibold">Overdue invoices</h2>
                        </div>

                        <p
                            class="mt-4 ml-7 text-3xl font-semibold tracking-tight text-red-600"
                        >
                            {{ formatNumber(overdueInvoices) }}
                        </p>

                        <p class="mt-1 text-sm text-muted-foreground">
                            Payment deadline has passed
                        </p>
                    </div>

                    <ArrowRight
                        class="h-5 w-5 text-muted-foreground transition-transform group-hover:translate-x-1"
                    />
                </div>
            </Link>
            <!-- Cancelled Invoices -->
            <Link
                href="/reports/cancelled-invoices"
                class="group rounded-xl border bg-card p-6 shadow-sm transition-all hover:border-orange-200 hover:shadow-md dark:hover:border-orange-900"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <div
                                class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-50 text-orange-600 dark:bg-red-950 dark:text-orange-400"
                            >
                                <SquareX class="h-4 w-4" />
                            </div>

                            <h2 class="font-semibold">Cancelled invoices</h2>
                        </div>

                        <p
                            class="mt-4 ml-7 text-3xl font-semibold tracking-tight text-orange-600"
                        >
                            {{ formatNumber(cancelledInvoices) }}
                        </p>

                        <p class="mt-1 text-sm text-muted-foreground">
                            Invoices cancelled.
                        </p>
                    </div>

                    <ArrowRight
                        class="h-5 w-5 text-muted-foreground transition-transform group-hover:translate-x-1"
                    />
                </div>
            </Link>
        </div>

        <!-- Tables -->
        <div class="grid gap-6 xl:grid-cols-2">
            <!-- Top clients -->
            <div class="overflow-hidden rounded-xl border bg-card shadow-sm">
                <div
                    class="flex items-center justify-between border-b px-6 py-4"
                >
                    <div>
                        <div class="flex items-center gap-2">
                            <Users class="h-5 w-5 text-muted-foreground" />

                            <h2 class="font-semibold">Top clients</h2>
                        </div>

                        <p class="mt-1 text-xs text-muted-foreground">
                            Clients generating the highest revenue
                        </p>
                    </div>
                </div>

                <div v-if="topClients.length" class="divide-y">
                    <div
                        v-for="(client, index) in topClients"
                        :key="client.id"
                        class="px-6 py-4 transition-colors hover:bg-muted/40"
                    >
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-muted text-xs font-semibold"
                                >
                                    {{ index + 1 }}
                                </div>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium">
                                        {{ client.name }}
                                    </p>

                                    <div
                                        class="mt-2 h-1.5 w-32 overflow-hidden rounded-full bg-muted sm:w-48"
                                    >
                                        <div
                                            class="h-full rounded-full bg-blue-600 transition-all"
                                            :style="{
                                                width: `${clientPercentage(client.invoices_sum_total_gross)}%`,
                                            }"
                                        />
                                    </div>
                                </div>
                            </div>

                            <p class="shrink-0 text-sm font-semibold">
                                {{
                                    formatCurrency(
                                        client.invoices_sum_total_gross,
                                    )
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <div v-else class="px-6 py-12 text-center">
                    <Users class="mx-auto h-8 w-8 text-muted-foreground" />

                    <p class="mt-3 text-sm font-medium">No clients available</p>

                    <p class="mt-1 text-xs text-muted-foreground">
                        Client revenue data will appear here.
                    </p>
                </div>
            </div>

            <!-- Top products -->
            <div class="overflow-hidden rounded-xl border bg-card shadow-sm">
                <div
                    class="flex items-center justify-between border-b px-6 py-4"
                >
                    <div>
                        <div class="flex items-center gap-2">
                            <Package class="h-5 w-5 text-muted-foreground" />

                            <h2 class="font-semibold">Top products</h2>
                        </div>

                        <p class="mt-1 text-xs text-muted-foreground">
                            Most frequently sold products
                        </p>
                    </div>
                </div>

                <div v-if="topProducts.length" class="divide-y">
                    <div
                        v-for="(item, index) in topProducts"
                        :key="item.product_id"
                        class="px-6 py-4 transition-colors hover:bg-muted/40"
                    >
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-muted text-xs font-semibold"
                                >
                                    {{ index + 1 }}
                                </div>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium">
                                        {{
                                            item.product?.product_name ??
                                            'Unknown product'
                                        }}
                                    </p>

                                    <div
                                        class="mt-2 h-1.5 w-32 overflow-hidden rounded-full bg-muted sm:w-48"
                                    >
                                        <div
                                            class="h-full rounded-full bg-violet-600 transition-all"
                                            :style="{
                                                width: `${productPercentage(item.total_quantity)}%`,
                                            }"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="shrink-0 text-right">
                                <p class="text-sm font-semibold">
                                    {{ formatNumber(item.total_quantity) }}
                                </p>

                                <p class="text-xs text-muted-foreground">
                                    sold
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="px-6 py-12 text-center">
                    <Package class="mx-auto h-8 w-8 text-muted-foreground" />

                    <p class="mt-3 text-sm font-medium">
                        No products available
                    </p>

                    <p class="mt-1 text-xs text-muted-foreground">
                        Product statistics will appear here.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
