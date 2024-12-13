@extends('layouts.default')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #009688;
        color: white;
        font-weight: bold;
    }

    .title-row td {
        font-size: 20px;
        font-weight: bold;
        color: #ffffff;
        /* Green color for title */
        text-align: center;
        background-color: #009688;
        border: none;
        padding: 20px;
    }

    .subheading {
        background-color: #f2f2f2;
        /* Ash color for subheading */
        color: black;
        /* Black text color */
    }

    .note {
        color: red;
        font-style: italic;
        margin-top: 10px;
    }
</style>

<div class="container">
    <table>
        <!-- Title Row inside the table -->
        <thead>
            <tr class="title-row">
                <td colspan="7">COMMERCIAL SALES REPORT</td>
            </tr>
            <tr class="subheading">
                <th>FLOOR</th>
                <th>SHOP NO</th>
                <th>TYPE</th>
                <th>SQFT</th>
                <th>SALES PRICE</th>
                <th>TOTAL SALE AMOUNT</th>
                <th>CLIENT NAME</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example of dynamic rows -->
            @foreach ($salesData as $row)
                <tr>
                    <td>{{ $row->room_floor }}</td>
                    <td>{{ $row->room_number }}</td>
                    <td>{{ $row->room_type }}</td>
                    <td>{{ number_format($row->build_up_area) }}</td>
                    <td>{{ number_format($row->sales_amount) }}</td>
                    <td>{{ number_format($row->total_sale_amount) }}</td>
                    <td>{{ $row->client_name }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="font-weight: bold;">TOTAL</td>
                <td>{{ number_format($totalSqft) }}</td>
                <td></td>
                <td>{{ number_format($totalSaleAmount) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <!-- Apartment Sales Report -->
    <table>
        <thead>
            <tr class="title-row">
                <td colspan="7">APARTMENT SALES REPORT</td>
            </tr>
            <tr class="subheading">
                <th>FLOOR</th>
                <th>DOOR NO</th>
                <th>TYPE</th>
                <th>SQFT</th>
                <th>SALES PRICE</th>
                <th>TOTAL SALE AMOUNT</th>
                <th>CLIENT NAME</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apartmentSalesData as $row)
                <tr>
                    <td>{{ $row->apartment_floor }}</td>
                    <td>{{ $row->apartment_number }}</td>
                    <td>{{ $row->apartment_type }}</td>
                    <td>{{ number_format($row->build_up_area) }}</td>
                    <td>{{ number_format($row->sales_amount) }}</td>
                    <td>{{ number_format($row->total_sale_amount) }}</td>
                    <td>{{ $row->client_name }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="font-weight: bold;">TOTAL</td>
                <td>{{ number_format($totalApartmentSqft) }}</td>
                <td></td>
                <td>{{ number_format($totalApartmentSaleAmount) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection