@extends('layouts.default')

@section('content')
<div class="container my-4">
    <!-- Header -->
    <h3 class="text-center font-weight-bold">TABASCO INN</h3>
    <h4 class="text-center font-weight-bold">STATEMENT OF ACCOUNT</h4>
    <h5 class="text-center">PAVOOR CURRENT ACCOUNT</h5>
    <p class="text-center"><strong>From 01-09-2024 To 18-01-2025</strong></p>

    <!-- Table -->
    <table class="table table-bordered text-center">
        <thead>
            <tr class="table-header">
                <th>Date</th>
                <th>Vno</th>
                <th>Description</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <!-- Row 1 -->
            <tr class="odd-row">
                <td>15-09-2024</td>
                <td>1st Installment (Pavoor)</td>
                <td>150000</td>
                <td></td>
                <td>150000</td>
                <td></td>
            </tr>
            <!-- Row 2 -->
            <tr class="even-row">
                <td>18-09-2024</td>
                <td>1st Installment (John Doe)</td>
                <td></td>
                <td>5000000</td>
                <td>5150000</td>
                <td></td>
            </tr>
            <!-- Row 3 -->
            <tr class="odd-row">
                <td>15-10-2024</td>
                <td>2nd Installment (Pavoor)</td>
                <td>150000</td>
                <td></td>
                <td>5300000</td>
                <td></td>
            </tr>
            <!-- Row 4 -->
            <tr class="even-row">
                <td>18-10-2024</td>
                <td>2nd Installment (John Doe)</td>
                <td></td>
                <td>5000000</td>
                <td>10300000</td>
                <td></td>
            </tr>
            <!-- Row 5 -->
            <tr class="odd-row">
                <td>15-11-2024</td>
                <td>3rd Installment (Pavoor)</td>
                <td>150000</td>
                <td></td>
                <td>10450000</td>
                <td></td>
            </tr>
            <!-- Row 6 -->
            <tr class="even-row">
                <td>18-11-2024</td>
                <td>3rd Installment (John Doe)</td>
                <td></td>
                <td>5000000</td>
                <td>15450000</td>
                <td></td>
            </tr>
            <!-- Row 7 -->
            <tr class="odd-row">
                <td>15-12-2024</td>
                <td>4th Installment (Pavoor)</td>
                <td>150000</td>
                <td></td>
                <td>15600000</td>
                <td></td>
            </tr>
            <!-- Row 8 -->
            <tr class="even-row">
                <td>18-12-2024</td>
                <td>4th Installment (John Doe)</td>
                <td></td>
                <td>5000000</td>
                <td>20600000</td>
                <td></td>
            </tr>
            <!-- Row 9 -->
            <tr class="odd-row">
                <td>15-01-2025</td>
                <td>5th Installment (Pavoor)</td>
                <td>150000</td>
                <td></td>
                <td>20750000</td>
                <td></td>
            </tr>
            <!-- Row 10 -->
            <tr class="even-row">
                <td>18-01-2025</td>
                <td>5th Installment (John Doe)</td>
                <td></td>
                <td>5000000</td>
                <td>25750000</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Inline Style -->
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .table-header {
        background-color: #f58220; /* Orange header */
        color: #fff;
        text-align: center;
    }
    .sub-header {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: center;
    }
    .even-row {
        background-color: #e0f4ff; /* Light Blue */
    }
    .odd-row {
        background-color: #d7f7e8; /* Light Green */
    }
    .table td, .table th {
        vertical-align: middle;
    }
</style>
@endsection
