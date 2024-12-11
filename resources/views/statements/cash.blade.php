@extends('layouts.default') {{-- Assuming you have a main layout --}}

@section('content')
<style>
    .gradient-border {
        position: relative;
        padding: 1rem;
        background-color: #ffffff;
        border-radius: 0.5rem;
        margin-top: 1rem;
    }

    .gradient-border::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: -1;
        border-radius: inherit;
        background: linear-gradient(45deg, rgba(0, 123, 255, 0.5), rgba(0, 123, 255, 0.2));
        filter: blur(8px);
    }

    .btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 1rem;
    }
</style>

{{-- Bordered Content Section --}}
<div class="container gradient-border shadow mt-4">
    <div class="row">
        <div class="col text-center">
            <div class="btn-container">
                <a href="{{ route('admin.cash-statement.download', $sale->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> PDF
                </a>
            </div>
            <h2>TABASCO INN</h2>
            <h4><strong>Client Name:</strong></h4>
            <h6>{{ $sale->customer_name }}</h6>
            <h4><u>Statement of Account</u></h4>
            <p>From <strong>{{ \Carbon\Carbon::parse($firstInstallmentDate)->format('d/m/Y') }}</strong> 
               To <strong>{{ \Carbon\Carbon::parse($lastInstallmentDate)->format('d/m/Y') }}</strong></p>
            <p class="text-danger">Statement Type: Cash</p>
        </div>
    </div>

    <table class="table table-bordered table-striped mt-4">
        <thead class="thead-light">
            <tr>
                <th>Date</th>
                <th>V.No</th>
                <th>Description</th>
                <th>Payment Type</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @php
                $runningBalance = $initialBalance;
                $totalDebit = 0;
                $totalCredit = 0;
            @endphp
        
            @foreach($cashInstallments as $index => $installment)
                @php
                    $credit = $installment->status === 'paid' 
                              ? $installment->installment_amount 
                              : $installment->credit;
        
                    $totalDebit += $installment->debit;
                    $totalCredit += $credit;
        
                    // Update balance only if credit is present
                    if ($credit) {
                        $runningBalance += $installment->debit - $credit;
                    }
                @endphp
        
                <tr>
                    <td>{{ \Carbon\Carbon::parse($installment->installment_date)->format('d/m/Y') }}</td>
                    <td>{{ $installment->voucher_no }}</td>
                    <td>{{ $installment->description }}</td>
                    <td>Cash</td>
                    <td>{{ number_format($installment->debit, 2) }}</td>
                    <td>{{ $credit ? number_format($credit, 2) : '' }}</td>
                    <td>
                        @if($credit)
                            {{ number_format($runningBalance, 2) }}
                        @else
                            {{-- Leave balance cell blank if no credit --}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        
        
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Sub Total</th>
                <th>{{ number_format($totalDebit, 2) }}</th>
                <th>{{ number_format($totalCredit, 2) }}</th>
                <th>{{ number_format($balance, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</div><br><br><br>
@endsection