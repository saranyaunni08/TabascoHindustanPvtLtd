@extends('layouts.default')

@section('content')
<div class="container">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #bfbfbf;
        }
        .balance {
            font-weight: bold;
        }
        .note {
            color: red;
            font-size: 12px;
        }
        .highlight {
            background-color: #d6f5d6; /* Light green */
        }
        .sub-total {
            font-weight: bold;
            text-align: right;
        }
    </style>
    <div class="d-flex justify-content-center mb-4 gap-3">
    <a href="{{ route('admin.bankaccount.axisbankaccount', $building->id) }}" class="btn btn-outline-primary">Axis Bank Account</a>
    <a href="{{ route('admin.bankaccount.canarabankaccount',$building->id)}}" class="btn btn-outline-secondary">Canara Bank Account</a>
    <a href="{{ route('admin.bankaccount.sbiaccount',$building->id)}}" class="btn btn-outline-success">Sbi Account</a>
    

  
</div>

    <div style="text-align: center;">
        <h2>TABASCO INN</h2>
        <h3>STATEMENT OF ACCOUNT</h3>
        <p><strong>BANK BANK ACCOUNTS (COMBINED)</strong></p>
        <p>From 01-09-2024 To 18-01-2025</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Vno</th>
                <th>Description</th>
                <th>CHEQUE NO</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $transactions = [
                    ['date' => '18-09-2024', 'vno' => 1, 'description' => '1st Installment (Koval Ahmed Haji)', 'cheque' => '', 'debit' => 5850833.33, 'credit' => 0, 'balance' => 5850833.33],
                    ['date' => '20-09-2024', 'vno' => 2, 'description' => '1st Installment (Vijayan)', 'cheque' => '', 'debit' => 130043.38, 'credit' => 0, 'balance' => 5980876.71],
                    ['date' => '18-10-2024', 'vno' => 3, 'description' => '2nd Installment (Koval Ahmed Haji)', 'cheque' => '', 'debit' => 5850833.33, 'credit' => 0, 'balance' => 11831710.04],
                    ['date' => '20-10-2024', 'vno' => 4, 'description' => '2nd Installment (Vijayan)', 'cheque' => '', 'debit' => 130043.38, 'credit' => 0, 'balance' => 11961753.42],
                    // Add other rows similarly
                ];
                $total_debit = 0;
                $total_credit = 0;
            @endphp

            @foreach ($transactions as $index => $transaction)
                @php
                    $total_debit += $transaction['debit'];
                    $total_credit += $transaction['credit'];
                @endphp
                <tr @if($index % 2 == 0) class="highlight" @endif>
                    <td>{{ $transaction['date'] }}</td>
                    <td>{{ $transaction['vno'] }}</td>
                    <td>{{ $transaction['description'] }}</td>
                    <td>{{ $transaction['cheque'] }}</td>
                    <td>{{ number_format($transaction['debit'], 2) }}</td>
                    <td>{{ number_format($transaction['credit'], 2) }}</td>
                    <td class="balance">{{ number_format($transaction['balance'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="sub-total">Sub Total</td>
                <td>{{ number_format($total_debit, 2) }}</td>
                <td>{{ number_format($total_credit, 2) }}</td>
                <td class="balance">{{ number_format($total_debit - $total_credit, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    
</div>
@endsection
