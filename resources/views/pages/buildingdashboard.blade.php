@extends('layouts.default', ['title' => 'Dashboard', 'page' => 'dashboard'])

@section('content')
<style>
    a {
        text-decoration: none;
    }

    .card a {
        text-decoration: none;
    }

    .card a:hover {
        text-decoration: none;
    }

    .highlight-text {
        color: #6c757d;
        font-weight: bold;
    }

    .primary-text {
        color: #007bff;
        font-weight: bold;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        text-transform: uppercase;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .progress {
        height: 8px;
        border-radius: 5px;
        overflow: hidden;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 5px;
    }

    .amenities-list {
        list-style: none;
        padding: 0;
        text-transform: uppercase;
    }

    .amenities-list li {
        margin-bottom: 5px;
        color: #555;
    }

    .btn-light {
        background-color: #ffffff;
        border: 1px solid #ced4da;
        color: #007bff;
        font-weight: bold;
        text-transform: uppercase;
    }

    .btn-light:hover {
        background-color: #f8f9fa;
        color: #0056b3;
    }

    .chart-container {
        position: relative;
        width: 100%;
        height: 250px;
        margin-top: 15px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                        <h3 class="text-white ps-4" style="text-transform: uppercase;">Total Buildings</h3>
                        <a href="{{ route('admin.addbuilding') }}" class="btn btn-light me-4">Add Building</a>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="row px-4">
                        @foreach($buildings as $building)
                        @php
                        $soldRoomsCount = $building->rooms()->where('status', 'sold')->count();
                        $availableRoomsCount = $building->rooms()->where('status', 'available')->count();
                        $totalRoomsCount = $soldRoomsCount + $availableRoomsCount;

                        $soldPercentage = $totalRoomsCount == 0 ? 0 : round(($soldRoomsCount / $totalRoomsCount) * 100);
                        $availablePercentage = $totalRoomsCount == 0 ? 0 : round(100 - $soldPercentage);

                        $roomTypes = $building->rooms()->distinct()->pluck('room_type')->toArray();

                        $chartLabels = json_encode(array_map('ucfirst', $roomTypes));
                        $chartData = json_encode(array_map(fn($type) => $building->rooms()->where('room_type', $type)->count(), $roomTypes));

                        // Generate unique colors for each room type
                        $colorPalette = ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#6f42c1', '#e83e8c', '#fd7e14'];
                        $uniqueColors = array_combine(
                            $roomTypes,
                            array_slice($colorPalette, 0, count($roomTypes))
                        );
                        $chartColors = json_encode(array_values($uniqueColors));
                        @endphp

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title primary-text mb-3">
                                        <a href="{{ route('admin.rooms.index', ['building_id' => $building->id]) }}" style="text-decoration: none;">
                                            {{ strtoupper($building->building_name) }}
                                        </a>
                                    </h4>

                                    <div class="chart-container">
                                        <canvas id="buildingChart_{{ $building->id }}"></canvas>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="text-muted mb-1">SOLD</p>
                                            <p class="text-muted mb-0">{{ $soldPercentage }}%</p>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">AVAILABLE</p>
                                            <p class="text-muted mb-0">{{ $availablePercentage }}%</p>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $soldPercentage }}%" aria-valuenow="{{ $soldPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $availablePercentage }}%" aria-valuenow="{{ $availablePercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-link p-0" data-bs-toggle="collapse" data-bs-target="#details_{{ $building->id }}" aria-expanded="false" aria-controls="details_{{ $building->id }}"><br>
                                            <i class="fas fa-chevron-down">&nbsp;&nbsp; DETAILS</i>
                                        </button>
                                    </div>

                                    <div class="collapse mt-3" id="details_{{ $building->id }}">
                                        <p class="highlight-text mb-1"><strong>Address:</strong> {{ strtoupper($building->building_address) }}</p>
                                        <p class="highlight-text mb-1"><strong>Super Build-up Area (sq m):</strong> {{ $building->super_built_up_area_sq_m }} sq.ft</p>
                                        <p class="highlight-text mb-1"><strong>Carpet Area (sq m):</strong> {{ $building->carpet_area_sq_m }} sq.ft</p>
                                        <p class="highlight-text mb-1"><strong>Amenities:</strong>
                                        <ul class=" highlight-text mb-1 amenities-list">
                                            @foreach(explode(',', $building->formatted_amenities) as $amenity)
                                            <li>{{ strtoupper(trim($amenity)) }}</li>
                                            @endforeach
                                        </ul></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var ctx = document.getElementById('buildingChart_{{ $building->id }}').getContext('2d');
                                new Chart(ctx, {
                                    type: 'doughnut',
                                    data: {
                                        labels: {!! $chartLabels !!},
                                        datasets: [{
                                            data: {!! $chartData !!},
                                            backgroundColor: {!! $chartColors !!},
                                            hoverBackgroundColor: {!! $chartColors !!},
                                            borderColor: '#fff',
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                display: true,
                                                position: 'top',
                                                labels: {
                                                    boxWidth: 12,
                                                    padding: 10
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
