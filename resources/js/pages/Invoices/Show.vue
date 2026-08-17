<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import InvoiceStatusBadge from '@/components/invoices/InvoiceStatusBadge.vue';
import { print, pdf, show } from '@/routes/invoices';
// import { destroy, print } from '@/actions/App/Http/Controllers/InvoiceController';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Invoices/Invoice view',
                href: show,
            },
        ],
    },
});

// type InvoiceStatus = 'paid' | 'unpaid' | 'cancelled';
// const { canEditInvoices, canDeleteInvoices } = usePermissions();
defineProps({
    invoice: Object,
});

// const statusConfig: Record<InvoiceStatus, { label: string; class: string }> = {
//     paid: {
//         label: 'Paid',
//         class: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-400',
//     },
//     unpaid: {
//         label: 'Unpaid',
//         class: 'bg-amber-100 text-amber-700 dark:bg-amber-950/30 dark:text-amber-400',
//     },
//     cancelled: {
//         label: 'Cancelled',
//         class: 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
//     },
// };

// const isConfirmOpen = ref(false);

// const openConfirmModal = () => {
//     isConfirmOpen.value = true;
// };
// const confirmRemove = () => {
//     isConfirmOpen.value = false;

//     if (props.invoice?.id) {
//         router.delete(destroy(props.invoice.id).url);
//     }
// };
</script>

<template>
    <Head :title="invoice?.invoice_number || 'Invoice'" />

    <div class="space-y-8">
        <!-- Header -->
        <div
            class="mb-6 flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div>
                <h1 class="mt-1 text-3xl font-semibold tracking-tight">
                    Invoice {{ invoice?.invoice_number }}
                </h1>

                <InvoiceStatusBadge
                    :status="invoice?.status"
                    :overdue="invoice?.overdue"
                />
            </div>

            <div class="flex items-center gap-2">
                <Link
                    :href="pdf(invoice?.id)?.url"
                    target="_blank"
                    class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                >
                    Download PDF
                </Link>

                <Link
                    :href="print(invoice?.id)?.url"
                    target="_blank"
                    class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                >
                    Print
                </Link>

                <Link
                    href="/invoices/"
                    class="inline-flex h-9 items-center justify-center rounded-lg border bg-background px-4 text-sm font-medium shadow-sm transition-colors hover:bg-muted disabled:pointer-events-none disabled:opacity-50"
                >
                    Back
                </Link>
            </div>
        </div>

        <!-- Invoice data -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Client Card -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="mb-4 flex items-center gap-2 text-muted-foreground">
                    <Users class="h-5 w-5" />
                    <h2 class="text-sm font-medium tracking-tight uppercase">
                        Client Details
                    </h2>
                </div>

                <div class="space-y-3 text-sm">
                    <div>
                        <p class="font-semibold">{{ invoice?.client.name }}</p>
                        <p class="mt-1 text-muted-foreground">
                            {{ invoice?.client.street }}
                        </p>
                        <p class="text-muted-foreground">
                            {{ invoice?.client.postal_code }}
                            {{ invoice?.client.city }}
                        </p>
                    </div>

                    <div>
                        <p class="font-medium">Tax number</p>
                        <p class="mt-1 text-muted-foreground">
                            {{ invoice?.client.tax_number }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Invoice Info Card -->
            <div
                class="rounded-xl border bg-card p-5 shadow-sm transition-shadow hover:shadow-md"
            >
                <div class="mb-4 flex items-center gap-2 text-muted-foreground">
                    <CalendarDays class="h-5 w-5" />
                    <h2 class="text-sm font-medium tracking-tight uppercase">
                        Invoice Information
                    </h2>
                </div>

                <div
                    class="grid grid-cols-1 gap-x-8 gap-y-4 text-sm md:grid-cols-2"
                >
                    <!-- Column 1 -->
                    <div>
                        <p class="font-medium">Invoice number</p>
                        <p class="mt-1">{{ invoice?.invoice_number }}</p>
                    </div>

                    <div>
                        <p class="font-medium">Issue date</p>
                        <p class="mt-1">{{ invoice?.issue_date }}</p>
                    </div>

                    <div>
                        <p class="font-medium">Sale date</p>
                        <p class="mt-1">{{ invoice?.sale_date }}</p>
                    </div>

                    <!-- Column 2 -->
                    <div>
                        <p class="font-medium">Due date</p>
                        <p class="mt-1">{{ invoice?.due_date }}</p>
                    </div>

                    <div>
                        <p class="font-medium">Payment method</p>
                        <p class="mt-1">{{ invoice?.payment_method }}</p>
                    </div>

                    <div>
                        <p class="font-medium">Status</p>
                        <p class="mt-1">{{ invoice?.status }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="rounded-xl border bg-card shadow-sm">
            <div class="flex items-center justify-between border-b px-5 py-4">
                <div>
                    <div class="flex items-center gap-2 text-muted-foreground">
                        <Package class="h-5 w-5" />
                        <h2 class="font-semibold">Invoice Items</h2>
                    </div>

                    <p class="mt-1 text-xs text-muted-foreground">
                        Product breakdown with VAT calculations
                    </p>
                </div>
            </div>

            <div class="overflow-hidden">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b bg-muted/30">
                            <th
                                class="border p-4 text-left text-sm font-medium"
                            >
                                Product
                            </th>

                            <th
                                class="border p-4 text-right text-sm font-medium"
                            >
                                Quantity
                            </th>

                            <th
                                class="border p-4 text-right text-sm font-medium"
                            >
                                Unit net price
                            </th>

                            <th
                                class="border p-4 text-right text-sm font-medium"
                            >
                                Net value
                            </th>

                            <th
                                class="border p-4 text-right text-sm font-medium"
                            >
                                VAT value
                            </th>

                            <th
                                class="border p-4 text-right text-sm font-medium"
                            >
                                Gross value
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="item in invoice?.items"
                            :key="item.id"
                            class="border-b transition-colors last:border-b-0 hover:bg-muted/20"
                        >
                            <td class="p-4 text-sm">
                                {{ item.product_name }}
                            </td>

                            <td class="p-4 text-right text-sm">
                                {{ item.quantity }}
                            </td>

                            <td class="p-4 text-right text-sm">
                                € {{ item.unit_net_price || '0.00' }}
                            </td>

                            <td class="p-4 text-right text-sm font-medium">
                                € {{ item.net_value || '0.00' }}
                            </td>

                            <td class="p-4 text-right text-sm">
                                € {{ item.vat_value || '0.00' }}
                            </td>

                            <td
                                class="p-4 text-right text-sm font-semibold text-blue-600"
                            >
                                € {{ item.gross_value || '0.00' }}
                            </td>
                        </tr>

                        <tr
                            v-if="invoice?.items.length"
                            class="border-t bg-muted/30"
                        >
                            <td
                                colspan="5"
                                class="p-4 text-right text-sm font-medium"
                            >
                                Total:
                            </td>

                            <td class="p-4 text-right text-sm font-medium">
                                € {{ invoice?.total_net || '0.00' }}
                            </td>

                            <td class="p-4 text-right text-sm font-medium">
                                € {{ invoice?.total_vat || '0.00' }}
                            </td>

                            <td
                                class="p-4 text-right text-sm font-bold text-blue-600"
                            >
                                € {{ invoice?.total_gross || '0.00' }}
                            </td>
                        </tr>
                    </tbody>

                    <tfoot v-if="!invoice?.items?.length">
                        <tr>
                            <td
                                colspan="7"
                                class="p-8 text-center text-xs text-muted-foreground"
                            >
                                No items available for this invoice
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>
