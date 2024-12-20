<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Building;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function allSales($buildingId)
    {
        $title = 'Sales Report';
        $page = 'sales-report';
        $building = Building::findOrFail($buildingId);

        $shopSalesData = Room::where('building_id', $buildingId)
        ->where('room_type', 'Shops')
        ->where('status', 'sold') // Add this condition to fetch sold shops
        ->with([
            'sale' => function ($query) {
                $query->select('room_id', 'sale_amount', 'customer_name');
            }
        ])
        ->get(['room_floor', 'room_number', 'room_type', 'build_up_area']);

        $totalShopSqft = $shopSalesData->sum('build_up_area');
        $totalShopSaleAmount = $shopSalesData->sum(function ($room) {
            return $room->sale ? $room->sale->sale_amount : 0;
        });

        // Fetch apartment sales data
        $apartmentSalesData = Room::where('building_id', $buildingId)
            ->where('room_type', 'Flats')
            ->where('status', 'sold') // Add condition to fetch only sold flats
            ->with([
                'sale' => function ($query) {
                    $query->select('room_id', 'sale_amount', 'customer_name');
                }
            ])
            ->get(['room_floor', 'room_number', 'room_type', 'flat_build_up_area']);

        $totalApartmentSqft = $apartmentSalesData->sum('flat_build_up_area');
        $totalApartmentSaleAmount = $apartmentSalesData->sum(function ($room) {
            return $room->sale ? $room->sale->sale_amount : 0;
        });

        $parkingSalesData = DB::table('parkings')
        ->leftJoin('sales', 'parkings.id', '=', 'sales.parking_id') // Use LEFT JOIN to fetch all occupied parkings
        ->where('parkings.status', 'occupied') // Filter for occupied parking slots
        ->select([
            'parkings.floor_number',         // Select floor number from parkings
            'parkings.slot_number',          // Select slot number from parkings
            'parkings.purchaser_name',       // Select purchaser name from parkings
            'sales.sale_amount as sale_amount' // Select sale amount from sales table
        ])
        ->get();
    
    

        $totalParkingSales = $parkingSalesData->sum('sale_amount');


        // Total area and sales amount
        $totalSqft = $totalShopSqft + $totalApartmentSqft;
        $totalSalesAmount = $totalShopSaleAmount + $totalApartmentSaleAmount + $totalParkingSales;


        $totalSqft = $totalShopSqft + $totalApartmentSqft;
        return view('sales.all', compact(
            'title',
            'page',
            'shopSalesData',
            'totalShopSqft',
            'totalShopSaleAmount',
            'apartmentSalesData',
            'totalApartmentSqft',
            'totalApartmentSaleAmount',
            'totalSqft',// Pass this variable
            'totalParkingSales',
            'totalSqft',
            'totalSalesAmount',
            'parkingSalesData',
            'building'
        ));

    }
    public function commercial($buildingId)
    {

        $building = Building::findOrFail($buildingId);
        $title = 'Commercial Sales';
        $page = 'commercial sales';
        // Fetch "sold" shop sales data
        $shopSalesData = Room::where('building_id', $buildingId)
            ->where('room_type', 'Shops')
            ->where('status', 'sold') // Add this condition to fetch sold shops
            ->with([
                'sale' => function ($query) {
                    $query->select('room_id', 'sale_amount', 'customer_name');
                }
            ])
            ->get(['room_floor', 'room_number', 'room_type', 'build_up_area']);

        $totalShopSqft = $shopSalesData->sum('build_up_area');
        $totalShopSaleAmount = $shopSalesData->sum(function ($room) {
            return $room->sale ? $room->sale->sale_amount : 0;
        });


        return view('sales.commercial', compact(
            'building',
            'title',
            'page',
            'shopSalesData',
            'totalShopSqft',
            'totalShopSaleAmount'
        ));
    }

    public function apartment($buildingId)
    {

        $building = Building::findOrFail($buildingId);
        $title = 'Apartment Sales';
        $page = 'apartment sales';

        // Fetch apartment sales data
        $apartmentSalesData = Room::where('building_id', $buildingId)
            ->where('room_type', 'Flats')
            ->where('status', 'sold') // Add condition to fetch only sold flats
            ->with([
                'sale' => function ($query) {
                    $query->select('room_id', 'sale_amount', 'customer_name');
                }
            ])
            ->get(['room_floor', 'room_number', 'room_type', 'flat_build_up_area']);

        $totalApartmentSqft = $apartmentSalesData->sum('flat_build_up_area');
        $totalApartmentSaleAmount = $apartmentSalesData->sum(function ($room) {
            return $room->sale ? $room->sale->sale_amount : 0;
        });

        return view('sales.apartments', compact(
            'building',
            'title',
            'page',
            'apartmentSalesData',
            'totalApartmentSqft',
            'totalApartmentSaleAmount'
        ));

    }

    public function parking($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $title = 'Parking';
        $page = 'parking';

        $parkingSalesData = DB::table('parkings')
        ->leftJoin('sales', 'parkings.id', '=', 'sales.parking_id') // Use LEFT JOIN to fetch all occupied parkings
        ->where('parkings.status', 'occupied') // Filter for occupied parking slots
        ->select([
            'parkings.floor_number',         // Select floor number from parkings
            'parkings.slot_number',          // Select slot number from parkings
            'parkings.purchaser_name',       // Select purchaser name from parkings
            'sales.sale_amount as sale_amount' // Select sale amount from sales table
        ])
        ->get();


        $totalParkingSales = $parkingSalesData->sum('sale_amount');


        return view('sales.parking', compact(
            'building',
            'title',
            'page',
            'parkingSalesData',
            'totalParkingSales'
        ));
    }

    public function summary($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $title = 'Summary';
        $page = 'summary';
        return view('sales.summary', compact(
            'building',
            'title',
            'page',

        ));
    }

}
