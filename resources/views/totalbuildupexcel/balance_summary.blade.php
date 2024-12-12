@extends('layouts.default')

@section('content')


<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">BALANCE SQFT AND FINANCIAL SUMMARY</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-success">
                    <tr>
                        <th>TYPE</th>
                        <th>TOTAL SQ FT</th>
                        <th>SALES SQFT</th>
                        <th>SALE AMOUNT</th>
                        <th>BALANCE SQFT</th>
                        <th>EXPECTED BALANCE AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>APARTMENT</td>
                        <!-- Displaying total square feet -->
                        <td>{{ number_format($totalSqFt) }}</td>

                        <!-- Displaying sales square feet -->
                        <td>{{ number_format($salesSqFt) }}</td>

                        <!-- Displaying sale amount, formatted as currency -->
                        <td>₹{{ number_format($saleAmount, 2) }}</td>

                        <!-- Displaying balance square feet -->
                        <td>{{ number_format($balanceSqFt) }}</td>

                        <!-- Displaying expected balance amount, formatted as currency -->
                        <td>₹{{ number_format($expectedBalanceAmount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>COMMERCIAL</td>
                        <td>{{ number_format($totalSqFtcommercial) }}</td>
                        <td>{{ number_format( $salesSqFtcommercial) }}</td>
                        <td>₹{{ number_format($saleAmountcommercial, 2) }}</td>
                        <td>{{ number_format( $balanceSqFtcommercial ) }}</td>
                        <td>₹{{ number_format($expectedBalanceAmountcommercial, 2) }}</td>
                    </tr>
                    <tr>
                        <td>PARKING</td>
                        <td>{{$parkingno}}</td>
                        <td>--</td>
                        <td>₹{{ number_format($parkingSaleAmount, 2) }}</td>
                        <td>---</td>
                        <td>---</td>
                    </tr>
                    <tr>
                        <td>KEOSKY</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>TABLE COUNTER</td>
                        <td colspan="5"></td>
                    </tr>
                    <tr class="fw-bold">
                        <td>TOTAL</td>
                        <td>1,57,904</td>
                        <td>1,12,722</td>
                        <td>₹77,42,60,750</td>
                        <td>45,182</td>
                        <td>₹53,46,84,350</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-3 text-danger">
                <p><strong>Note:</strong> Expected Balance Amount should be the value of balance square feet to sell.
                </p>
                <p><strong>Note:</strong> Expected amount should be taken from the total. Type should be able to add
                    more.</p>
            </div>
        </div>
    </div>


</div>
@endsection