<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BarChart3,
    CircleDollarSign,
    Clock3,
    FileText,
    Plus,
    Receipt,
    UserPlus,
} from '@lucide/vue';
defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: 'dashboard/',
            },
        ],
    },
});
interface Client {
    id: number;
    name: string;
}

interface RecentInvoice {
    id: number;
    invoice_number: string;
    client: Client | null;
    issue_date: string;
    due_date: string;
    total_gross: number | string | null;
    status: 'paid' | 'unpaid' | 'cancelled';
}

interface PaymentStatus {
    paid: number;
    unpaid: number;
    overdue: number;
}

interface PaymentStatusPercentages {
    paid: number;
    unpaid: number;
    overdue: number;
}

const props = defineProps<{
    invoiceCount: number;
    paymentStatus: PaymentStatus;
    paymentStatusPercentages: PaymentStatusPercentages;
    recentInvoices: RecentInvoice[];
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

const formatDate = (value: string) => {
    return new Date(value).toLocaleDateString('en-IE', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};

const statusLabel = (status: RecentInvoice['status']) => {
    const labels: Record<RecentInvoice['status'], string> = {
        paid: 'Paid',
        unpaid: 'Unpaid',
        cancelled: 'Cancelled',
    };

    return labels[status];
};

const statusClass = (status: RecentInvoice['status']) => {
    const classes: Record<RecentInvoice['status'], string> = {
        paid: 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400',
        unpaid: 'bg-amber-50 text-amber-700 dark:bg-amber-950 dark:text-amber-400',
        cancelled:
            'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
    };

    return classes[status];
};

const pieStyle = () => {
    const paid = props.paymentStatusPercentages.paid;
    const unpaid = props.paymentStatusPercentages.unpaid;
    // const overdue = props.paymentStatusPercentages.overdue;

    const paidEnd = paid;
    const unpaidEnd = paid + unpaid;

    return {
        background: `conic-gradient(
            #10b981 0% ${paidEnd}%,
            #f59e0b ${paidEnd}% ${unpaidEnd}%,
            #ef4444 ${unpaidEnd}% 100%
        )`,
    };
};
</script>

<template>
    <Head title="Dashboard" />

    <div class="space-y-8">
        <!-- Header -->
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <div
                    class="flex items-center gap-2 text-sm text-muted-foreground"
                >
                    <BarChart3 class="h-4 w-4" />
                    <span>Business overview</span>
                </div>

                <h1 class="mt-1 ml-3 text-3xl font-semibold tracking-tight">
                    Dashboard
                </h1>
            </div>

            <div
                class="flex items-center gap-2 rounded-lg border bg-card px-3 py-2 text-sm text-muted-foreground shadow-sm"
            >
                <Clock3 class="h-4 w-4" />

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

        <!-- Quick actions -->
        <div>
            <div class="mb-4">
                <h2 class="font-semibold">Quick actions</h2>

                <p class="mt-1 text-sm text-muted-foreground">
                    Frequently used actions.
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <!-- New invoice -->
                <Link
                    href="/invoices/create"
                    class="group rounded-xl border bg-card p-5 shadow-sm transition-all hover:border-blue-300 hover:shadow-md dark:hover:border-blue-800"
                >
                    <div class="flex items-center justify-between">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950 dark:text-blue-400"
                        >
                            <Receipt class="h-5 w-5" />
                        </div>

                        <ArrowRight
                            class="h-5 w-5 text-muted-foreground transition-transform group-hover:translate-x-1"
                        />
                    </div>

                    <h3 class="mt-4 font-semibold">New Invoice</h3>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Create a new invoice for a client.
                    </p>
                </Link>

                <!-- Add client -->
                <Link
                    href="/clients/create"
                    class="group rounded-xl border bg-card p-5 shadow-sm transition-all hover:border-violet-300 hover:shadow-md dark:hover:border-violet-800"
                >
                    <div class="flex items-center justify-between">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50 text-violet-600 dark:bg-violet-950 dark:text-violet-400"
                        >
                            <UserPlus class="h-5 w-5" />
                        </div>

                        <ArrowRight
                            class="h-5 w-5 text-muted-foreground transition-transform group-hover:translate-x-1"
                        />
                    </div>

                    <h3 class="mt-4 font-semibold">Add Client</h3>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Add a new customer to your client list.
                    </p>
                </Link>

                <!-- Reports -->
                <Link
                    href="/reports"
                    class="group rounded-xl border bg-card p-5 shadow-sm transition-all hover:border-emerald-300 hover:shadow-md dark:hover:border-emerald-800"
                >
                    <div class="flex items-center justify-between">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400"
                        >
                            <BarChart3 class="h-5 w-5" />
                        </div>

                        <ArrowRight
                            class="h-5 w-5 text-muted-foreground transition-transform group-hover:translate-x-1"
                        />
                    </div>

                    <h3 class="mt-4 font-semibold">Reports</h3>

                    <p class="mt-1 text-sm text-muted-foreground">
                        View revenue and business reports.
                    </p>
                </Link>
            </div>
        </div>

        <!-- Overview -->
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <!-- Total invoices -->
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

                <p class="mt-4 text-xs text-muted-foreground">
                    All invoices in the system
                </p>
            </div>

            <!-- Paid -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Paid invoices
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight">
                            {{ formatNumber(paymentStatus.paid) }}
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400"
                    >
                        <CircleDollarSign class="h-5 w-5" />
                    </div>
                </div>

                <p class="mt-4 text-xs text-muted-foreground">
                    {{ paymentStatusPercentages.paid }}% of active invoices
                </p>
            </div>

            <!-- Unpaid -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">
                            Unpaid invoices
                        </p>

                        <p class="mt-2 text-2xl font-semibold tracking-tight">
                            {{
                                formatNumber(
                                    paymentStatus.unpaid +
                                        paymentStatus.overdue,
                                )
                            }}
                        </p>
                    </div>

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-950 dark:text-amber-400"
                    >
                        <Clock3 class="h-5 w-5" />
                    </div>
                </div>

                <p class="mt-4 text-xs text-muted-foreground">
                    Including overdue invoices
                </p>
            </div>
        </div>

        <!-- Payment status -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Pie chart -->
            <div class="rounded-xl border bg-card p-6 shadow-sm">
                <div>
                    <h2 class="font-semibold">Payment status</h2>

                    <p class="mt-1 text-xs text-muted-foreground">
                        Distribution of active invoices by payment status.
                    </p>
                </div>

                <div
                    v-if="invoiceCount"
                    class="mt-8 flex flex-col items-center justify-center gap-8 sm:flex-row"
                >
                    <!-- Pie -->
                    <div class="relative shrink-0">
                        <div
                            class="h-48 w-48 rounded-full"
                            :style="pieStyle()"
                        />

                        <!-- Hole -->
                        <div
                            class="absolute inset-0 m-auto flex h-24 w-24 flex-col items-center justify-center rounded-full bg-card"
                        >
                            <span class="text-2xl font-semibold">
                                {{ formatNumber(invoiceCount) }}
                            </span>

                            <span class="text-xs text-muted-foreground">
                                invoices
                            </span>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="w-full max-w-xs space-y-4">
                        <!-- Paid -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span
                                    class="h-3 w-3 rounded-full bg-emerald-500"
                                />

                                <span class="text-sm"> Paid </span>
                            </div>

                            <div class="text-right">
                                <span class="text-sm font-semibold">
                                    {{ paymentStatusPercentages.paid }}%
                                </span>

                                <span
                                    class="ml-2 text-xs text-muted-foreground"
                                >
                                    ({{ paymentStatus.paid }})
                                </span>
                            </div>
                        </div>

                        <!-- Unpaid -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span
                                    class="h-3 w-3 rounded-full bg-amber-500"
                                />

                                <span class="text-sm"> Unpaid </span>
                            </div>

                            <div class="text-right">
                                <span class="text-sm font-semibold">
                                    {{ paymentStatusPercentages.unpaid }}%
                                </span>

                                <span
                                    class="ml-2 text-xs text-muted-foreground"
                                >
                                    ({{ paymentStatus.unpaid }})
                                </span>
                            </div>
                        </div>

                        <!-- Overdue -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="h-3 w-3 rounded-full bg-red-500" />

                                <span class="text-sm"> Overdue </span>
                            </div>

                            <div class="text-right">
                                <span class="text-sm font-semibold">
                                    {{ paymentStatusPercentages.overdue }}%
                                </span>

                                <span
                                    class="ml-2 text-xs text-muted-foreground"
                                >
                                    ({{ paymentStatus.overdue }})
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty state -->
                <div
                    v-else
                    class="flex flex-col items-center justify-center py-16 text-center"
                >
                    <FileText class="h-10 w-10 text-muted-foreground" />

                    <p class="mt-3 text-sm font-medium">
                        No invoices available
                    </p>

                    <p class="mt-1 text-xs text-muted-foreground">
                        Payment statistics will appear here.
                    </p>
                </div>
            </div>

            <!-- Status summary -->
            <div class="rounded-xl border bg-card p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold">Payment overview</h2>

                        <p class="mt-1 text-xs text-muted-foreground">
                            Current invoice payment situation.
                        </p>
                    </div>

                    <Link
                        href="/reports"
                        class="text-sm font-medium text-primary hover:underline"
                    >
                        View reports
                    </Link>
                </div>

                <div class="mt-6 space-y-5">
                    <!-- Paid -->
                    <div>
                        <div
                            class="mb-2 flex items-center justify-between text-sm"
                        >
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-2.5 w-2.5 rounded-full bg-emerald-500"
                                />
                                <span>Paid</span>
                            </div>

                            <span class="font-medium">
                                {{ paymentStatus.paid }}
                            </span>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-muted">
                            <div
                                class="h-full rounded-full bg-emerald-500 transition-all"
                                :style="{
                                    width: `${paymentStatusPercentages.paid}%`,
                                }"
                            />
                        </div>
                    </div>

                    <!-- Unpaid -->
                    <div>
                        <div
                            class="mb-2 flex items-center justify-between text-sm"
                        >
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-2.5 w-2.5 rounded-full bg-amber-500"
                                />
                                <span>Unpaid</span>
                            </div>

                            <span class="font-medium">
                                {{ paymentStatus.unpaid }}
                            </span>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-muted">
                            <div
                                class="h-full rounded-full bg-amber-500 transition-all"
                                :style="{
                                    width: `${paymentStatusPercentages.unpaid}%`,
                                }"
                            />
                        </div>
                    </div>

                    <!-- Overdue -->
                    <div>
                        <div
                            class="mb-2 flex items-center justify-between text-sm"
                        >
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-2.5 w-2.5 rounded-full bg-red-500"
                                />
                                <span>Overdue</span>
                            </div>

                            <span class="font-medium text-red-600">
                                {{ paymentStatus.overdue }}
                            </span>
                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-muted">
                            <div
                                class="h-full rounded-full bg-red-500 transition-all"
                                :style="{
                                    width: `${paymentStatusPercentages.overdue}%`,
                                }"
                            />
                        </div>
                    </div>
                </div>

                <div class="mt-8 rounded-lg border bg-muted/30 p-4">
                    <div class="flex items-start gap-3">
                        <Clock3
                            class="mt-0.5 h-4 w-4 shrink-0 text-muted-foreground"
                        />

                        <div>
                            <p class="text-sm font-medium">Overdue invoices</p>

                            <p class="mt-1 text-xs text-muted-foreground">
                                {{ formatNumber(paymentStatus.overdue) }}
                                invoices have passed their payment deadline.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent invoices -->
        <div class="overflow-hidden rounded-xl border bg-card shadow-sm">
            <div class="flex items-center justify-between border-b px-6 py-4">
                <div>
                    <div class="flex items-center gap-2">
                        <FileText class="h-5 w-5 text-muted-foreground" />

                        <h2 class="font-semibold">Recent invoices</h2>
                    </div>

                    <p class="mt-1 text-xs text-muted-foreground">
                        Your latest invoices.
                    </p>
                </div>

                <Link
                    href="/invoices"
                    class="flex items-center gap-1 text-sm font-medium text-primary hover:underline"
                >
                    View all

                    <ArrowRight class="h-4 w-4" />
                </Link>
            </div>

            <div v-if="recentInvoices.length" class="divide-y">
                <Link
                    v-for="invoice in recentInvoices"
                    :key="invoice.id"
                    :href="`/invoices/${invoice.id}`"
                    class="flex flex-col gap-3 px-6 py-4 transition-colors hover:bg-muted/40 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div class="flex min-w-0 items-center gap-3">
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-muted"
                        >
                            <FileText class="h-4 w-4 text-muted-foreground" />
                        </div>

                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium">
                                {{ invoice.invoice_number }}
                            </p>

                            <p
                                class="mt-1 truncate text-xs text-muted-foreground"
                            >
                                {{ invoice.client?.name ?? 'Unknown client' }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between gap-6 sm:justify-end"
                    >
                        <div class="text-left sm:text-right">
                            <p class="text-sm font-semibold">
                                {{ formatCurrency(invoice.total_gross) }}
                            </p>

                            <p class="mt-1 text-xs text-muted-foreground">
                                {{ formatDate(invoice.issue_date) }}
                            </p>
                        </div>

                        <span
                            class="rounded-full px-2.5 py-1 text-xs font-medium"
                            :class="statusClass(invoice.status)"
                        >
                            {{ statusLabel(invoice.status) }}
                        </span>
                    </div>
                </Link>
            </div>

            <div
                v-else
                class="flex flex-col items-center justify-center px-6 py-12 text-center"
            >
                <FileText class="h-8 w-8 text-muted-foreground" />

                <p class="mt-3 text-sm font-medium">No invoices yet</p>

                <p class="mt-1 text-xs text-muted-foreground">
                    Create your first invoice to get started.
                </p>

                <Link
                    href="/invoices/create"
                    class="mt-4 inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-colors hover:bg-primary/90"
                >
                    <Plus class="h-4 w-4" />
                    New Invoice
                </Link>
            </div>
        </div>
    </div>
</template>
