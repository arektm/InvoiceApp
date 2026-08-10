<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 12px;
            line-height: 1.5;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .invoice {
            width: 100%;
        }

        /* Header */

        .header {
            width: 100%;
            margin-bottom: 28px;
        }

        .header-title {
            font-size: 26px;
            font-weight: bold;
            letter-spacing: -0.5px;
            margin: 0 0 8px 0;
            color: #111827;
        }

        .invoice-number {
            font-size: 14px;
            font-weight: bold;
            color: #374151;
        }

        .invoice-meta {
            margin-top: 10px;
            color: #6b7280;
            font-size: 11px;
        }

        .invoice-meta strong {
            color: #374151;
        }

        /* Customer / Seller */

        .row {
            width: 100%;
            margin-bottom: 25px;
        }

        .column {
            display: inline-block;
            vertical-align: top;
            width: 47%;
            padding: 14px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
        }

        /* .column + .column {
            margin-left: 20%;
        } */

        .section-title {
            margin: 0 0 10px 0;
            font-size: 12px;
            font-weight: bold;
            color: #374151;
            text-transform: uppercase;
        }

        .address {
            margin: 0;
            color: #4b5563;
            line-height: 1.6;
        }

        /* Items */

        .items-title {
            margin: 0 0 10px 0;
            font-size: 13px;
            font-weight: bold;
            color: #111827;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 7px 8px;
        }

        th {
            background: #f3f4f6;
            color: #374151;
            font-size: 10px;
            font-weight: bold;
            text-align: left;
        }

        td {
            color: #374151;
            background: #ffffff;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Summary */

        .summary {
            width: 45%;
            margin-left: auto;
            margin-top: 18px;
        }

        .summary th {
            background: #f9fafb;
            text-align: left;
        }

        .summary .total {
            background: #f3f4f6;
            font-size: 12px;
            font-weight: bold;
            color: #111827;
        }

        /* Footer */

        .footer {
            margin-top: 35px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 10px;
        }
    </style>
</head>

<body>
<div class="invoice">

    <!-- Header -->

    <div class="header">
        <h1 class="header-title">INVOICE</h1>

        <div class="invoice-number">
            Number:
            {{ $invoice->invoice_number }}
        </div>

        <div class="invoice-meta">
            <strong>Issue date:</strong>
            {{ $invoice->issue_date }}

            &nbsp;&nbsp;&nbsp;

            <strong>Due date:</strong>
            {{ $invoice->due_date }}
        </div>
    </div>

    <!-- Customer / Seller -->

    <div class="row">

        <div class="column">
            <h3 class="section-title">Customer</h3>

            <p class="address">
                {{ $invoice->client->name }}
                <br>

                TAX number:
                {{ $invoice->client->tax_number }}
                <br>

                {{ $invoice->client->street }}
                <br>

                {{ $invoice->client->postal_code }}
                {{ $invoice->client->city }}
            </p>
        </div>

        <div class="column">
            <h3 class="section-title">Seller</h3>

            <p class="address">
                {{ $company->name }}
                <br>

                TAX number:
                {{ $company->tax_number }}
                <br>

                {{ $company->street }}
                <br>

                {{ $company->postal_code }}
                {{ $company->city }}
            </p>
        </div>

    </div>

    <!-- Invoice items -->

    <div>
        <p class="items-title">
            Invoice items
        </p>

        <table>
            <thead>
                <tr>
                    <th class="text-center">No.</th>
                    <th>Product</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Unit price</th>
                    <th class="text-center">VAT</th>
                    <th class="text-right">Net value</th>
                    <th class="text-right">Gross value</th>
                </tr>
            </thead>

            <tbody>
                @foreach($invoice->items as $index => $item)
                    <tr>
                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $item->product->product_name }}
                        </td>

                        <td class="text-center">
                            {{ $item->quantity }}
                        </td>

                        <td class="text-right">
                            {{ number_format($item->unit_net_price,2) }}
                        </td>

                        <td class="text-center">
                            {{ $item->vat_rate }}%
                        </td>

                        <td class="text-right">
                            {{ number_format($item->net_value,2) }}
                        </td>

                        <td class="text-right">
                            {{ number_format($item->gross_value,2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->

        <table class="summary">
            <tr>
                <th>
                    Total net
                </th>

                <td class="text-right">
                    {{ number_format($invoice->total_net,2) }}
                </td>
            </tr>

            <tr>
                <th>
                    VAT
                </th>

                <td class="text-right">
                    {{ number_format($invoice->total_vat,2) }}
                </td>
            </tr>

            <tr>
                <th class="total">
                    Total gross
                </th>

                <td class="text-right total">
                    {{ number_format($invoice->total_gross,2) }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer -->

    <div class="footer">
        Invoice {{ $invoice->invoice_number }}
    </div>

</div>
</body>
</html>

