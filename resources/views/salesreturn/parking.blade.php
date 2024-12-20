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


<!-- PARKING SECTION -->
<div class="section-header">PARKING SALES RETURN REPORT</div>
<table>
    <thead>
        <tr>
            <th>TYPE</th>
            <th>PARKING NO</th>
            <th>FLOOR</th>
            <th>SALES PRICE</th>
            <th>CLIENT NAME</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Parking</td>
            <td>1</td>
            <td>4th</td>
            <td>25000</td>
            <td>Vijayan</td>
            <td>Paid</td>
        </tr>
        </tbody>
        </table>

    </div>


</div>
@endsection