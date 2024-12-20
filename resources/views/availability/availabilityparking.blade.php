@extends('layouts.default')

@section('content')
<div class="container">

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <!-- Title Row -->
            <tr>
                <th colspan="5"
                    style="text-align: center; background-color: #008080; color: white; padding: 10px; border: 1px solid #000; font-size: 20px;">
                    PARKING
                </th>
            </tr>
            <!-- Headers -->
            <tr>
                <th style="border: 1px solid #000; text-align: center; padding: 8px; background-color: #d9d9d9;">NO</th>
                <th style="border: 1px solid #000; text-align: center; padding: 8px; background-color: #d9d9d9;">FLOOR</th>
                <th style="border: 1px solid #000; text-align: center; padding: 8px; background-color: #d9d9d9;">TYPE</th>
                <th style="border: 1px solid #000; text-align: center; padding: 8px; background-color: #d9d9d9;">PARKING NUMBER</th>
                <th style="border: 1px solid #000; text-align: center; padding: 8px; background-color: #d9d9d9;">NAME</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parkings as $item)
                @if ($item['status'] == 'available')
                    <tr>
                        <td style="border: 1px solid #000; text-align: center; padding: 8px;">{{ $loop->iteration }}</td>
                        <td style="border: 1px solid #000; text-align: center; padding: 8px;">{{ $item['floor_number'] }}</td>
                        <td style="border: 1px solid #000; text-align: center; padding: 8px;">-----</td>
                        <td style="border: 1px solid #000; text-align: center; padding: 8px;">{{ $item['slot_number'] }}</td>
                        <td style="border: 1px solid #000; text-align: center; padding: 8px;">{{ $item['purchaser_name'] }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

</div>
@endsection
