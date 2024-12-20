@extends('layouts.default')

@section('content')
<div class="container">

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }
    .container {
        width: 90%;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
    }
    .header h2 {
        margin: 0;
        color: #333;
    }
    .header h3 {
        margin: 5px 0;
        color: #555;
    }
    .header p {
        margin: 0;
        color: #666;
        font-size: 14px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
        font-size: 14px;
    }
    th {
        background-color: #f4b084;
        color: #000;
        font-weight: bold;
    }
    .highlight {
        background-color: #f9f9f9;
    }
    .footer {
        margin-top: 20px;
    }
    .footer .totals {
        text-align: right;
        font-weight: bold;
    }
    .totals td {
        padding: 8px;
        border: 1px solid #ddd;
        background-color: #f4f4f4;
    }
</style>

<div class="header">
    <h2>TABASCO INN</h2>
    <h3>STATEMENT OF ACCOUNT</h3>
    <p><strong>Supplier:</strong> MKH</p>
    <p>From {{ $start_date }} To {{ $end_date }}</p>
    <p style="color: red;"><strong>Statement Type: All</strong></p>
</div>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>V. No</th>
            <th>Description</th>
            <th>Payment Type</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $transaction)
        <tr>
            <td>{{ $transaction->date }}</td>
            <td>{{ $transaction->voucher_number }}</td>
            <td>{{ $transaction->description }}</td>
            <td>{{ $transaction->payment_type }}</td>
            <td>{{ $transaction->debit }}</td>
            <td>{{ $transaction->credit }}</td>
            <td>{{ $transaction->balance }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="totals">Sub Total</td>
            <td>{{ $sub_total_debit }}</td>
            <td>{{ $sub_total_credit }}</td>
            <td>{{ $sub_total_balance }}</td>
        </tr>
        <tr>
            <td colspan="4" class="totals">Grand Total</td>
            <td>{{ $grand_total_debit }}</td>
            <td>{{ $grand_total_credit }}</td>
            <td>{{ $grand_total_balance }}</td>
        </tr>
    </tfoot>
</table>
</div>
@endsection
