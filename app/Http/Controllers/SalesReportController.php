<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function allSales($buildingId)
    {
        $title = 'Sales Report';
        $page = 'sales-report';

        // Fetch shop sales data
        $shopSalesData = Room::where('building_id', $buildingId)
            ->where('room_type', 'Shops')
            ->with(['sale' => function ($query) {
                $query->select('room_id', 'sale_amount', 'client_name');
            }])
            ->get(['room_floor', 'room_number', 'room_type', 'build_up_area']);

        $totalShopSqft = $shopSalesData->sum('build_up_area');
        $totalShopSaleAmount = $shopSalesData->sum(function ($room) {
            return $room->sale ? $room->sale->sale_amount : 0;
        });

        // Fetch apartment sales data
        $apartmentSalesData = DB::table('rooms')
            ->join('sales', 'rooms.room_id', '=', 'sales.room_id')
            ->where('rooms.room_type', 'flats')
            ->select(
                'rooms.room_floor as apartment_floor',
                'rooms.room_number as apartment_number',
                'rooms.room_type as apartment_type',
                'rooms.flat_build_up_area as build_up_area',
                'sales.sale_amount as sales_amount',
                'sales.customer_name as client_name',
                DB::raw('(sales.sale_amount * rooms.build_up_area) as total_sale_amount')
            )
            ->get();

        $totalApartmentSqft = $apartmentSalesData->sum('build_up_area');
        $totalApartmentSaleAmount = $apartmentSalesData->sum('total_sale_amount');

        return view('sales.all', compact(
            'title',
            'page',
            'shopSalesData',
            'totalShopSqft',
            'totalShopSaleAmount',
            'apartmentSalesData',
            'totalApartmentSqft',
            'totalApartmentSaleAmount'
        ));
    }
}
