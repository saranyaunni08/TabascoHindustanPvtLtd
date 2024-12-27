@extends('layouts.default')

@section('content')
<div class="container">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        h2 {
            text-align: center;
            margin: 0;
            color: #444;
            font-size: 24px;
        }
        h3 {
            text-align: center;
            margin-top: 10px;
            font-size: 18px;
            color: #777;
        }
        p {
            text-align: center;
            margin: 5px 0;
            color: #555;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:nth-child(odd) {
            background-color: #fff;
        }
        .highlight-header {
            background-color: #6c757d;
            color: #fff;
        }
        .sub-total, .grand-total {
            font-weight: bold;
            background-color: #e9ecef;
            color: #333;
        }
        .sub-total td, .grand-total td {
            border-top: 2px solid #007BFF;
        }
    </style>

    <h2>TABASCO INN</h2>
    <h3>STATEMENT OF ACCOUNT</h3>
    <p>CANARA BANK ACCOUNT</p>
    <p>From 01-09-2024 To 18-01-2025</p>

    <table>
        <thead>
            <tr class="highlight-header">
                <th>Date</th>
                <th>Vno</th>
                <th>Description</th>
                <th>Cheque No</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>05-09-2024</td>
                <td></td>
                <td>Deposit (John Doe)</td>
                <td>123456</td>
                <td>0</td>
                <td>500,000.00</td>
                <td>500,000.00</td>
            </tr>
            <tr>
                <td>10-09-2024</td>
                <td></td>
                <td>Withdrawal (Jane Smith)</td>
                <td>654321</td>
                <td>100,000.00</td>
                <td>0</td>
                <td>400,000.00</td>
            </tr>
            <tr>
                <td>20-09-2024</td>
                <td></td>
                <td>Deposit (Michael Brown)</td>
                <td>987654</td>
                <td>0</td>
                <td>300,000.00</td>
                <td>700,000.00</td>
            </tr>
            <tr class="sub-total">
                <td colspan="4">Sub Total</td>
                <td>100,000.00</td>
                <td>800,000.00</td>
                <td>700,000.00</td>
            </tr>
            <tr class="grand-total">
                <td colspan="4">Grand Total</td>
                <td>100,000.00</td>
                <td>800,000.00</td>
                <td>700,000.00</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection