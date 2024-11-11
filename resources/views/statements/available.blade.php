<!-- resources/views/statements/available.blade.php -->
@extends('layouts.default')

@section('content')
<div class="container my-4">
    <h1 class="text-center mb-4">Available Rooms in {{ $building->name }}</h1>

    <div class="d-flex justify-content-center mb-4 gap-3">
        <a href="{{ route('admin.available.shops',['building' =>$building->id]) }}" class="btn btn-outline-primary">Availability-Shops</a>
        <a href="{{ route('admin.available.flats',['building'=> $building->id]) }}" class="btn btn-outline-secondary">Availability-flats </a>
        {{-- <a href="{{ route('') }}" class="btn btn-outline-success">All Statements</a> --}}
        {{-- <a href="{{ route('admin.statements.commercialsummary') }}" class="btn btn-outline-info">Sales Summary </a> --}}

    </div>

    @if($availableRooms->isEmpty())
        <div class="alert alert-info text-center">
            No available rooms in this building.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
                <thead class="table-dark sticky-top">
                    <tr>
                        <th class="text-center" style="width: 5%;">NO</th>
                        <th class="text-center" style="width: 10%;">FLOOR</th>
                        <th class="text-center" style="width: 15%;">TYPE</th>
                        <th class="text-center" style="width: 10%;">DOOR NO</th>
                        <th class="text-center" style="width: 20%;">BUILT UP AREA (Sq Ft)</th>
                        <th class="text-center" style="width: 20%;">CARPET AREA (Sq Ft)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $currentFloor = ''; @endphp
                    @foreach($availableRooms as $index => $room)
                        <tr @if($room->room_floor !== $currentFloor) class="table-primary" @endif>
                            <td class="text-center">{{ $index + 1 }}</td>

                            <!-- Display floor name only when it changes -->
                            <td class="text-center">
                                @if($room->room_floor !== $currentFloor)
                                    {{ $room->room_floor }}
                                    @php $currentFloor = $room->room_floor; @endphp
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="badge bg-secondary">{{ ucfirst($room->room_type) }}</span>
                            </td>

                            <td class="text-center">{{ $room->room_number }}</td>

                            <!-- Conditionally display areas based on room type -->
                            <td class="text-end">
                                @if($room->room_type === 'Shop')
                                    {{ number_format($room->build_up_area, 2) }}
                                @elseif($room->room_type === 'Flat')
                                    {{ number_format($room->flat_super_build_up_area, 2) }}
                                @elseif($room->room_type === 'Table space')
                                    {{ number_format($room->space_area, 2) }}
                                @elseif($room->room_type === 'Kiosk')
                                    {{ number_format($room->kiosk_area, 2) }}
                                @elseif($room->room_type === 'Chair space')
                                    {{ number_format($room->chair_space_in_sq, 2) }}
                                @else
                                    {{ number_format($room->custom_area, 2) }}
                                @endif
                            </td>
                            <td class="text-end">
                                @if($room->room_type === 'Shop')
                                    {{ number_format($room->carpet_area, 2) }}
                                @elseif($room->room_type === 'Flat')
                                    {{ number_format($room->flat_carpet_area, 2) }}
                                @elseif($room->room_type === 'Table space')
                                    {{ number_format($room->space_rate, 2) }}
                                @elseif($room->room_type === 'Kiosk')
                                    {{ number_format($room->kiosk_area, 2) }}
                                @elseif($room->room_type === 'Chair space')
                                    {{ number_format($room->chair_space_in_sq, 2) }}
                                @else
                                    {{ number_format($room->custom_area, 2) }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
