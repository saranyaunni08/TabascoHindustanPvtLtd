<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;

class BankAccountController extends Controller
{
    public function bankaccount($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Bank Account';
        $page = 'bank account';

        //Return view with the data
        return view('bankaccount.bank_account',compact(
            'building',
            'title',
            'page'
        ));
    }

    public function axisbank($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Axis Bank Account';
        $page = 'axis bank account';

        //Return view with the data
        return view('bankaccount.axisbankaccount',compact(
            'building',
            'title',
            'page'
        ));
    }

    public function canarabank($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Canara Bank Account';
        $page = 'canara bank account';

        //Return view with the data
        return view('bankaccount.canarabankaccount',compact(
            'building',
            'title',
            'page'
        ));
    }

    public function sbi($buildingId){
        $building = Building::findOrFail($buildingId);
        $title = 'Sbi Account';
        $page = 'sbi account';

        //Return view with the data
        return view('bankaccount.sbiaccount',compact(
            'building',
            'title',
            'page'
        ));
    }
}
