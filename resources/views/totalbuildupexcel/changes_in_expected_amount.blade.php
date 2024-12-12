@extends('layouts.default')

@section('content')
<div class="container">


    <h3 class="text-center my-4">CHANGES IN EXPECTED AMOUNT</h3>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th>NO</th>
                        <th>FLOOR</th>
                        <th>TYPE</th>
                        <th>DOOR NO</th>
                        <th>BUILT UP AREA (In Sq Ft)</th>
                        <th>CARPET AREA (In Sq Ft)</th>
                        <th>EXPECTED PER SQFT (OLD)</th>
                        <th>CHANGED ON</th>
                        <th>EXPECTED PER SQFT (NEW)</th>
                        <th>₹ EXPECTED</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ground Floor Section -->
                    <tr class="table-secondary">
                        <td colspan="10" class="text-center">Ground Floor</td>
                    </tr>
                    <tr class="text-center">
                        <td>7</td>
                        <td>Ground Floor</td>
                        <td>Shop</td>
                        <td>7</td>
                        <td>229</td>
                        <td>183.2</td>
                        <td>4600</td>
                        <td>15-09-2024</td>
                        <td>4800</td>
                        <td>10,53,400</td>
                    </tr>
                    <!-- Add more rows for Ground Floor -->

                    <!-- 1st Floor Section -->
                    <tr class="table-secondary">
                        <td colspan="10" class="text-center">1st Floor</td>
                    </tr>
                    <tr class="text-center">
                        <td>31</td>
                        <td>1st Floor</td>
                        <td>Shop</td>
                        <td>1</td>
                        <td>976</td>
                        <td>780.8</td>
                        <td>4500</td>
                        <td>01-09-2024</td>
                        <td>5000</td>
                        <td>43,92,000</td>
                    </tr>
                    <!-- Add more rows for 1st Floor -->

                    <!-- 2nd Floor Section -->
                    <tr class="table-secondary">
                        <td colspan="10" class="text-center">2nd Floor</td>
                    </tr>
                    <tr class="text-center">
                        <td>83</td>
                        <td>2nd Floor</td>
                        <td>Shop</td>
                        <td>17</td>
                        <td>575</td>
                        <td>460</td>
                        <td>4500</td>
                        <td>15-09-2024</td>
                        <td>4800</td>
                        <td>25,87,500</td>
                    </tr>
                    <!-- Add more rows for 2nd Floor -->
                </tbody>
            </table>
        </div>
    </div>


</div>
@endsection