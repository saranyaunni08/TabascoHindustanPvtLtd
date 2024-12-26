@extends('layouts.default')

@section('content')
<div class="container">
  <!-- Apartment Parking Section -->
  <table class="table table-bordered table-striped">
        <thead>
            <tr style="background-color: #6c757d;">
                <th colspan="9" class="text-center" style="color: white; font-size: 1.5rem;">APARTMENT PARKING DETAILED
                    BREAKUP</th>
            </tr>
            <tr style="background-color: #6c757d;">
                <th>FLOOR</th>
                <th>NO</th>
                <th>PARKING NO</th>
                <th>NAME</th>
                <th>₹ EXPECTED SALE</th>
                <th>₹ SALE AMOUNT</th>
                <th>DIFFERENCE</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
    @php
        $totalExpectedSale = $totalSaleAmount = $totalDifference = 0;
    @endphp
    @foreach ($parkings as $parking)
        @php
            $difference = $parking->amount - $parking->sale_amount;
            $totalExpectedSale += $parking->amount;
            $totalSaleAmount += $parking->sale_amount;
            $totalDifference += $difference;
        @endphp
        <tr>
            <td>{{ $parking->room_floor }}</td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $parking->slot_number }}</td>
            <td>{{ $parking->purchaser_name }}</td>
            <td>₹ {{ number_format($parking->amount, 2) }}</td>
            <td>₹ {{ number_format($parking->sale_amount, 2) }}</td>
            <td style="color: {{ $difference < 0 ? 'red' : 'green' }};">₹
                {{ number_format($difference, 2) }}
            </td>
            <td style="color: {{ $parking->status == 'SOLD' ? 'green' : 'blue' }};">{{ $parking->status }}</td>
        </tr>
    @endforeach

    <tr style="font-weight: bold; background-color: #f8f9fa;">
        <td colspan="4" class="text-center"><strong>TOTAL</strong></td>
        <td>₹ {{ number_format($totalExpectedSale, 2) }}</td>
        <td>₹ {{ number_format($totalSaleAmount, 2) }}</td>
        <td>-₹ {{ number_format($totalDifference, 2) }}</td>
        <td></td>
    </tr>
</tbody>

    </table>

</div>
@endsection
