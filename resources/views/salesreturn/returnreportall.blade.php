@extends('layouts.default')

@section('content')
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    .report-title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        background-color: #F89A6B; /* Orange */
        color: white;
        padding: 10px 0;
        margin-bottom: 5px;
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
<div class="container">
<div class="d-flex justify-content-center mb-4 gap-3">
    <a href="{{ route('admin.salesreturn.commercial', $building->id) }}" class="btn btn-outline-primary">Commercial</a>
    <a href="{{ route('admin.salesreturn.apartment',$building->id)}}" class="btn btn-outline-secondary">Apartment</a>
    <a href="{{ route('admin.salesreturn.parking',$building->id)}}" class="btn btn-outline-success">Parking</a>
    

  
</div>

<!-- REPORT TITLE -->
<div class="report-title">SALES RETURN REPORT</div>

<!-- COMMERCIAL SECTION -->
<div class="section-header">COMMERCIAL</div>
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


<!-- APARTMENTS SECTION -->
<div class="section-header">APARTMENTS</div>
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

<!-- PARKING SECTION -->
<div class="section-header">PARKING</div>
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

@endsection
