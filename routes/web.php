<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterSettingsController;
use App\Http\Controllers\EditDeleteAuthController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ExchangeController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\BankController;



Route::get('/', function () {
    return redirect('login');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('do-login', 'doLogin')->name('dologin');
    Route::get('forgot-password', 'forgotPassword')->name('pswreset');
    Route::get('forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('forgot-password', 'forgotPassword')->name('password.email');
    Route::get('reset-password/{token}', 'showResetPasswordForm')->name('password.reset');
    Route::post('reset-password', 'resetPassword')->name('password.update');
    Route::get('reset-password', 'resetPassword')->name('password.update');
    Route::post('/forgot-password', 'forgotPassword')->name('forgot_password');
    Route::post('/forgot_password', 'sendResetLinkEmail')->name('forgot_password');
    Route::get('/forgot_password', 'sendResetLinkEmail')->name('forgot_password');
});

    Route::middleware('auth:admin')->prefix('admin')->group(function () {
        Route::name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/buildings', [BuildingController::class, 'index'])->name('building');
        Route::get('/add-building', [BuildingController::class, 'create'])->name('addbuilding');
        Route::get('/edit-building/{id}', [BuildingController::class, 'edit'])->name('building.editbuilding');
        Route::post('/update-building/{id}', [BuildingController::class, 'update'])->name('building.update');
        Route::post('/buildingstore', [BuildingController::class, 'store'])->name('addbuilding.store');

        Route::get('/building', [BuildingController::class, 'index'])->name('building.index');

        Route::delete('/buildings/{id}', [BuildingController::class, 'destroy'])->name('building.delete');

        Route::get('/buildings/{id}', [BuildingController::class, 'show'])->name('buildings.show');

        Route::get('/buildings/{building_id}/rooms', [RoomController::class, 'showRooms'])->name('buildings.rooms');
        Route::resource('rooms', RoomController::class)->except(['show']);

        Route::get('/rooms/{id}', [RoomController::class, 'show'])->name('rooms.show')->middleware('auth:admin');

        Route::get('/buildings/{id}', [RoomController::class, 'show'])->name('buildings.show');

        Route::get('/rooms', [RoomController::class, 'showRooms'])->name('rooms.index');

        Route::get('rooms/create/{building_id}', [RoomController::class, 'create'])->name('rooms.create');
        // Route::get('/rooms/create/{building_id}', [RoomController::class, 'create'])->name('rooms.create');

        Route::post('admin/rooms', [RoomController::class, 'store'])->name('rooms.store');

        Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');
      
        Route::put('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
        
        Route::get('/shops/{id}/edit', [RoomController::class, 'edit'])->name('shops.edit');

        Route::put('/shops/{id}', [RoomController::class, 'update'])->name('shops.update');

        // Route::delete('/shops/{id}', [RoomController::class, 'destroy'])->name('shops.destroy');
        Route::post('/admin/rooms/store', [RoomController::class, 'store'])->name('admin.rooms.store');
        // Route::put('rooms/{id}/sell', [RoomController::class, 'processSell'])->name('rooms.sell');
        Route::get('/rooms/{room}/sell', [SaleController::class, 'create'])->name('sales.create');

        Route::get('/buildings/{building_id}/rooms', [RoomController::class, 'showRooms'])->name('buildings.rooms');

        Route::delete('sales/{id}/soft-delete', [SaleController::class, 'softDelete'])->name('sales.soft-delete');

        Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');

        Route::post('/sales/cac-type', [SaleController::class, 'getCalculationType'])->name('sales.caltype');

        Route::get('/customers/sales/{saleId}', [SaleController::class, 'showCustomer'])->name('customers.show');

        // Route::get('/room-dashboard', [RoomController::class, 'dashboard'])->name('room-dashboard');

        Route::get('/room-dashboard/{building_id}', [RoomController::class, 'showBuildingRooms'])->name('building-room-dashboard');

        Route::get('/get-gst-percentages', [MasterSettingsController::class, 'getGstPercentages'])->name('getGstPercentages');

        Route::get('/flats/{building_id}', [RoomController::class, 'showFlats'])->name('flats.index');

        Route::get('/shops/{building_id}', [RoomController::class, 'showShops'])->name('shops.index');

        Route::get('/buildings/{building_id}/chair-spaces', [RoomController::class, 'chairSpaces'])->name('chair-spaces.index');

        Route::get('/buildingdashboard', [BuildingController::class, 'index'])->name('buildingdashboard');


        // Route::post('/installments/{sale}/mark-paid', [SaleController::class, 'markInstallmentPaid'])->name('installments.markPaid');

        
        
        Route::get('/rooms/difference/{building_id}', [RoomController::class, 'difference'])
        ->name('flats.difference');
        
        Route::get('/rooms/difference/shops/{building_id}', [RoomController::class, 'shopsDifference'])->name('shops.difference');


        Route::get('/buildings/{building_id}/kiosks', [RoomController::class, 'showKiosks'])->name('kiosks.index');
        Route::get('/buildings/{building_id}/chair-spaces', [RoomController::class, 'showChairSpaces'])->name('chair-spaces.index');
        Route::get('/buildings/{building_id}/table-spaces', [RoomController::class, 'showTableSpaces'])->name('table-spaces.index');


        // Route::put('/installments/markAsPaid', [SaleController::class, 'markAsPaid'])->name('installments.markAsPaid');

        // Route::put('/installments/{id}/markAsPaid', [SaleController::class, 'markAsPaid'])->name('installments.markAsPaid');
        // Route::put('/customers/{customer}/installments/{installment}/markAsPaid', [SaleController::class, 'markAsPaid'])->name('installments.markAsPaid');
        // Route::put('/installments/markMultipleAsPaid', [SaleController::class, 'markMultipleAsPaid'])->name('installments.markMultipleAsPaid');

        Route::put('/customers/{id}', [SaleController::class, 'update'])->name('customers.update');

        Route::get('customers/total-customers', [RoomController::class, 'totalCustomers'])->name('customers.total_customers');

        Route::get('/customers/{customerName}/download', [SaleController::class, 'downloadCustomerDetails'])->name('customers.download');
        Route::get('/customers/download-pdf/{customerName}', [SaleController::class, 'downloadPdf'])->name('customers.downloadPdf');

        // Route::get('/installments/{id}/downloadPdf', [SaleController::class, 'downloadInstallmentPdf'])->name('installments.downloadPdf');
        // Route::get('/test-pdf', function () {
        //     return view('test_pdf');
        // });
        
    //   cash segment of return and cancel 

        Route::get('/sales/{saleId}/cancel', [SaleController::class, 'cancelSale'])->name('sales.cancel');
        Route::post('/sales/{saleId}/cancel', [SaleController::class, 'cancelSale'])->name('sales.cancel');

        Route::get('/sales/cancelleddetails/{id}', [SaleController::class, 'listCancelledSales'])->name('sales.list_cancelled_details');
        Route::get('sales/details/{saleId}', [SaleController::class, 'showCancelledDetails'])->name('sales.cancelled_details');

        Route::patch('/sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancelled');

        Route::get('/sales/{saleId}/details', [SaleController::class, 'return'])->name('sales.returndetails');
        Route::post('/sales/{sale}/add-deduction', [SaleController::class, 'addDeduction'])->name('sales.addDeduction');

        Route::get('/sales/{sale}/returns/{return}/edit', [SaleController::class, 'edit'])->name('sales.returns.edit');
        Route::put('/sales/{sale}/returns/{return}', [SaleController::class, 'update'])->name('sales.returns.update');
        Route::delete('/sales/{sale}/returns/{return}', [SaleController::class, 'destroy'])->name('sales.returns.destroy');

        
        Route::get('/edit-delete-login', [EditDeleteAuthController::class, 'showLogin'])->name('edit_delete_auth.show_login');
        Route::post('/edit-delete-login', [EditDeleteAuthController::class, 'authenticate'])->name('edit_delete_auth.authenticate');
        Route::post('/edit-delete-logout', [EditDeleteAuthController::class, 'logout'])->name('edit_delete_auth.logout');

    // cheque segment in cancel and return section 

        Route::get('sales/{saleId}/cheque-installments', [SaleController::class, 'calculateChequeInstallments'])->name('sales.chequeInstallments');



        Route::post('/auth', [EditDeleteAuthController::class, 'authenticate'])->name('auth');
        
        Route::get('/rooms/{roomId}/{buildingId}/edit', [EditDeleteAuthController::class, 'showEditPage'])->name('rooms.edit');
        Route::post('/rooms/{roomId}/{buildingId}/edit', [EditDeleteAuthController::class, 'authenticate'])->name('rooms.authenticate');

        Route::post('/edit-delete-logout', [EditDeleteAuthController::class, 'logout'])->name('edit_delete_auth.logout');

      
        Route::delete('/rooms/{roomId}/{buildingId}', [EditDeleteAuthController::class, 'deleteRoom'])->name('rooms.destroy');
        Route::delete('/rooms/destroy/{roomId}/{buildingId}', [EditDeleteAuthController::class, 'destroyFlat'])->name('rooms.destroy.flat');
        Route::delete('/rooms/{roomId}/{buildingId}/deleteShops', [EditDeleteAuthController::class, 'deleteShops'])->name('rooms.deleteShops');
        Route::delete('/rooms/{roomId}/{buildingId}/deleteKiosk', [EditDeleteAuthController::class, 'deleteKiosk'])->name('rooms.destroy.Kiosk');
        Route::delete('/rooms/{roomId}/{buildingId}/deleteTableSpace', [EditDeleteAuthController::class, 'deleteTableSpace'])->name('rooms.destroy.deleteTableSpace');
        Route::delete('/rooms/{roomId}/{buildingId}/deleteChairSpace', [EditDeleteAuthController::class, 'deleteChairSpace'])->name('rooms.destroy.chairspace');
       
        Route::get('/kiosk/difference/{buildingId}', [RoomController::class, 'kioskDifference'])->name('kiosk.difference');
        Route::get('/chair-spaces/difference/{building_id}', [RoomController::class, 'showChairSpaceDifference'])->name('chair_spaces.difference');
        Route::get('/table-space/difference/{building_id}', [RoomController::class, 'showTableSpaceDifference'])->name('table_spaces.difference');

        Route::get('/rooms/sell/{room}/{buildingId}', [RoomController::class, 'showSellForm'])->name('rooms.sell');

        //partners
        Route::get('/partners/create', [PartnerController::class, 'create'])->name('partners.create');
        Route::post('/partners', [PartnerController::class, 'store'])->name('partners.store');
        Route::get('/partners/list', [PartnerController::class, 'listPartners'])->name('partners.list');
        Route::get('/partners/edit/{id}', [PartnerController::class, 'edit'])->name('partners.edit');
        Route::delete('/partners/destroy/{id}', [PartnerController::class, 'destroy'])->name('partners.destroy');
        Route::put('/partners/update/{id}', [PartnerController::class, 'update'])->name('partners.update');




        // In routes/web.php
        Route::get('/partners/cash-in-hand', [PartnerController::class, 'cashInHand'])->name('partners.cash_in_hand');

        // New route for marking as paid
        Route::put('/partners/{partner}/mark-paid', [PartnerController::class, 'markAsPaid'])->name('partners.mark_paid');


            // Route to display the form for adding a new room type
        Route::get('/room-types/create', [RoomTypeController::class, 'create'])->name('room_types.create');

        // Route to store the new room type
        Route::post('/room-types', [RoomTypeController::class, 'store'])->name('room_types.store');

        // Route to display the list of room types
        Route::get('/room-types', [RoomTypeController::class, 'index'])->name('room_types.index');

        // In web.php or your routes file

        Route::get('/custom-rooms/{building_id}', action: [RoomController::class, 'showCustomRooms'])->name('custom_rooms');

        Route::get('/rooms/other-types-difference/{building_id}', [RoomController::class, 'otherRoomTypesDifference'])->name('rooms.other_types_difference');



        
        Route::get('/statement-cash/{sale}', [StatementController::class, 'cash'])->name('statement-cash');
        Route::get('/statement-cheque/{sale}', [StatementController::class, 'cheque'])->name('statement-cheque');
        Route::get('/statement-all/{sale}', [StatementController::class, 'all'])->name('statement-all');
        Route::get('/statement-summary/{sale}', [StatementController::class, 'summary'])->name('statement-summary');


        Route::get('/cash-statement/{sale}/download', [StatementController::class, 'downloadCashStatement'])
        ->name('cash-statement.download');

        Route::get('/cheque-statement/download/{id}', [StatementController::class, 'downloadChequeStatement'])->name('cheque-statement.download');

        Route::get('/buildings/{buildingId}/customers', [SaleController::class, 'index'])->name('building.customers');

        Route::get('/statements/commercial-sales-report', [StatementController::class, 'commercialSalesReport'])->name('statements.commercial-sales-report');
       //shops
        Route::get('/admin/statements/shop-sales-report', [StatementController::class, 'shopSalesReport'])->name('statements.shop-sales-report');
       //Flats
        Route::get('/admin/statements/apartments-sales-report', [StatementController::class, 'apartmentSalesReport'])->name('statements.apartments-sales-report');

        // Route::get('/commercial-sales-summary', [StatementController::class, 'commercialSalesSummary'])->name('statements.commercialsummary');
        Route::get('/commercial-sales-summary', [StatementController::class, 'salesSummary'])->name('statements.commercialsummary');
        Route::get('/customer/info/{saleId}', [StatementController::class, 'displayCustomerInfo'])->name('customer.info');
        // routes/web.php
        Route::get('/buildings/{building_id}/available-rooms', [StatementController::class, 'showAvailableRooms'])->name('rooms.available');
        Route::get('/buildings/{building}/available-shops', [StatementController::class, 'availableShops'])->name('available.shops');
        Route::get('/buildings/{building}/available-flats', [StatementController::class, 'showAvailableFlats'])->name('available.flats');
    
        Route::resource('parking', ParkingController::class);

//installment markig section 
        Route::get('/sales/{saleId}/installments', [InstallmentController::class, 'show'])->name('installments.show');
        Route::get('/sales/{saleId}/cash-installments', [InstallmentController::class, 'showCashInstallments'])->name('cash_installments.show');

        Route::post('/sales/{saleId}/installments/mark-paid', [InstallmentController::class, 'markPayment'])->name('installments.markPayment');
        Route::post('/cash-installments/mark-payment/{sale}', [InstallmentController::class, 'cashMarkPayment'])->name('cashInstallments.markPayment');
        // web.php
        Route::get('/installments/download-pdf/{saleId}', [InstallmentController::class, 'downloadPdf'])->name('installments.downloadPdf');
        //full page download of instllment marking page 
        Route::get('/admin/installments/{saleId}/download-full-pdf', [InstallmentController::class, 'downloadFullInstallmentPdf'])->name('installments.downloadFullPdf');
                
        // New route for the Confirm Exchange page
        Route::get('/customer/exchange/{saleId}/{building_id}', [StatementController::class, 'confirmExchange'])->name('exchange.confirm');
        // Route::post('/customer/exchange/update/{saleId}', [StatementController::class, 'updateExchange'])->name('exchange.update');
        // Route::get('/sales/finalize-exchange/{saleId}', [StatementController::class, 'finalizeExchange'])->name('sales.finalizeexchange');
        // routes/web.php
        Route::get('/customer/exchange/availability/{building_id}/{sale_id}', [StatementController::class, 'showAvailability'])->name('exchange.availability');


        Route::get('/customer/exchangesell', [ExchangeController::class, 'showExchangeSellPage'])->name('exchangesell');
        Route::post('/exchangesales/store', [ExchangeController::class, 'store'])->name('exchangesales.store');

        // return module

        Route::post('/sales/{sale}/returns', [SaleController::class, 'storeReturns'])->name('sales.returns.store');
        Route::post('/sales/{sale}/chequereturns', [SaleController::class, 'storechequeReturns'])->name('sales.chequereturns.store');
        Route::post('/sales/{sale}/add-cheque-deduction', [SaleController::class, 'addChequeDeduction'])->name('sales.addChequeDeduction');

// bank

        Route::get('/bank-account/bank_account/{building_id}', [BankAccountController::class, 'bankaccount'])->name('bankaccount.bank_account');
        Route::get('/bankaccount.bank_axisbankaccount/{building_id}', [BankAccountController::class, 'axisbank'])->name('bankaccount.axisbankaccount');
        Route::get('/bankaccount/canarabankaccount/{building_id}', [BankAccountController::class, 'canarabank'])->name('bankaccount.canarabankaccount');
        Route::get('/bankaccount/sbiaccount/{building_id}', [BankAccountController::class, 'sbi'])->name('bankaccount.sbiaccount');

        Route::get('/banks/create', [BankController::class, 'create'])->name('banks.create');

        Route::post('/banks/store', [BankController::class, 'store'])->name('banks.store');

        Route::get('/banks/views', [BankController::class, 'views'])->name('banks.views');

        // Define a route for editing a specific bank
        Route::get('/banks/edit/{id}', [BankController::class, 'edit'])->name('banks.edit');

        Route::delete('/banks/{bank}', [BankController::class, 'destroy'])->name('banks.destroy');

        Route::put('/banks/{id}', [BankController::class, 'update'])->name('banks.update');


        });
});