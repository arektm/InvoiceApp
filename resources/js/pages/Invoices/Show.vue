<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import { print, pdf, show, destroy } from '@/routes/invoices';
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


const props = defineProps({
    invoice: Object
})
// const form = useForm({
//     invoice_id: props.invoice.id
// })
const remove = () => {
    if (!confirm('Are you sure you want to delete the invoice? ')) {
        return
    }

    // form.delete(destroy(props.invoice.id))
    router.delete(destroy(props.invoice.id).url)
}
</script>

<template>

<Head>
    <title>{{ invoice.invoice_number }}</title>
</Head>

<div class="flex justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Invoice {{ invoice.invoice_number }} Invoice id {{ invoice.id }}
    </h1>

   

</div>

<!-- Invoice data -->

<div class="shadow rounded p-6 mb-6">

    <div class="grid grid-cols-2 gap-6">

        <div>

            <h2 class="font-bold mb-2">
                Client
            </h2>

            <p>{{ invoice.client.name }}</p>

            <p>
                {{ invoice.client.street }}
            </p>

            <p>
                {{ invoice.client.postal_code }}
                {{ invoice.client.city }}
            </p>

            <p>
                Tax number: {{ invoice.client.tax_number }}
            </p>

        </div>

        <div>

            <h2 class="font-bold mb-2">
                Invoice data
            </h2>

            <p>Invoice number: {{ invoice.invoice_number }}</p>

            <p>Issue date: {{ invoice.issue_date }}</p>

            <p>Sale date: {{ invoice.sale_date }}</p>

            <p>Invoice due date: {{ invoice.due_date }}</p>

            <p>Status: {{ invoice.status }}</p>

            <p>Payment metod: {{ invoice.payment_method }}</p>

        </div>

    </div>

</div>

<!-- Items -->

<div class="shadow rounded p-6">

    <h2 class="text-xl font-bold mb-4">
        Invoice items
    </h2>

    <table class="w-full border-collapse border">

        <thead>

            <tr class="bg-gray-100 dark:text-black">

                <th class="border p-2 text-left">
                    Product
                </th>

                <th class="border p-2 text-right">
                    Quantity
                </th>

                <th class="border p-2 text-right">
                    Unit net price
                </th>

                <th class="border p-2 text-right">
                    Net value
                </th>

                <th class="border p-2 text-right">
                    VAT value
                </th>

                <th class="border p-2 text-right">
                    Gross value
                </th>

            </tr>

        </thead>

        <tbody>

            <tr
                v-for="item in invoice.items"
                :key="item.id"
            >

                <td class="border p-2">
                    {{ item.product_name }}
                </td>

                <td class="border p-2 text-right">
                    {{ item.quantity }}
                </td>

                <td class="border p-2 text-right">
                    € {{ item.unit_net_price }}
                </td>

                <td class="border p-2 text-right">
                    € {{ item.net_value }}
                </td>

                <td class="border p-2 text-right">
                    € {{ item.vat_value }}
                </td>

                <td class="border p-2 text-right">
                    € {{ item.gross_value }}
                </td>

            </tr>

        </tbody>

        <tfoot>

            <tr class="font-bold bg-gray-50 dark:text-black">

                <td colspan="3" class="border p-2 text-right">
                    Total:
                </td>

                <td class="border p-2 text-right">
                    € {{ invoice.total_net }}
                </td>

                <td class="border p-2 text-right">
                    € {{ invoice.total_vat }}
                </td>

                <td class="border p-2 text-right">
                    € {{ invoice.total_gross }}
                </td>

            </tr>

        </tfoot>

    </table>

</div>
<div class="mt-6 ml-5 flex gap-3">
<!-- :href="`/invoices/${invoice.id}/pdf`" -->
    <a
        :href="pdf(invoice.id).url"
        target="_blank"
        class="bg-blue-600 text-white px-4 py-2 rounded"
    >
        Download PDF
    </a>
<!-- :href="`/invoices/${invoice.id}/print`" -->
    <a
        
        :href="print(invoice.id).url"
        target="_blank"
        class="bg-green-600 text-white px-4 py-2 rounded"
    >
        Print
    </a>
     <Link
        href="/invoices/"
        class="bg-gray-600 text-white px-4 py-2 rounded"
    >
        Back
    </Link>
     <button
            type="button"
            @click="remove"
            class="bg-red-600 text-white px-6 py-2 rounded"
                        >
            Delete
        </button>
    <!-- :href=router.get(print(invoice.id))  -->
    <!-- <button
        
        @click="router.post(send(invoice.id))"
        
        class="bg-blue-600 text-white px-4 py-2 rounded"
        >
        Send by Email
    </button> -->
    

</div>
</template>