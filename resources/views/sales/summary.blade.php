@extends('layouts.default')

@section('content')
<div class="container">
    <table>
        <thead>
            <!-- SALES SUMMARY Header Inside Table -->
            <tr>
                <th colspan="3" class="table-header">SALES SUMMARY</th>
            </tr>
            <!-- Column Headers -->
            <tr>
                <th>TYPE</th>
                <th>SQFT</th>
                <th>SALE AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SHOP</td>
                <td>{{ number_format(53978) }}</td>
                <td>{{ number_format(547231300) }}</td>
            </tr>
            <tr>
                <td>APARTMENTS</td>
                <td>{{ number_format(60573) }}</td>
                <td>{{ number_format(248115934) }}</td>
            </tr>
            <tr>
                <td>PARKING</td>
                <td>{{ number_format(38) }}</td>
                <td>{{ number_format(10645000) }}</td>
            </tr>
            <tr class="total-row">
                <td>TOTAL SALES</td>
                <td>{{ number_format(114551) }}</td>
                <td>{{ number_format(805992234) }}</td>
            </tr>
        </tbody>
    </table>
</div>

<style>
    /* General Page Styling */
    .container {
        margin: 0 auto;
        padding: 20px;
        font-family: Arial, sans-serif;
        max-width: 800px;
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 10px;
    }

    th {
        background-color: #009688;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .total-row {
        font-weight: bold;
        background-color: #e0f2f1;
    }

    /* Table Header Styling */
    .table-header {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        background-color: #009688;
        color: white;
        padding: 15px;
    }
</style>
@endsection
