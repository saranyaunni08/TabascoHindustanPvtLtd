<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Sale;
class ExchangeReportController extends Controller
{
    public function exchangereturnreport($buildingId)
    {
        // Fetch the building by ID
        $building = Building::findOrFail($buildingId);
    
        // Fetch customer_name, sale_amount, room details from sales where exchangestatus = 'EX'
        $sales = Sale::where('exchangestatus', 'EX')
            ->join('rooms', 'sales.room_id', '=', 'rooms.id')  // Join with rooms table based on room_id
            ->select('sales.customer_name', 'sales.sale_amount', 'sales.exchange_sale_id', 'rooms.room_floor', 'rooms.shop_number', 'rooms.room_type', 'rooms.build_up_area')
            ->get();
    
        // Initialize an empty array to hold the exchanged sale data
        foreach ($sales as $sale) {
            // Fetch the exchanged sale using the exchange_sale_id
            $exchangedSale = Sale::where('sales.id', $sale->exchange_sale_id)
                ->join('rooms', 'sales.room_id', '=', 'rooms.id')  // Join with rooms table based on room_id
                ->select(
                    'rooms.room_floor as exchange_room_floor', 
                    'rooms.shop_number as exchange_shop_number', 
                    'rooms.room_type as exchange_room_type', 
                    'rooms.build_up_area as exchange_build_up_area', 
                    'sales.sale_amount as exchange_sale_amount'
                )
                ->first();
    
            // Add the exchanged sale data to the sales object
            $sale->exchangedSale = $exchangedSale;

        
        }
    
        // Title and page data
        $title = 'Exchange-Report';
        $page = 'exchange report';
    
        // Return the view with the data
        return view('exchangereport.exchange_report', compact(
            'building',
            'sales',  // Pass sales data to the view
            'title',
            'page'
        ));
    }
    


    public function exchangeandreturnsummary($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $title = 'Exchange And Return Summary';
        $page = 'exchange and return summary';

        //Return view with the data
        return view('exchangereport.exchangeandreturnsummary', compact(
            'building',
            'title',
            'page'
        ));
    }
}
