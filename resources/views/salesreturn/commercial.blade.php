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

    <!-- COMMERCIAL SECTION -->
    <div class="section-header">COMMERCIAL SALES RETURN REPORT</div>
    <table>
        <thead>
            <tr>
                <th>TYPE</th>
                <th>SHOP NO</th>
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
                <td>SHOP</td>
                <td>1</td>
                <td>Ground</td>
                <td>4,943</td>
                <td>11,500</td>
                <td>5,68,44,500</td>
                <td>koval Ahmed Haji</td>
                <td>Paid</td>
            </tr>
            <tr>
                <td>SHOP</td>
                <td>310</td>
                <td>Ground</td>
                <td>310</td>
                <td>11,500</td>
                <td>35,65,000</td>
                <td>koval Ahmed Haji</td>
                <td>Paid</td>
            </tr>
            <tr>
                <td>SHOP</td>
                <td>12</td>
                <td>1st Floor</td>
                <td>254</td>
                <td>11,900</td>
                <td>30,22,600</td>
                <td>Vinod DYSP</td>
                <td>Payable</td>
            </tr>
            <tr>
                <td>SHOP</td>
                <td>5</td>
                <td>2nd Floor</td>
                <td>430</td>
                <td>5,500</td>
                <td>23,65,000</td>
                <td>Govardan Group</td>
                <td>Payable</td>
            </tr>
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td>5,937</td>
                <td></td>
                <td>6,57,97,100</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
