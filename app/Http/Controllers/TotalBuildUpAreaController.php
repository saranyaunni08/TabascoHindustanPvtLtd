<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Building;
use App\Models\Sale;
use App\Models\Parking;
use App\Models\RoomType;

class TotalBuildUpAreaController extends Controller
{
    public function totalbuildup($building_id)
    {
        $sale = Sale::whereHas('room', function ($query) {
            $query->where('building_id');
        })->first();
        $title = 'Total Breakup';
        $page = 'total-build-up-area-details';
        $building = Building::findOrFail($building_id);
        $apartments = $building->rooms()->where('room_type', 'Flats')->get();

        $commercialspaces = $building->rooms()
            ->whereIn('room_type', ['Shops', 'Tablespaces', 'Kiosks', 'Chairspaces'])
            ->get();
        // Fetch parking spaces specifically linked to flats only
        $parkings = Parking::all();

        // Fetch Apartment Data
        // Fetch rooms associated with this building
        $rooms = Room::where('building_id', $building->id)
            ->with('sales') // Eager load the sales relationship
            ->select('id', 'room_floor', 'room_type', 'room_number', 'flat_build_up_area', 'build_up_area', 'space_area', 'kiosk_area', 'chair_space_in_sq', 'custom_area', 'flat_carpet_area', 'carpet_area', 'expected_amount', 'status')
            ->get()
            ->map(function ($room) {
                // Determine the correct build-up area field based on room type
                $build_up_area = match ($room->room_type) {
                    'Flat' => $room->flat_build_up_area,
                    'Shop' => $room->build_up_area,
                    'Table space' => $room->space_area,
                    'Kiosk' => $room->kiosk_area,
                    'Chair space' => $room->chair_space_in_sq,
                    default => $room->custom_area,
                };

                $carpet_area = match ($room->room_type) {
                    'Flat' => $room->flat_carpet_area,
                    'Shop' => $room->carpet_area,
                    'Table space' => $room->space_area,
                    'Kiosk' => $room->kiosk_area,
                    'Chair space' => $room->chair_space_in_sq,
                    default => $room->custom_area,
                };

                // Calculate Expected/Sq.Ft
                // First, check if flat_build_up_area is greater than zero before division
                $expected_per_sqft = ($room->flat_build_up_area > 0) ? ($room->expected_amount / $room->flat_build_up_area) : 0;

                $sale_amount = $room->sales->isNotEmpty() ? $room->sales->first()->sale_amount : 0;

                // Check if build_up_area is greater than zero before dividing
                $sale_per_sqft = ($build_up_area > 0) ? ($sale_amount / $build_up_area) : 0;

                return [
                    'room_floor' => $room->room_floor,
                    'room_type' => $room->room_type,
                    'room_number' => $room->room_number,
                    'build_up_area' => $build_up_area,
                    'carpet_area' => $carpet_area,
                    'sale_amount' => $room->sales->isNotEmpty() ? $room->sales->first()->sale_amount : 0,
                    'expected_amount' => $room->expected_amount ?? 0,
                    'difference' => ($room->sales->isNotEmpty() ? $room->sales->first()->sale_amount : 0) - ($room->expected_amount ?? 0),
                    'status' => $room->status,
                    'expected_per_sqft' => $expected_per_sqft,
                    'sale_per_sqft' => $sale_per_sqft,
                ];
            });

        // Fetch Commercial Data
        $spaces = Room::with('sales')
            ->select('id', 'room_floor', 'room_type', 'room_number', 'build_up_area', 'space_area', 'kiosk_area', 'chair_space_in_sq', 'custom_area', 'carpet_area', 'expected_amount', 'status')
            ->get()
            ->map(function ($space) {
                $build_up_area = match ($space->room_type) {
                    'Shop' => $space->build_up_area,
                    'Table space' => $space->space_area,
                    'Kiosk' => $space->kiosk_area,
                    'Chair space' => $space->chair_space_in_sq,
                    default => $space->custom_area,
                };

                $carpet_area = match ($space->room_type) {
                    'Shop' => $space->carpet_area,
                    'Table space' => $space->space_area,
                    'Kiosk' => $space->kiosk_area,
                    'Chair space' => $space->chair_space_in_sq,
                    default => $space->custom_area,
                };

                return [
                    'room_floor' => $space->room_floor,
                    'room_type' => $space->room_type,
                    'room_number' => $space->room_number,
                    'build_up_area' => $build_up_area,
                    'carpet_area' => $carpet_area,
                    'sale_amount' => $space->sales->isNotEmpty() ? $space->sales->first()->sale_amount : 0,
                    'expected_amount' => $space->expected_amount ?? 0,
                    'difference' => ($space->sales->isNotEmpty() ? $space->sales->first()->sale_amount : 0) - ($space->expected_amount ?? 0),
                    'status' => $space->status,



                ];
            });

        // Totals
        $totalBuildUpArea = $rooms->sum('build_up_area') + $spaces->sum('build_up_area');
        $totalCarpetArea = $rooms->sum('carpet_area') + $spaces->sum('carpet_area');
        $totalExpectedAmount = $rooms->sum('expected_amount') + $spaces->sum('expected_amount');
        $totalSaleAmount = $rooms->sum('sale_amount') + $spaces->sum('sale_amount');
        $totalDifference = $rooms->sum('difference') + $spaces->sum('difference');

        return view('totalbuildupexcel.total_breakup', compact(
            'title',
            'page',
            'rooms',
            'spaces',
            'totalBuildUpArea',
            'totalCarpetArea',
            'totalExpectedAmount',
            'totalSaleAmount',
            'totalDifference',
            'building',
            'sale',
            'apartments',
            'commercialspaces',
            'parkings',

        ));
    }

    public function index($building_id)
    {
        $title = 'Apartment Breakup';
        $page = 'apartmentbreakup';

        // Fetch the building using the building_id
        $building = Building::findOrFail($building_id);


        // Fetch flats (apartments) for the given building
        $apartments = $building->rooms()
            ->with('sales') // Eager load sales relationship
            ->select('id', 'room_floor', 'room_type', 'room_number', 'flat_build_up_area', 'build_up_area', 'space_area', 'kiosk_area', 'chair_space_in_sq', 'custom_area', 'flat_carpet_area', 'carpet_area', 'expected_amount', 'status')
            ->where('room_type', 'Flats') // Ensure the room_type matches the flats
            ->get()
            ->map(function ($room) {
                // Determine the correct build-up area field
                $build_up_area = $room->flat_build_up_area ?? 0;

                // Determine the correct carpet area field
                $carpet_area = $room->flat_carpet_area ?? 0;
                // Calculate Expected/Sq.Ft
                // First, check if flat_build_up_area is greater than zero before division
                $expected_per_sqft = ($room->flat_build_up_area > 0) ? ($room->expected_amount / $room->flat_build_up_area) : 0;

                $sale_amount = $room->sales->isNotEmpty() ? $room->sales->first()->sale_amount : 0;

                // Check if build_up_area is greater than zero before dividing
                $sale_per_sqft = ($build_up_area > 0) ? ($sale_amount / $build_up_area) : 0;

                return [
                    'room_floor' => $room->room_floor,
                    'room_type' => $room->room_type,
                    'room_number' => $room->room_number,
                    'flat_build_up_area' => $build_up_area, // Use correct key
                    'flat_carpet_area' => $carpet_area,    // Use correct key
                    'sale_amount' => $room->sales->isNotEmpty() ? $room->sales->first()->sale_amount : 0,
                    'expected_amount' => $room->expected_amount ?? 0,
                    'difference' => ($room->sales->isNotEmpty() ? $room->sales->first()->sale_amount : 0) - ($room->expected_amount ?? 0),
                    'status' => $room->status,
                    'expected_per_sqft' => $expected_per_sqft,
                    'sale_per_sqft' => $sale_per_sqft,
                ];
            });



        // Calculate totals
        $totalBuildUpArea = $apartments->sum('build_up_area');
        $totalCarpetArea = $apartments->sum('carpet_area');
        $totalExpectedAmount = $apartments->sum('expected_amount');
        $totalSaleAmount = $apartments->sum('sale_amount');
        $totalDifference = $apartments->sum('difference');

        // Return the view with the necessary data
        return view('totalbuildupexcel.apartment_breakup', compact(
            'title',
            'page',
            'apartments',
            'building',
            'totalBuildUpArea',
            'totalCarpetArea',
            'totalExpectedAmount',
            'totalSaleAmount',
            'totalDifference',
        ));
    }



    public function commercialbreakup($building_id)
    {
        $title = 'Commercial Breakup';
        $page = 'commercialbreakup';

        // Fetch the building using the building_id
        $building = Building::findOrFail($building_id);

        // Retrieve the rooms that match the specified room types for the building
        $commercialspaces = $building->rooms()
            ->whereIn('room_type', ['Shops', 'Tablespaces', 'Kiosks', 'Chairspaces'])
            ->get()
            ->map(function ($space) {
                // Determine the correct build-up area field based on room type
                $build_up_area = match ($space->room_type) {
                    'Shop' => $space->build_up_area,
                    'Table space' => $space->space_area,
                    'Kiosk' => $space->kiosk_area,
                    'Chair space' => $space->chair_space_in_sq,
                    default => $space->custom_area,
                };

                // Determine the correct carpet area field based on room type
                $carpet_area = match ($space->room_type) {
                    'Shop' => $space->carpet_area,
                    'Table space' => $space->space_area,
                    'Kiosk' => $space->kiosk_area,
                    'Chair space' => $space->chair_space_in_sq,
                    default => $space->custom_area,
                };
                // Calculate Expected/Sq.Ft
                // First, check if flat_build_up_area is greater than zero before division
                $expected_per_sqft = ($space->build_up_area > 0) ? ($space->expected_amount / $space->build_up_area) : 0;
                $sale_amount = $space->sales->isNotEmpty() ? $space->sales->first()->sale_amount : 0;

                // Check if build_up_area is greater than zero before dividing
                $sale_per_sqft = ($build_up_area > 0) ? ($sale_amount / $build_up_area) : 0;


                return (object) [
                    'room_floor' => $space->room_floor,
                    'room_type' => $space->room_type,
                    'room_number' => $space->room_number,
                    'build_up_area' => $build_up_area,
                    'carpet_area' => $carpet_area,
                    'sale_amount' => $space->sales->isNotEmpty() ? $space->sales->first()->sale_amount : 0,
                    'expected_amount' => $space->expected_amount ?? 0,
                    'difference' => ($space->sales->isNotEmpty() ? $space->sales->first()->sale_amount : 0) - ($space->expected_amount ?? 0),
                    'status' => $space->status,
                    'expected_per_sqft' => $expected_per_sqft,
                    'sale_per_sqft' => $sale_per_sqft,
                ];
            });

        // Calculate totals for commercial spaces
        $totalBuildUpArea = $commercialspaces->sum('build_up_area');
        $totalCarpetArea = $commercialspaces->sum('carpet_area');
        $totalExpectedAmount = $commercialspaces->sum('expected_amount');
        $totalSaleAmount = $commercialspaces->sum('sale_amount');
        $totalDifference = $commercialspaces->sum('difference');

        return view('totalbuildupexcel.commercial_breakup', compact('commercialspaces', 'totalBuildUpArea', 'totalCarpetArea', 'totalExpectedAmount', 'totalSaleAmount', 'totalDifference', 'title', 'page'));

    }

    public function parkingbreakup($buildingId)
    {
        $title = 'Parking Breakup';
        $page = 'parkingbreakup';
        // Logic for handling the parking breakup
        $building = Building::findOrFail($buildingId);
        // Perform the necessary data fetching or calculations
        // Fetch parking spaces specifically linked to flats only
        $parkings = Parking::all();
        // Calculate the totals
        $totalExpectedSale = $parkings->sum('expected_amount');
        $totalSaleAmount = $parkings->sum('sale_amount');
        $totalDifference = $parkings->sum('difference');

        return view('totalbuildupexcel.parking_breakup', compact('building', 'title', 'page', 'parkings', 'totalExpectedSale', 'totalSaleAmount', 'totalDifference'));
    }


    public function summary($buildingId)
    {
        // Fetch the building and related rooms
        $building = Building::with('rooms')->findOrFail($buildingId);

        // Calculate the total square feet for all rooms
        $totalSqFt = $building->rooms->sum('flat_build_up_area');

        // Calculate the total square feet sold
        $totalSqFtSold = $building->rooms
            ->where('status', 'SOLD') // Filter sold rooms
            ->sum('flat_build_up_area');

        // Calculate the balance square feet
        $balanceSqFt = $totalSqFt - $totalSqFtSold;


        // Calculate the total commercial total square feet
        $commercialTotalSqft = $building->rooms->sum('build_up_area');

        //Calculate the total commercial total square feet sold 
        $commercialTotalSqftSold = $building->rooms
            ->where('status', 'SOLD') // Filter sold rooms
            ->sum('build_up_area');

        $commercialBalanceSqft = $commercialTotalSqft - $commercialTotalSqftSold;
        // Filter only apartments from rooms
        $apartments = $building->rooms->where('type', 'Flats');

        // Calculate the total expected amount for apartments
        $totalExpectedAmount = $apartments->sum('expected_amount');
        // Fetch parking data related to the building
        $parkings = Parking::all();
        // Calculate the totals
        $ParkingtotalExpectedSale = $parkings->sum('expected_amount');
        // calculate the totalexpected amount for commercial spaces
        $commercialspaces = $building->rooms->where('type', 'Shops', 'Tablespaces', 'Kiosks', 'Chairspaces');
        $totalcommercialExpectedAmount = $commercialspaces->sum('expected_amount');

        // calculate the totalexpected sale 

        // Calculate the total expected sale by summing the amounts
        $totalExpectedSale = $totalExpectedAmount + $ParkingtotalExpectedSale + $totalcommercialExpectedAmount;

        // Calculate the total sale amount for apartments sold
        $apartmentsSold = $apartments->where('status', 'SOLD')->sum('sale_amount');
        // Calculate the total sale amount for parking sold
        $parkingSold = $parkings->where('status', 'SOLD')->sum('sale_amount');
        // Calculate the total sale amount for commercial spaces sold
        $commercialSold = $commercialspaces->where('status', 'SOLD')->sum('sale_amount');
        // Calculate the total sale amount for all sold properties (apartments, parking, and commercial)
        $totalSold = $apartmentsSold + $parkingSold + $commercialSold;


        // Pass the data to the view
        $title = 'Summary';
        $page = 'summarypage';

        // Correct compact usage by removing extra spaces
        return view('totalbuildupexcel.summary', compact(
            'building',
            'title',
            'page',
            'totalSqFt',
            'totalSqFtSold',
            'balanceSqFt',
            'commercialTotalSqft',
            'commercialTotalSqftSold',
            'commercialBalanceSqft',
            'totalExpectedAmount',
            'ParkingtotalExpectedSale',
            'totalcommercialExpectedAmount',
            'totalExpectedSale',
            'apartmentsSold',
            'parkingSold',
            'commercialSold',
            'totalSold'
        ));
    }



    public function balancesummary($buildingId)
    {
        // Fetch the building and related rooms
        $building = Building::with('rooms')->findOrFail($buildingId);

        // Fetch all room types
        $roomTypes = Roomtype::all();

        // Filter only apartments (Flats)
        $apartments = $building->rooms->where('type', 'Flats');

        // Calculate the total square feet for all apartments
        $totalSqFt = $apartments->sum('flat_build_up_area');

        // Calculate the total square feet sold for apartments
        $salesSqFt = $apartments->where('status', 'SOLD')->sum('flat_build_up_area');

        // Calculate the total sale amount for all apartments (sold and unsold)
        $saleAmount = $apartments->sum('sale_amount');

        // Calculate the expected balance amount for apartments (expected_amount - sale_amount)
        $expectedBalanceAmount = $apartments->sum('expected_amount') - $saleAmount;

        // Calculate the balance square feet for apartments
        $balanceSqFt = $totalSqFt - $salesSqFt;

        $commercial = $building->rooms->where('type', 'Shops');
        // Calculate the total square feet for all commercial
        $totalSqFtcommercial = $commercial->sum('build_up_area');
        // Calculate the total square feet sold for commercial
        $salesSqFtcommercial = $commercial->where('status', 'SOLD')->sum('build_up_area');
        // Calculate the total sale amount for all commercial (sold and unsold)
        $saleAmountcommercial = $commercial->sum('sale_amount');
        // Calculate the expected balance amount for commercial (expected_amount - sale_amount)
        $expectedBalanceAmountcommercial = $commercial->sum('expected_amount') - $saleAmountcommercial;

        // Calculate the balance square feet for commercial
        $balanceSqFtcommercial = $totalSqFtcommercial - $salesSqFtcommercial;

        // Fetch all parking records
        $parkings = Parking::all();

        // Get the total count of parking entries
        $parkingno = $parkings->count();
        // Calculate the total sale amount for parking
        $parkingSaleAmount = $parkings->sum('sale_amount');

        //calculate the total total sqft
        $Totaltotalsqft =  $totalSqFt + $totalSqFtcommercial + $parkingno;
        
        //calculate the total sales sqft
        $Totalsalessqft = $salesSqFt + $salesSqFtcommercial;

        //calculate the total sale amount
        $Totalsaleamount = $saleAmount + $saleAmountcommercial + $parkingSaleAmount;

        //calculate total balance sqft
        $TotalBalancesqft = $balanceSqFt +  $balanceSqFtcommercial;

       //calculate total expected balance amount
       $TotalExpectedBalanceAmount =  $expectedBalanceAmount + $expectedBalanceAmountcommercial;


        // Pass the data to the view
        $title = 'Balance Summary';
        $page = 'balancesummary';

        return view('totalbuildupexcel.balance_summary', compact(
            'building',
            'title',
            'page',
            'totalSqFt',
            'salesSqFt',
            'saleAmount',
            'expectedBalanceAmount',
            'balanceSqFt',
            'roomTypes',  // Pass room types to the view
            'commercial',
            'totalSqFtcommercial',
            'salesSqFtcommercial',
            'saleAmountcommercial',
            'expectedBalanceAmountcommercial',
            'balanceSqFtcommercial',
            'parkings',
            'parkingno',
            'parkingSaleAmount',
            'Totaltotalsqft',
            'Totalsalessqft',
            'Totalsaleamount',
            'TotalExpectedBalanceAmount',
            'TotalBalancesqft',

        ));
    }


    public function changesinExpectedamount($buildingId)
    {
        // Logic to handle the "changes in expected amount"
        // For example:
        $building = Building::find($buildingId);
        $title = 'Changes In Expected Amount';
        $page = 'changesinexpectedamount';
        return view('totalbuildupexcel.changes_in_expected_amount', compact('building', 'title', 'page'));
    }



}
