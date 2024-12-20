<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class CashBookController extends Controller
{
    public function cashbook($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Cashbook';
        $page = 'cash book';

        //Return view with the data
        return view('cashbook.cash_book',compact(
            'building',
            'title',
            'page'
        ));
    }
    public function basheercurrentaccount($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Basheer Current Account';
        $page = 'Basheer Current Account';

        //Return view with the data
        return view('cashbook.BasheerCurrentAccount',compact(
            'building',
            'title',
            'page'
        ));
    }

    public function pavoorcurrentaccount($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Pavoor Current Account';
        $page = 'Pavoor Current Account';

        //Return view with the data
        return view('cashbook.PavoorCurrentAccount',compact(
            'building',
            'title',
            'page'
        ));
    }
    
    
}
