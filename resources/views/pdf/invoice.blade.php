<!DOCTYPE html>
<html lang="pl">
<head>

<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:12px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #000;
    padding:5px;
}

.text-right{
    text-align:right;
}
.column {
  float: left;
  width: 50%;
  padding: 10px;
  /* height: 300px; */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>

</head>
<body>

<h1>INVOICE</h1>

<h3>
Number:
{{ $invoice->invoice_number }}
</h3>

<p>
Issue date:
{{ $invoice->issue_date }}
</p>

<p>
Due date:
{{ $invoice->due_date }}
</p>

<div class="row">
    <div class="column">
        <h3>Customer</h3>

        <p>
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
        <h3>Seller</h3>

        <p>
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

<div>
    <p>Invoice items</p>
    <table>
    <thead>
    <tr>

    <th>No.</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Unit price</th>
    <th>VAT</th>
    <th>Net value</th>
    <th>Gross value</th>

    </tr>

    </thead>

    <tbody>

    @foreach($invoice->items as $index => $item)

    <tr>

    <td>{{ $index + 1 }}</td>

    <td>
    {{ $item->product->product_name }}
    </td>

    <td>
    {{ $item->quantity }}
    </td>

    <td class="text-right">
    {{ number_format($item->unit_net_price,2) }}
    </td>

    <td>
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

    <br>

    <table>

    <tr>

    <th>Total net</th>

    <td class="text-right">
    {{ number_format($invoice->total_net,2) }}
    </td>

    </tr>

    <tr>

    <th>VAT</th>

    <td class="text-right">
    {{ number_format($invoice->total_vat,2) }}
    </td>

    </tr>

    <tr>

    <th>Total gross</th>

    <td class="text-right">
    {{ number_format($invoice->total_gross,2) }}
    </td>

    </tr>

    </table>
</div>
</body>
</html>