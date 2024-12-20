@extends('layouts.default')

@section('content')
<div class="container">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #00838F; /* Header background */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .section-header {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin: 20px 0;
            background-color: #00838F;
            color: white;
            padding: 10px 0;
        }
        .total-row {
            font-weight: bold;
        }
        .negative-amount {
            color: red;
        }
        .note {
            color: red;
            font-size: 12px;
        }
    </style>

    <!-- RETURN SUMMARY SECTION -->
    <div class="section-header">RETURN SUMMARY</div>
    <table>
        <thead>
            <tr>
                <th>CLIENT NAME</th>
                <th>FLOOR</th>
                <th>NO</th>
                <th>TYPE</th>
                <th>TOTAL SALE AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>koval Ahmed Haji</td>
                <td>GROUND</td>
                <td>2</td>
                <td>SHOP</td>
                <td>55,20,000</td>
            </tr>
            <tr>
                <td>Govardan Group</td>
                <td>2nd</td>
                <td>5</td>
                <td>SHOP</td>
                <td>23,65,000</td>
            </tr>
            <tr>
                <td>koval Ahmed Haji</td>
                <td>GROUND</td>
                <td>1</td>
                <td>SHOP</td>
                <td>5,68,44,500</td>
            </tr>
            <tr>
                <td>Vinod DYSP</td>
                <td>1st</td>
                <td>12</td>
                <td>SHOP</td>
                <td>30,22,600</td>
            </tr>
            <tr class="total-row">
                <td colspan="4">Total</td>
                <td>8,48,23,700</td>
            </tr>
        </tbody>
    </table>

    <!-- EXCHANGE SUMMARY SECTION -->
    <div class="section-header">EXCHANGE SUMMARY</div>
    <table>
        <thead>
            <tr>
                <th>CLIENT NAME</th>
                <th>FLOOR</th>
                <th>NO</th>
                <th>TYPE</th>
                <th>TOTAL SALE AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>koval Ahmed Haji</td>
                <td>1st</td>
                <td>1</td>
                <td>SHOP</td>
                <td>1,12,24,000</td>
            </tr>
            <tr>
                <td>Govardan Group</td>
                <td>2nd</td>
                <td>6</td>
                <td>SHOP</td>
                <td>14,85,000</td>
            </tr>
            <tr class="total-row">
                <td colspan="4">Total</td>
                <td>1,27,09,000</td>
            </tr>
        </tbody>
    </table>

    <!-- PAYABLE / RECEIVABLE SECTION -->
    <p style="text-align: center; font-weight: bold; margin-top: 20px;">
        Payable/Receivable: <span class="negative-amount">(7,21,14,700)</span>
    </p>
    <p class="note" style="text-align: center;">
        Note: Negative indicates payable
    </p>
</div>
@endsection
