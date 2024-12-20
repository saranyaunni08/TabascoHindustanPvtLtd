@extends('layouts.default')

@section('content')
<div class="container my-4">
    <!-- Header -->
    <h3 class="text-center font-weight-bold">TABASCO INN</h3>
    <h4 class="text-center font-weight-bold">STATEMENT OF ACCOUNT</h4>
    <h5 class="text-center">BASHEER CURRENT ACCOUNT</h5>
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
                <td>1st Installment (Vijayan)</td>
                <td>108631.88</td>
                <td></td>
                <td>108631.88</td>
                <td></td>
            </tr>
            <!-- Row 2 -->
            <tr class="even-row">
                <td>18-09-2024</td>
                <td>1st Installment (Koval Ahmed Haji)</td>
                <td></td>
                <td>4887500</td>
                <td>4996131.88</td>
                <td></td>
            </tr>
            <!-- Row 3 -->
            <tr class="odd-row">
                <td>15-10-2024</td>
                <td>2nd Installment (Vijayan)</td>
                <td>108631.88</td>
                <td></td>
                <td>5104763.75</td>
                <td></td>
            </tr>
            <!-- Row 4 -->
            <tr class="even-row">
                <td>18-10-2024</td>
                <td>2nd Installment (Koval Ahmed Haji)</td>
                <td></td>
                <td>4887500</td>
                <td>9992263.75</td>
                <td></td>
            </tr>
            <!-- Row 5 -->
            <tr class="odd-row">
                <td>15-11-2024</td>
                <td>3rd Installment (Vijayan)</td>
                <td>108631.88</td>
                <td></td>
                <td>10100895.6</td>
                <td></td>
            </tr>
            <!-- Row 6 -->
            <tr class="even-row">
                <td>18-11-2024</td>
                <td>3rd Installment (Koval Ahmed Haji)</td>
                <td></td>
                <td>4887500</td>
                <td>14988395.6</td>
                <td></td>
            </tr>
            <!-- Row 7 -->
            <tr class="odd-row">
                <td>15-12-2024</td>
                <td>4th Installment (Vijayan)</td>
                <td>108631.88</td>
                <td></td>
                <td>15097027.5</td>
                <td></td>
            </tr>
            <!-- Row 8 -->
            <tr class="even-row">
                <td>18-12-2024</td>
                <td>4th Installment (Koval Ahmed Haji)</td>
                <td></td>
                <td>4887500</td>
                <td>19984527.5</td>
                <td></td>
            </tr>
            <!-- Row 9 -->
            <tr class="odd-row">
                <td>15-01-2024</td>
                <td>5th Installment (Vijayan)</td>
                <td>108631.88</td>
                <td></td>
                <td>20093159.4</td>
                <td></td>
            </tr>
            <!-- Row 10 -->
            <tr class="even-row">
                <td>18-01-2025</td>
                <td>5th Installment (Koval Ahmed Haji)</td>
                <td></td>
                <td>4887500</td>
                <td>24980659.4</td>
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
