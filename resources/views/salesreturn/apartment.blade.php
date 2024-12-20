@extends('layouts.default')

@section('content')
<div class="container">

<style>
        /* General Styles */
        .report-title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        background-color: #F89A6B; /* Orange */
        color: white;
        padding: 10px 0;
        margin-bottom: 20px; /* Added space below the title */
    }
        .section-header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            background-color: #00838F; /* Teal */
            color: white;
            padding: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
            font-size: 14px;
        }
        th {
            background-color: #00838F; /* Teal Header */
            color: white;
        }
        .total-row {
            font-weight: bold;
        }
        .note {
            color: red;
            font-size: 12px;
            margin-left: 10px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>


<!-- APARTMENTS SECTION -->
<div class="section-header">APARTMENTS SALES RETURN REPORT</div>
<table>
    <thead>
        <tr>
            <th>TYPE</th>
            <th>DOOR NO</th>
            <th>FLOOR</th>
            <th>SQFT</th>
            <th>SALES PRICE</th>
            <th>TOTAL SALE AMOUNT</th>
            <th>CLIENT NAME</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1BHK</td>
            <td>B</td>
            <td>6th</td>
            <td>734</td>
            <td>4,750</td>
            <td>34,86,500</td>
            <td>madhusoodanan</td>
            <td>Paid</td>
        </tr>
        <tr>
            <td>2 BHK</td>
            <td>A1</td>
            <td>7th</td>
            <td>979</td>
            <td>3,400</td>
            <td>33,28,600</td>
            <td>Suresh</td>
            <td>Payable</td>
        </tr>
        <tr>
            <td>2 BHK</td>
            <td>A1</td>
            <td>11th</td>
            <td>979</td>
            <td>3,500</td>
            <td>34,26,500</td>
            <td>Savithri</td>
            <td>Payable</td>
        </tr>
        <tr class="total-row">
            <td colspan="3">Total</td>
            <td>2,692</td>
            <td></td>
            <td>1,02,41,600</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>



</div>
@endsection
