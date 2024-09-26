@extends('layouts.default', ['title' => $title, 'page' => $page])

@section('content')

<div class="container-fluid py-4">
    @foreach($rooms as $floor => $floorRooms)
    <div class="card my-4">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Floor: {{ $floor }}</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Door No</th>
                            <th class="text-center">Room Type</th>
                            <th class="text-center">Room Name</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Area Sq Ft</th>
                            <th class="text-center">Area Rate</th>
                            <th class="text-center">Expected Amount</th>
                            <th class="text-center">GST Amount</th>
                            <th class="text-center">Parking Amount</th>
                            <th class="text-center">Customer Name</th>
                            <th class="text-center">Sale Amount (RS)</th>
                            <th class="text-center">Total Amount</th>
                            @if($floorRooms->contains(fn($room) => !empty($room->status)))
                                <th class="text-center">Status</th>
                            @endif
                            @if(!$floorRooms->contains(fn($room) => !empty($room->status)))
                                <th class="text-center">Difference</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($floorRooms as $index => $room)
                        @php
                            // Calculate total amount and sale amount from the sales relationship
                            $totalAmount = $room->sales->sum('total_amount');
                            $saleAmount = $room->sales->sum('sale_amount');
                            $expectedAmount = $room->expected_price;
                            $difference = $totalAmount - $expectedAmount;
                            $isPositive = $difference > 0;
                            $showDifference = empty($room->status);
                        @endphp
                        <tr>
                            <td class="text-center">{{ (int)$index + 1 }}</td>
                            <td>{{ $room->room_number }}</td>
                            <td>{{ $room->room_type }}</td>
                            <td>{{ $room->custom_name }}</td>
                            <td>{{ $room->custom_type }}</td>
                            <td class="text-right">{{ $room->custom_area }}</td>
                            <td class="text-right">{{ $room->custom_rate }}</td>
                            <td class="text-right">{{ $room->expected_custom_rate }}</td>
                            <td class="text-right">
                                @if($room->sales->isNotEmpty())
                                {{ $room->sales->first()->gst_amount }}
                                @endif
                            </td>
                            <td class="text-right">
                                @if($room->sales->isNotEmpty())
                                {{ $room->sales->first()->parking_amount }}
                                @endif
                            </td>
                            <td>
                                @if($room->sales->isNotEmpty())
                                {{ $room->sales->first()->customer_name }}
                                @endif
                            </td>
                            <td class="text-right">{{ number_format($saleAmount, 2) }}</td>
                            <td class="text-right">{{ number_format($totalAmount, 2) }}</td>
                            @if($showDifference)
                                <td class="text-right">
                                    @if($isPositive)
                                        <span style="color: green;">+{{ number_format($difference, 2) }}</span>
                                    @else
                                        <span style="color: red;">-{{ number_format(abs($difference), 2) }}</span>
                                    @endif
                                </td>
                            @endif
                            <td class="text-center">{{ $room->status }}</td> <!-- Status Data -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection