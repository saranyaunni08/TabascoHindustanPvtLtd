@extends('layouts.default')

@section('content')
<div class="container">

   <!-- Apartments Section -->
   <table class="table table-bordered table-striped mb-5">
        <thead>
            <tr style="background-color: #ADD8E6;">
                <th colspan="11" class="text-center" style="color: white; font-size: 1.5rem;">APARTMENT DETAILED BREAKUP
                </th>
            </tr>
            <tr style="background-color: #ADD8E6;">
                <th>FLOOR</th>
                <th>TYPE</th>
                <th>DOOR NO</th>
                <th>BUILT-UP AREA (In Sq Ft)</th>
                <th>CARPET AREA (In Sq Ft)</th>
                <th>₹ EXPECTED / SQ.FT</th>
                <th>₹ EXPECTED SALE</th>
                <th>₹ SALE AMOUNT</th>
                <th>₹ SALE / SQ.FT</th>
                <th>DIFFERENCE</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalBuildUpArea = $totalCarpetArea = $totalExpectedAmount = $totalSaleAmount = $totalDifference = 0;
            @endphp
            

            @foreach ($apartments as $apartment)
            @php
    $expected_per_sqft = isset($apartment['flat_build_up_area']) && $apartment['flat_build_up_area'] > 0 
    ? $apartment['expected_amount'] / $apartment['flat_build_up_area'] 
    : 0;

$sale_per_sqft = isset($apartment['flat_build_up_area']) && $apartment['flat_build_up_area'] > 0 
    ? $apartment['sale_amount'] / $apartment['flat_build_up_area'] 
    : 0;

$difference = isset($apartment['expected_amount'], $apartment['sale_amount']) 
    ? $apartment['expected_amount'] - $apartment['sale_amount'] 
    : 0;


@endphp

            
<tr>
<tr>
    <td>{{ $apartment['room_floor'] }}</td>
    <td>{{ $apartment['room_type'] }}</td>
    <td>{{ $apartment['room_number'] }}</td>
    <td>{{ $apartment['flat_build_up_area'] }}</td>
    <td>{{ $apartment['flat_carpet_area'] }}</td>
    <td>₹ {{ number_format($expected_per_sqft, 2) }}</td> <!-- Display expected_per_sqft -->
    <td>₹ {{ number_format($apartment['expected_amount'], 2) }}</td>
    <td>₹ {{ number_format($apartment['sale_amount'], 2) }}</td>
    <td>₹ {{ number_format($sale_per_sqft, 2) }}</td>
    <td style="color: {{ $difference < 0 ? 'red' : 'green' }};">₹
        {{ number_format($difference, 2) }}
    </td>
    <td style="color: {{ $apartment['status'] == 'SOLD' ? 'green' : 'blue' }};">{{ $apartment['status'] }}</td>
</tr>

            </tr>
                        @php
                            $totalBuildUpArea += $apartment['flat_build_up_area'];
                            $totalCarpetArea += $apartment['flat_carpet_area'];
                            $totalExpectedAmount += $apartment['expected_amount'];
                            $totalSaleAmount += $apartment['sale_amount'];
                            $totalDifference += $apartment['difference'];
                        @endphp
            @endforeach

            <tr style="font-weight: bold; background-color: #f8f9fa;">
                <td colspan="3" style="text-align: right;">TOTAL</td>
                <td>{{ $totalBuildUpArea }}</td>
                <td>{{ $totalCarpetArea }}</td>
                <td></td>
                <td>₹ {{ number_format($totalExpectedAmount, 2) }}</td>
                <td>₹ {{ number_format($totalSaleAmount, 2) }}</td>
                <td></td>
                <td>-₹ {{ number_format($totalDifference, 2) }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

</div>
@endsection