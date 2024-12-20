<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
class SalesReturnReportController extends Controller
{
    public function returnreportall($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $title = 'Return Report All';
        $page = 'sales-return-report';

        // Return view with the data
        return view('salesreturn.returnreportall', compact(
           
            'building',
            'title',
            'page'
        ));
    }

    public function commercialreturn($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Commercial Sales Return Report';
        $page = 'commercial-sales-return-report';

        // Return view with the data 
        return view('salesreturn.commercial',compact(
            'building',
            'title',
            'page'
        ));
    }


    public function apartmentreturn($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Apartment Sales Return Report';
        $page = 'apartment-sales-return-report';

        // Return view with the data
       return view('salesreturn.apartment',compact(
        'building',
        'title',
        'page'
       ));
    }

    public function parkingreturn($buildingId){
       $building = Building::findOrFail($buildingId);
       $title = 'Parking Sales Return Report';
       $page = 'parking-sales-return-report';
       
       
       // Return view with the data
       return view('salesreturn.parking',compact(
        'building',
        'title',
        'page'
       ));
    }

}
