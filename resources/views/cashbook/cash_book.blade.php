@extends('layouts.default')

@section('content')
<div class="container">

<div class="d-flex justify-content-center mb-4 gap-3">
    <a href="{{ route('admin.cashbook.BasheerCurrentAccount', $building->id) }}" class="btn btn-outline-primary">Basheer Current Account</a>
    <a href="{{ route('admin.cashbook.PavoorCurrentAccount',$building->id)}}" class="btn btn-outline-secondary">Pavoor Current Account</a>

  
</div>
    <h1 style="text-align: center; color: #b45f04;">TABASCO INN</h1>
    <h3 style="text-align: center; color: #b45f04;">STATEMENT OF ACCOUNT</h3>
    <h4 style="text-align: center;">CASH BOOK</h4>
    <p style="text-align: center;">From 01-09-2024 To 18-01-2025</p>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 10px; background-color: #444; color: white;">Date</th>
                <th style="border: 1px solid #ccc; padding: 10px; background-color: #444; color: white;">Vno</th>
                <th style="border: 1px solid #ccc; padding: 10px; background-color: #444; color: white;">Description</th>
                <th style="border: 1px solid #ccc; padding: 10px; background-color: #444; color: white;">Debit</th>
                <th style="border: 1px solid #ccc; padding: 10px; background-color: #444; color: white;">Credit</th>
                <th style="border: 1px solid #ccc; padding: 10px; background-color: #444; color: white;">Balance</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">15-09-2024</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;"></td>
                <td style="border: 1px solid #ccc; padding: 10px;">1st Installment (Vijayan)</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">188925</td>
                <td style="border: 1px solid #ccc; padding: 10px;"></td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">188925</td>
            </tr>
            <tr style="background-color: #d9f2d9;">
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">15-09-2024</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;"></td>
                <td style="border: 1px solid #ccc; padding: 10px;">Transfer to Basheer Current Account (57.5%)</td>
                <td style="border: 1px solid #ccc; padding: 10px;"></td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">108631.88</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">80293.125</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">15-09-2024</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;"></td>
                <td style="border: 1px solid #ccc; padding: 10px;">Transfer to Pavoor Current Account (42.5%)</td>
                <td style="border: 1px solid #ccc; padding: 10px;"></td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">80293.13</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">0</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">18-09-2024</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;"></td>
                <td style="border: 1px solid #ccc; padding: 10px;">1st Installment (Koval Ahmed Haji)</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">8500000</td>
                <td style="border: 1px solid #ccc; padding: 10px;"></td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">8500000</td>
            </tr>
            <tr style="background-color: #d9f2d9;">
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">18-09-2024</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;"></td>
                <td style="border: 1px solid #ccc; padding: 10px;">Transfer to Basheer Current Account (57.5%)</td>
                <td style="border: 1px solid #ccc; padding: 10px;"></td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">4887500</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">3612500</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">18-09-2024</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;"></td>
                <td style="border: 1px solid #ccc; padding: 10px;">Transfer to Pavoor Current Account (42.5%)</td>
                <td style="border: 1px solid #ccc; padding: 10px;"></td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">3612500</td>
                <td style="border: 1px solid #ccc; padding: 10px; text-align: center;">0</td>
            </tr>
        </tbody>
    </table>

    <div style="margin: 20px; color: red; font-size: 14px;">
        <p>Note 1: While collecting any cash from client, a certain percentage is transferred to partners' current accounts. There should be an option to transfer at the same time of collection.</p>
        <p>Note 2: Partners may be more or may be more than 2.</p>
    </div>
</div>
@endsection
