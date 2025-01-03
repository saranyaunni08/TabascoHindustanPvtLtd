@extends('layouts.default', ['title' => 'Sell Room'])
<script>
   .form-container {
    position: relative;
    z-index: 10; /* Ensure the form is above the sidebar */
}

.sidebar {
    position: relative;
    z-index: 1; /* Sidebar has a lower stacking order */
}

</script>
@section('content')
<div class="container">
    <div class="container">
    <div class="container">
    <div class="container">
    <div class="container">
    <div class="container-fluid py-4">
        <h2>Sell Room</h2>
    <form action="{{ route('admin.sales.store') }}" method="POST">
        @csrf

        <input type="hidden" name="room_id" value="{{ $room->id }}">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

            <!-- Your existing form elements -->

    <div class="form-container">

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Customer Details</h5>
            </div>
            <div class="card-body">
                <!-- Customer Name and Email -->
                <div class="form-row mb-3">
                    <div class="col-md-6">
                        <label class="font-weight-bold" for="customer_name">Customer Name</label>
                        <input type="text" id="customer_name" name="customer_name" required class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold" for="customer_email">Customer Email</label>
                        <input type="email" id="customer_email" name="customer_email" required class="form-control">
                    </div>
                </div>
                <!-- Customer Contact -->
                <div class="form-row">
                    <div class="col-md-4">
                        <label class="font-weight-bold" for="customer_contact">Customer Contact</label>
                        <input type="text" class="form-control" id="customer_contact" name="customer_contact" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Sale Details</h5>
            </div>
            <div class="card-body">
                <!-- Sale Amount and Area Calculation Type -->
                <div class="form-row mb-3">
                    <div class="col-md-4">
                        <label class="font-weight-bold" for="sale_amount">Sale Amount (in sq ft)</label>
                        <input type="number" class="form-control" id="sale_amount" name="sale_amount" required>
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold" for="area_calculation_type">Area Calculation Type</label>
                        <select class="form-control" id="area_calculation_type" name="area_calculation_type" required>
                            <option value="" disabled selected>Select Area Type</option>
                            <option value="super_build_up_area">Super Build-Up Area</option>
                            <option value="carpet_area">Carpet Area</option>
                        </select>
                    </div>
                </div>

                <!-- Read-only Fields for Super Build-Up and Carpet Area -->
                @if($room->room_type == 'Flat')
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h6>Flat Area Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold" for="build_up_area">Super Build-Up Area (sq ft)</label>
                                <input type="text" class="form-control" id="build_up_area" name="build_up_area" value="{{ $room->flat_build_up_area }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold" for="carpet_area">Carpet Area (sq ft)</label>
                                <input type="text" class="form-control" id="carpet_area" name="carpet_area" value="{{ $room->flat_carpet_area }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($room->room_type == 'Shops')
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h6>Shop Area Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold" for="build_up_area">Super Build-Up Area (sq ft)</label>
                                <input type="text" class="form-control" id="build_up_area" name="build_up_area" value="{{ $room->build_up_area }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold" for="carpet_area">Carpet Area (sq ft)</label>
                                <input type="text" class="form-control" id="carpet_area" name="carpet_area" value="{{ $room->carpet_area }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($room->room_type == 'Table space')
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h6>Table Space Area Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold" for="build_up_area">Super Build-Up Area (sq ft)</label>
                                <input type="text" class="form-control" id="build_up_area" name="build_up_area" value="{{ $room->space_area }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($room->room_type == 'Chair space')
                <div class="card mt-3">
                    <div class="card-header bg-secondary text-white">
                        <h6>Chair Space Area Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="font-weight-bold" for="build_up_area">Super Build-Up Area (sq ft)</label>
                                <input type="text" class="form-control" id="build_up_area" name="build_up_area" value="{{ $room->chair_space_in_sq }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5>Land Entry Fields</h5>
            </div>
            <div class="card-body">
                <!-- Container for Dynamically Added Land Fields -->
                <div id="landFieldsContainer">
                    <!-- Dynamically added land fields will appear here -->
                </div>

                <!-- Add Land Button -->
                <div class="form-group mt-3">
                    <button type="button" id="addLandButton" class="btn btn-primary">
                        + Add Land
                    </button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5>Total Amount</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold" for="total_amount">Calculated Total Amount</label>
                    <input type="text" class="form-control bg-light text-dark font-weight-bold" id="total_amount" name="total_amount" readonly>
                </div>
            </div>
        </div>

        
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5>Discount Details</h5>
            </div>
            <div class="card-body">
                <!-- Discount Percentage -->
                <div class="form-group">
                    <label class="font-weight-bold" for="discount_percentage">Discount Percentage (%)</label>
                    <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" min="0" max="100" step="0.01">
                </div>

                <!-- Discount Amount -->
                <div class="form-group">
                    <label class="font-weight-bold" for="discount_amount">Discount Amount</label>
                    <input type="text" class="form-control bg-light" id="discount_amount" name="discount_amount">
                </div>

                <!-- Final Amount (After Discount) -->
                <div class="form-group">
                    <label class="font-weight-bold" for="final_amount">Final Amount (After Discount)</label>
                    <input type="text" class="form-control bg-light text-dark font-weight-bold" id="final_amount" name="final_amount" readonly>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5>Parking Slot Details</h5>
            </div>
            <div class="card-body">
                <!-- Select Parking Floor -->
                <div class="form-group">
                    <label class="font-weight-bold" for="parkingFloor">Select Parking Floor</label>
                    <select class="form-control" id="parkingFloor" name="parking_floor">
                        <option value="" disabled selected>-- Select a Floor --</option>
                        @foreach($availableFloors as $floor)
                            <option value="{{ $floor }}">{{ $floor }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Select Parking Slot -->
                <div class="form-group">
                    <label class="font-weight-bold" for="parkingSlot">Select Parking Slot</label>
                    <select class="form-control" id="parkingSlot" name="parking_id">
                        <option value="" disabled selected>-- Select a Parking Slot --</option>
                        {{-- Options populated dynamically --}}
                    </select>
                </div>
            </div>
        </div>

                {{-- end parking slot section --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5>Cash Value Details</h5>
                    </div>
                    <div class="card-body">
                        <!-- Cash Value Percentage -->
                        <div class="form-group">
                            <label class="font-weight-bold" for="cash_value_percentage">Cash Value Percentage (%)</label>
                            <input type="number" class="form-control" id="cash_value_percentage" name="cash_value_percentage" min="0" max="100" step="0.01" placeholder="Enter percentage">
                        </div>
                
                        <!-- Cash Value Amount -->
                        <div class="form-group">
                            <label class="font-weight-bold" for="cash_value_amount">Cash Value Amount</label>
                            <input type="text" class="form-control" id="cash_value_amount" name="cash_value_amount" placeholder="Calculated automatically">
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5>Parking Add to Cash Value</h5>
                    </div>
                    <div class="card-body">
                        <!-- Checkbox to Add Parking Amount to Cash Value -->
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="addParkingAmountCashCheckbox" name="add_parking_amount_cash">
                                <label class="form-check-label" for="addParkingAmountCashCheckbox">Add Parking Amount to Cash Value</label>
                            </div>
                        </div>
                
                        <!-- Parking Amount Input -->
                        <div class="form-group" id="parkingAmountCashGroup" style="display: none;">
                            <label class="font-weight-bold" for="parkingAmountCash">Enter Parking Amount (Cash)</label>
                            <input type="number" class="form-control" id="parkingAmountCash" name="parking_amount_cash" placeholder="Enter parking amount for cash">
                            <small id="parkingAmountCashError" class="text-danger" style="display: none;">Please enter a valid parking amount.</small>
                        </div>
                    </div>
                </div>
                

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5>Additional Amounts</h5>
                    </div>
                    <div class="card-body">
                        <!-- Additional Amounts Fields -->
                        <div class="form-group">
                            <label for="additionalAmounts">Add Extra Amounts</label>
                            <div id="additional-amounts-container">
                                <!-- Dynamically added additional amount fields will appear here -->
                            </div>
                            <button type="button" id="add-more" class="btn btn-success mt-2">+ Add More</button>
                        </div>
                
                        <!-- Total Cash Value Section -->
                        <div class="form-group">
                            <label for="total_cash_value">Total Cash Value (with Additional Amounts)</label>
                            <input type="text" class="form-control" id="total_cash_value" name="total_cash_value" readonly>
                        </div>
                    </div>
                </div>
                
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5>Total Received Amount</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="total_received_amount" class="font-weight-bold">Total Received Amount</label>
                            <input type="number" class="form-control" id="total_received_amount" name="total_received_amount" oninput="updatePartnerFields()" placeholder="Enter total received amount">
                        </div>
                    </div>
                </div>
                
                
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5>Select Partners</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="partner_distribution" class="font-weight-bold">Select Partners</label>
                            <!-- Partner selection checkboxes -->
                            @foreach($partners as $partner)
                            <div class="form-check">
                                <input class="form-check-input partner-checkbox" type="checkbox" value="{{ $partner->id }}" id="partner_{{ $partner->id }}" onchange="togglePartnerFields({{ $partner->id }})">
                                <label class="form-check-label" for="partner_{{ $partner->id }}">
                                    {{ $partner->first_name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                
                        <!-- Error message for partner distribution -->
                        @if ($errors->has('partner_distribution'))
                        <div class="alert alert-danger">
                            {{ $errors->first('partner_distribution') }}
                        </div>
                        @endif
                        
                        <!-- Container for partner distribution fields -->
                        <div id="partner_distribution_container"></div>
                
                        <!-- Hidden fields for partner distribution -->
                        <input type="hidden" name="partner_distribution" id="partner_distribution" value="">
                        <input type="hidden" name="partner_percentages" id="partner_percentages" value="">
                        <input type="hidden" name="partner_amounts" id="partner_amounts" value="">
                
                        <!-- Error message for total percentage -->
                        <div id="total_percentage_error" style="color:red;"></div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5>Other Expenses</h5>
                    </div>
                    <div class="card-body">
                        <div id="additional-expenses-container">
                            <!-- Expense Row Template -->
                            <div class="row mb-2" id="additional-expense-0">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="expense_descriptions[]" placeholder="Description" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" class="form-control percentage-input" name="expense_percentages[]" placeholder="Percentage" step="0.01" oninput="calculateExpenseAmount(this); updateTotalPercentage()" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control amount-display" name="expense_amounts[]" placeholder="Amount" oninput="calculatePercentage(this);" required />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Add More Button -->
                        <button type="button" class="btn btn-success mt-2" id="add-more-expenses">+ Add Expenses</button>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5>Remaining Cash Value</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="remaining_cash_value">Remaining Cash Value</label>
                            <input type="text" class="form-control" id="remaining_cash_value" name="remaining_cash_value" readonly>
                        </div>
                    </div>
                </div>
        <!-- Cash Installment Value -->
        <!-- Cash Installment Related Fields (Initially Hidden) -->
        <div class="form-group">
            <label for="cash_installment_value">Cash Installment Value</label>
            <input type="number" class="form-control" id="cash_installment_value" name="cash_installment_value" min="0" step="0.01" oninput="toggleCashInstallmentFields()">
        </div>
        
        <div id="cash-installment-container" style="display: none; margin-top: 20px;">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Cash Installment Details</h5>
                </div>
                <div class="card-body">
                    <!-- Cash Loan Type -->
                    <div class="form-group">
                        <label for="cash_loan_type">Select Cash Loan Type:</label>
                        <select id="cash_loan_type" name="cash_loan_type" class="form-control">
                            <option value="">Select...</option>
                            <option value="no_loan">No Loan</option>
                            <option value="bank">Bank</option>
                            <option value="directors">Director's</option>
                            <option value="others">Others</option>
                        </select>
                    </div>

                    <!-- Other Loan Description for Cash (Hidden initially) -->
                    <div id="other-loan-description-container-cash" style="display: none;">
                        <label for="other_loan_description_cash">Please specify:</label>
                        <input type="text" id="other_loan_description_cash" name="other_loan_description_cash" class="form-control" placeholder="Describe Other Loan Type">
                    </div>

                    <!-- Cash Installment Frequency -->
                    <div class="form-group">
                        <label for="cash_installment_frequency">Installment Frequency:</label>
                        <select id="cash_installment_frequency" name="cash_installment_frequency" class="form-control">
                            <option value="">Select Frequency...</option>
                            <option value="monthly">Every Month</option>
                            <option value="3months">Every 3 Months</option>
                            <option value="6months">Every 6 Months</option>
                        </select>
                    </div>

                    <!-- Cash Installment Start Date -->
                    <div class="form-group">
                        <label for="cash_installment_start_date">Installment Start Date:</label>
                        <input type="date" id="cash_installment_start_date" name="cash_installment_start_date" class="form-control">
                    </div>

                    <!-- Number of Cash Installments -->
                    <div class="form-group">
                        <label for="cash_no_of_installments">Number of Installments:</label>
                        <input type="number" id="cash_no_of_installments" name="cash_no_of_installments" class="form-control" min="1" oninput="calculateCashInstallmentAmount()">
                    </div>

                    <!-- Cash Installment Amount (Auto-calculated) -->
                    <div class="form-group">
                        <label for="cash_installment_amount">Cash Installment Amount (auto-calculated):</label>
                        <input type="number" id="cash_installment_amount" name="cash_installment_amount" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>

                            <!-- Loan Type and Installment Container for Cash Handling -->
                        {{-- <div id="loan-type-container-cash" style="display: none;">
                            <label for="loan_type_cash">Select Loan Type:</label>
                            <select id="loan_type_cash" class="form-control" onchange="handleLoanTypeChangeCash()">
                                <option value="">Select...</option>
                                <option value="no_loan">No Loan</option> <!-- Add this option -->
                                <option value="bank">Bank</option>
                                <option value="directors">Director's</option>
                                <option value="others">Others</option>
                            </select>
                        </div>


            <div id="other-loan-description-container-cash" style="display: none;">
                <label for="other_loan_description_cash">Please specify:</label>
                <input type="text" id="other_loan_description_cash" class="form-control" placeholder="Describe Other Loan Type">
            </div>

            <div id="installment-container-cash" style="display: none;">
                <label for="installment_frequency_cash">Installment Frequency:</label>
                <select id="installment_frequency_cash" class="form-control">
                    <option value="">Select Frequency...</option>
                    <option value="monthly">Every Month</option>
                    <option value="3months">Every 3 Months</option>
                    <option value="6months">Every 6 Months</option>
                </select>

                <label for="installment_date_cash">Installment Start Date:</label>
                <input type="date" id="installment_date_cash" class="form-control">

                <label for="no_of_installments_cash">Number of Installments:</label>
                <input type="number" id="no_of_installments_cash" class="form-control" placeholder="Enter No. of Installments" oninput="calculateInstallmentAmountCash()">

                <label for="installment_amount_cash">Installment Amount (auto-calculated):</label>
                <input type="number" id="installment_amount_cash" class="form-control" readonly>
            </div> --}}

        <!-- Total Cheque Value Section -->
        <div class="form-group">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Total Cheque Value</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="total_cheque_value" class="form-label">Total Cheque Value:</label>
                            <input type="text" id="total_cheque_value" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <!-- Optional: Display the cheque value icon (for visual cue) -->
                            <div class="d-flex justify-content-center align-items-center">
                                <i class="fas fa-check-circle fa-3x text-success"></i>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="total_cheque_value" id="total_cheque_value_hidden">
                </div>
            </div>
        </div>

                
        <!-- Parking Add to Cheque Value Section -->
        <div class="form-group">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5>Add Parking Amount to Cheque Value</h5>
                </div>
                <div class="card-body">
                    <!-- Checkbox to Add Parking Amount -->
                    <div class="form-check">
                        <input type="checkbox" id="addParkingAmountCheckbox" name="add_parking_amount" class="form-check-input" onchange="toggleParkingAmountField()">
                        <label class="form-check-label" for="addParkingAmountCheckbox">Add Parking Amount to Cheque Value</label>
                    </div>

                    <!-- Input field for Parking Amount (Initially hidden) -->
                    <div class="form-group" id="parkingAmountGroup" style="display: none;">
                        <label for="parkingAmount" class="form-label">Enter Parking Amount</label>
                        <input type="number" class="form-control" id="parkingAmount" name="parking_amount_cheque" placeholder="Enter parking amount">
                        <small id="parkingAmountError" class="text-danger" style="display: none;">Please enter a valid parking amount.</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Expenses Section -->
        <div id="additional-expenses-container">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5>Other Expenses</h5>
                </div>
                <div class="card-body">
                    <!-- Expense Fields Container -->
                    <div id="expense-container">
                        <div class="row mb-2" id="expense-row-0">
                            <div class="col-md-6">
                                <input type="text" placeholder="Expense Description" class="form-control cheque-expense-description" name="cheque_expense_descriptions[]" />
                            </div>
                            <div class="col-md-6">
                                <input type="number" placeholder="Expense Amount" class="form-control cheque-expense-amount" name="cheque_expense_amounts[]" oninput="calculateTotalChequeValueWithAdditional()" />
                            </div>
                        </div>
                    </div>

                    <!-- Button to Add More Expense Fields -->
                    <button id="add-expense" class="btn btn-success mt-2" onclick="addExpenseField()">Add Expense</button>
                </div>
            </div>
        </div>

        <!-- Total Cheque Value with Additional Expenses -->
        <div class="form-group">
            <div class="card mb-4">
                <div class="card-header bg-warning text-white">
                    <h5>Total Cheque Value with Additional Expenses</h5>
                </div>
                <div class="card-body">
                    <input type="text" id="total_cheque_value_with_additional" class="form-control" readonly>
                    <input type="hidden" name="total_cheque_value_with_additional" id="total_cheque_value_with_additional_hidden">
                </div>
            </div>
        </div>


            <!-- GST Section with Improved Layout -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5>GST Details</h5>
            </div>
            <div class="card-body">
                <!-- GST Percentage and GST Amount in One Row -->
                <div class="row mb-3">
                    <!-- GST Percentage -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gst_percentage">GST Percentage</label>
                            <input type="number" id="gst_percentage" name="gst_percentage" placeholder="GST Percentage" class="form-control" oninput="calculateTotalChequeValueWithAdditional()" />
                        </div>
                    </div>

                    <!-- GST Amount -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="gst_amount">GST Amount</label>
                            <input type="text" id="gst_amount" name="gst_amount" placeholder="GST Amount" class="form-control" readonly />
                        </div>
                    </div>
                </div>

                <!-- Total Cheque Value with GST -->
                <div class="form-group">
                    <label for="total_cheque_value_with_gst">Total Cheque Value (with GST)</label>
                    <input type="text" id="total_cheque_value_with_gst" name="total_cheque_value_with_gst" placeholder="Total Cheque Value + GST" class="form-control" readonly />
                </div>
            </div>
        </div>

                <!-- Received Amount and Cheque Description Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Payment Details</h5>
            </div>
            <div class="card-body">
                <!-- Received Amount Field -->
                <div class="form-group">
                    <label for="received_cheque_value">Received Amount</label>
                    <input type="number" id="received_cheque_value" name="received_cheque_value" class="form-control" placeholder="Enter the received amount" oninput="calculateBalance()" />
                </div>

                <!-- Conditional Description Container -->
                <div id="description-container" style="display: none;">
                    <div class="form-group">
                        <label for="cheque_description">Cheque Description</label>
                        <textarea id="cheque_description" name="cheque_description" class="form-control" placeholder="Describe where the money goes..."></textarea>
                    </div>
                </div>
            </div>
        </div>


      <!-- Balance Amount Section -->
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h5>Balance Details</h5>
    </div>
    <div class="card-body">
        <!-- Balance Amount Field -->
        <div class="form-group">
            <label for="balance_amount">Balance Amount</label>
            <input type="text" id="balance_amount" name="balance_amount" class="form-control" placeholder="Balance Amount" readonly />
        </div>

        <!-- Loan Type Selection (Initially Hidden) -->
        <div id="loan-type-container" style="display: none;">
            <label for="loan_type">Select Loan Type</label>
            <select id="loan_type" name="loan_type" class="form-control" onchange="handleLoanTypeChange()">
                <option value="">Select...</option>
                <option value="no_loan">No Loan</option>
                <option value="bank">Bank</option>
                <option value="directors">Director's</option>
                <option value="others">Others</option>
            </select>
        </div>

        <!-- Description for 'Others' Loan Type (Initially Hidden) -->
        <div id="other-loan-description-container" style="display: none;">
            <label for="other_loan_description">Please specify:</label>
            <input type="text" id="other_loan_description" name="other_loan_description" class="form-control" placeholder="Describe Other Loan Type">
        </div>

        <!-- Installment Details (Initially Hidden) -->
        <div id="installment-container" style="display: none;">
            <h6>Installment Details</h6>
            
            <div class="form-group">
                <label for="installment_frequency">Installment Frequency</label>
                <select id="installment_frequency" name="installment_frequency" class="form-control">
                    <option value="">Select Frequency...</option>
                    <option value="monthly">Every Month</option>
                    <option value="3months">Every 3 Months</option>
                    <option value="6months">Every 6 Months</option>
                </select>
            </div>

            <div class="form-group">
                <label for="installment_date">Installment Start Date</label>
                <input type="date" id="installment_date" name="installment_date" class="form-control">
            </div>

            <div class="form-group">
                <label for="no_of_installments">Number of Installments</label>
                <input type="number" id="no_of_installments" name="no_of_installments" class="form-control" placeholder="Enter No. of Installments" oninput="calculateInstallmentAmount()">
            </div>

            <div class="form-group">
                <label for="installment_amount">Installment Amount (auto-calculated)</label>
                <input type="number" id="installment_amount" name="installment_amount" class="form-control" readonly>
            </div>
        </div>

        <!-- Grand Total Amount (auto-calculated) -->
    </div>
</div>

<!-- Grand Total Amount Section (Enhanced Design) -->
<div id="grand-total-container" class="card mb-4 shadow-lg">
    <div class="card-header bg-success text-white">
        <h5><i class="fas fa-calculator"></i> Grand Total Amount</h5>
    </div>
    <div class="card-body">
        <p class="text-center">Total amount after all calculations and adjustments.</p>
        <div class="form-group">
            <label for="grand_total_amount" class="font-weight-bold">Grand Total Amount (auto-calculated)</label>
            <input type="number" id="grand_total_amount" name="grand_total_amount" class="form-control form-control-lg text-center" readonly>
        </div>
    </div>
</div>


                <br><br>
        <div class="card mb-4">
            <div class="card-body text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    Submit Sale
                </button>
            </div>
        </div>

            </form>
</div>
</div>
</div>
</div>
</div>
   

<script>
    document.getElementById('sale_amount').addEventListener('input', calculateTotalAmount);
    document.getElementById('area_calculation_type').addEventListener('change', calculateTotalAmount);
    document.getElementById('discount_percentage').addEventListener('input', calculateDiscountFromPercentage);
    document.getElementById('discount_amount').addEventListener('input', calculateDiscountFromAmount);
    document.getElementById('cash_value_percentage').addEventListener('input', calculateCashFromPercentage);
    document.getElementById('cash_value_amount').addEventListener('input', calculateCashFromAmount);

    function calculateTotalAmount() {
        let saleAmount = parseFloat(document.getElementById('sale_amount').value);
        let areaType = document.getElementById('area_calculation_type').value;
        let totalAmount = 0;

        if (saleAmount && areaType) {
            if (areaType === 'super_build_up_area') {
                totalAmount = saleAmount * parseFloat(document.getElementById('build_up_area')?.value || 0);
            } else if (areaType === 'carpet_area') {
                totalAmount = saleAmount * parseFloat(document.getElementById('carpet_area')?.value || 0);
            }
        }

        document.getElementById('total_amount').value = totalAmount.toFixed(2);
        calculateDiscountFromPercentage();
    }

    function calculateDiscountFromPercentage() {
        let totalAmount = parseFloat(document.getElementById('total_amount').value);
        let discountPercentage = parseFloat(document.getElementById('discount_percentage').value);
        let discountAmount = 0;

        if (totalAmount && discountPercentage) {
            discountAmount = totalAmount * (discountPercentage / 100);
            document.getElementById('discount_amount').value = discountAmount.toFixed(2);
        }

        calculateFinalAmount();
    }

    function calculateDiscountFromAmount() {
        let totalAmount = parseFloat(document.getElementById('total_amount').value);
        let discountAmount = parseFloat(document.getElementById('discount_amount').value);
        let discountPercentage = 0;

        if (totalAmount && discountAmount) {
            discountPercentage = (discountAmount / totalAmount) * 100;
            document.getElementById('discount_percentage').value = discountPercentage.toFixed(2);
        }

        calculateFinalAmount();
    }

    function calculateFinalAmount() {
        let totalAmount = parseFloat(document.getElementById('total_amount').value);
        let discountAmount = parseFloat(document.getElementById('discount_amount').value);
        let finalAmount = totalAmount - (discountAmount || 0);

        document.getElementById('final_amount').value = finalAmount.toFixed(2);
        calculateCashFromPercentage();
    }
    function calculateCashFromPercentage() {
        let finalAmount = parseFloat(document.getElementById('final_amount').value);
        let cashPercentage = parseFloat(document.getElementById('cash_value_percentage').value);
        let cashAmount = 0;

        if (finalAmount && cashPercentage) {
            cashAmount = finalAmount * (cashPercentage / 100);
            document.getElementById('cash_value_amount').value = cashAmount.toFixed(2);
        }
    }

    function calculateCashFromAmount() {
        let finalAmount = parseFloat(document.getElementById('final_amount').value);
        let cashAmount = parseFloat(document.getElementById('cash_value_amount').value);
        let cashPercentage = 0;

        if (finalAmount && cashAmount) {
            cashPercentage = (cashAmount / finalAmount) * 100;
            document.getElementById('cash_value_percentage').value = cashPercentage.toFixed(2);
        }
    }
</script>
<script>
    let additionalAmountIndex = 0;

    document.getElementById('cash_value_percentage').addEventListener('input', calculateCashFromPercentage);
    document.getElementById('cash_value_amount').addEventListener('input', calculateCashFromAmount);
    document.getElementById('add-more').addEventListener('click', addAdditionalAmountField);

    function calculateCashFromPercentage() {
        let finalAmount = parseFloat(document.getElementById('final_amount').value);
        let cashPercentage = parseFloat(document.getElementById('cash_value_percentage').value);
        let cashAmount = 0;

        if (finalAmount && cashPercentage) {
            cashAmount = finalAmount * (cashPercentage / 100);
            document.getElementById('cash_value_amount').value = cashAmount.toFixed(2);
        }
        updateTotalCashValue();
    }

    function calculateCashFromAmount() {
        let finalAmount = parseFloat(document.getElementById('final_amount').value);
        let cashAmount = parseFloat(document.getElementById('cash_value_amount').value);
        let cashPercentage = 0;

        if (finalAmount && cashAmount) {
            cashPercentage = (cashAmount / finalAmount) * 100;
            document.getElementById('cash_value_percentage').value = cashPercentage.toFixed(2);
        }
        updateTotalCashValue();
    }

    function addAdditionalAmountField() {
        additionalAmountIndex++;

        const container = document.getElementById('additional-amounts-container');
        const newField = `
            <div class="row mb-2" id="additional-amount-${additionalAmountIndex}">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="additional_descriptions[]" placeholder="Description">
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control additional-amount" name="additional_amounts[]" placeholder="Amount" step="0.01" oninput="updateTotalCashValue()">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger" onclick="removeAdditionalAmountField(${additionalAmountIndex})">Remove</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newField);
    }

    function removeAdditionalAmountField(index) {
        const element = document.getElementById(`additional-amount-${index}`);
        if (element) element.remove();
        updateTotalCashValue();
    }
</script>
<script>
  // Add event listeners to trigger updates
document.getElementById('cash_value_amount').addEventListener('input', updateTotalCashValue);
document.querySelectorAll('.additional-amount').forEach(field => field.addEventListener('input', updateTotalCashValue));
document.getElementById('received_amount').addEventListener('input', updateRemainingCashValue);

// Function to calculate the installment amount
function calculateInstallmentAmountCash() {
    const noOfInstallmentsCash = parseInt(document.getElementById('no_of_installments_cash').value) || 1;

    // Calculate installment amount
    const installmentAmountCash = (remainingCashValue / noOfInstallmentsCash).toFixed(2);

    // Update the Installment Amount field
    document.getElementById('installment_amount_cash').value = installmentAmountCash;
}

// Event listeners to trigger functions on input changes
document.getElementById('received_amount').addEventListener('input', updateRemainingCashValue);
document.getElementById('loan_type_cash').addEventListener('change', handleLoanTypeChangeCash);
document.getElementById('no_of_installments_cash').addEventListener('input', calculateInstallmentAmountCash);

</script>
<script>
   // Function to show or hide partner fields based on checkbox selection
   function togglePartnerFields(partnerId) {
    let container = document.getElementById('partner_distribution_container');
    let checkbox = document.getElementById('partner_' + partnerId);
    
    if (checkbox.checked) {
        let partnerDiv = document.createElement('div');
        partnerDiv.className = 'partner-field';
        partnerDiv.id = 'partner_field_' + partnerId;
        partnerDiv.innerHTML = `
            <h5>Partner: ${document.querySelector('label[for="partner_' + partnerId + '"]').textContent}</h5>
            <div class="form-group">
                <label for="partner_${partnerId}_percentage">Percentage</label>
                <input type="number" class="form-control partner-percentage" data-partner-id="${partnerId}" id="partner_${partnerId}_percentage" min="0" max="100" oninput="updatePartnerAmount(${partnerId}); validateTotalPercentage(); updateHiddenFields();">
            </div>
            <div class="form-group">
                <label for="partner_${partnerId}_amount">Amount</label>
                <input type="number" class="form-control partner-amount" data-partner-id="${partnerId}" id="partner_${partnerId}_amount" oninput="updatePartnerPercentage(${partnerId}); validateTotalPercentage(); updateHiddenFields();">
            </div>
        `;
        container.appendChild(partnerDiv);
    } else {
        let partnerDiv = document.getElementById('partner_field_' + partnerId);
        if (partnerDiv) {
            container.removeChild(partnerDiv);
        }
    }
    updateHiddenFields();  // Ensure hidden fields are updated when toggling partners
}
function updateHiddenFields() {
    let partnerDistribution = [];
    let partnerPercentages = [];
    let partnerAmounts = [];

    document.querySelectorAll('.partner-checkbox:checked').forEach(function(checkbox) {
        let partnerId = checkbox.value;
        let percentageField = document.getElementById('partner_' + partnerId + '_percentage');
        let amountField = document.getElementById('partner_' + partnerId + '_amount');

        if (percentageField && amountField) {
            partnerDistribution.push(partnerId);
            partnerPercentages.push(percentageField.value);
            partnerAmounts.push(amountField.value);
        }
    });

    document.getElementById('partner_distribution').value = JSON.stringify(partnerDistribution);
    document.getElementById('partner_percentages').value = JSON.stringify(partnerPercentages);
    document.getElementById('partner_amounts').value = JSON.stringify(partnerAmounts);
}


document.querySelector('form').addEventListener('submit', function(event) {
    const partnerIds = Array.from(document.querySelectorAll('.partner-checkbox:checked')).map(checkbox => checkbox.value);
    const percentages = Array.from(document.querySelectorAll('.partner-percentage')).map(input => input.value);
    const amounts = Array.from(document.querySelectorAll('.partner-amount')).map(input => input.value);

    document.getElementById('partner_distribution').value = JSON.stringify(partnerIds);
    document.getElementById('partner_percentages').value = JSON.stringify(percentages);
    document.getElementById('partner_amounts').value = JSON.stringify(amounts);
    
    // Log the values being set
    console.log("Partner Distribution:", document.getElementById('partner_distribution').value);
    console.log("Partner Percentages:", document.getElementById('partner_percentages').value);
    console.log("Partner Amounts:", document.getElementById('partner_amounts').value);
});

// Function to update partner amount based on percentage entered
function updatePartnerAmount(partnerId) {
    let totalReceivedAmount = parseFloat(document.getElementById('total_received_amount').value) || 0;
    let percentageField = document.getElementById(`partner_${partnerId}_percentage`);
    let amountField = document.getElementById(`partner_${partnerId}_amount`);
    let percentage = parseFloat(percentageField.value) || 0;

    // Calculate amount based on percentage
    let amount = (percentage / 100) * totalReceivedAmount;
    amountField.value = amount.toFixed(2);
}

// Function to update partner percentage based on amount entered
function updatePartnerPercentage(partnerId) {
    let totalReceivedAmount = parseFloat(document.getElementById('total_received_amount').value) || 0;
    let amountField = document.getElementById(`partner_${partnerId}_amount`);
    let percentageField = document.getElementById(`partner_${partnerId}_percentage`);
    let amount = parseFloat(amountField.value) || 0;

    // Calculate percentage based on amount
    let percentage = (amount / totalReceivedAmount) * 100;
    percentageField.value = percentage.toFixed(2);
}


// Function to validate that the total percentage does not exceed 100%
// Function to validate that the total percentage does not exceed 100%
function validateTotalPercentage() {
    let totalPercentage = 0;
    let percentageFields = document.querySelectorAll('.partner-percentage');
    
    percentageFields.forEach(function(field) {
        totalPercentage += parseFloat(field.value) || 0;
    });
    
    let othersPercentage = parseFloat(document.getElementById('others_percentage').value) || 0;
    totalPercentage += othersPercentage;

    // Display a warning if the total exceeds 100%
    if (totalPercentage > 100) {
        document.getElementById('percentage_error').textContent = "Total percentage cannot exceed 100%";
        document.getElementById('submit_button').disabled = true;
    } else {
        document.getElementById('percentage_error').textContent = "";
        document.getElementById('submit_button').disabled = false;
    }
}
// Attach event listeners to other percentage fields if needed
document.getElementById('others_percentage').addEventListener('input', validateTotalPercentage);


// Disable the submit button if the validation fails
function disableSubmitButton() {
    document.getElementById('submit_button').disabled = true;
}

// Enable the submit button if the validation passes
function enableSubmitButton() {
    document.getElementById('submit_button').disabled = false;
}

// Function to update others amount based on percentage entered
function updateOthersAmount() {
    let totalReceivedAmount = parseFloat(document.getElementById('total_received_amount').value) || 0;
    let othersPercentage = parseFloat(document.getElementById('others_percentage').value) || 0;

    let othersAmount = (othersPercentage / 100) * totalReceivedAmount;
    document.getElementById('others_amount').value = othersAmount.toFixed(2);

    validateTotalPercentage(); // Revalidate after updating "Others" amount
}
</script>
<script>
let expenseCount = 1; // Initialize counter for additional expenses

// Function to calculate total percentage and update error message
function updateTotalPercentage() {
    const partnerCheckboxes = document.querySelectorAll('.partner-checkbox:checked');
    let totalPartnerPercentage = 0;

    // Sum selected partner percentages
    partnerCheckboxes.forEach(checkbox => {
        const partnerId = checkbox.value;
        const percentageInput = document.querySelector(`input[data-partner-id="${partnerId}"]`);
        if (percentageInput) {
            totalPartnerPercentage += parseFloat(percentageInput.value) || 0;
        }
    });

    // Sum "Other Expenses" percentages
    const expensePercentages = document.querySelectorAll('input[name="expense_percentages[]"]');
    expensePercentages.forEach(input => {
        totalPartnerPercentage += parseFloat(input.value) || 0;
    });

    // Check for total exceeding 100%
    const errorDiv = document.getElementById('total_percentage_error');
    if (totalPartnerPercentage > 100) {
        errorDiv.innerText = 'Total percentage exceeds 100%. Please adjust the values.';
    } else {
        errorDiv.innerText = ''; // Clear the error message
    }
}

// Function to calculate the expense amount based on the percentage input
function calculateExpenseAmount(inputElement) {
    const percentage = parseFloat(inputElement.value) || 0; // Get the percentage
    const totalReceivedAmount = parseFloat(document.getElementById('total_received_amount').value) || 0; // Get total received amount
    const amountDisplay = inputElement.closest('.row').querySelector('.amount-display'); // Get the corresponding amount display input

    // Calculate the expense amount based on the percentage of the total received amount
    const amount = (totalReceivedAmount * (percentage / 100)).toFixed(2);
    amountDisplay.value = amount; // Update the amount display field

    // Update total percentage on change
    updateTotalPercentage();
}

// Function to calculate percentage based on the amount input
function calculatePercentage(input) {
    const amount = parseFloat(input.value) || 0;
    const parentDiv = input.closest('.row');
    const percentageInput = parentDiv.querySelector('.percentage-input');

    // Assuming total_cash_value is a predefined global variable or retrieved from the DOM
    const totalCashValue = parseFloat(document.querySelector('[name="total_cash_value"]').value) || 0;

    // Calculate the percentage based on the amount and total cash value
    if (totalCashValue > 0) {
        const percentage = (amount / totalCashValue) * 100;
        percentageInput.value = percentage.toFixed(2); // Set calculated percentage with two decimal places
    }
}
document.getElementById('add-more-expenses').addEventListener('click', function() {
    const expenseContainer = document.getElementById('additional-expenses-container');
    const expenseCount = expenseContainer.getElementsByClassName('row').length;
    
    const newExpenseEntry = document.createElement('div');
    newExpenseEntry.classList.add('row', 'mb-2'); // Added Bootstrap classes for spacing
    newExpenseEntry.id = `additional-expense-${expenseCount}`; // Assign unique ID if needed
    newExpenseEntry.innerHTML = `
        <div class="col-md-6">
            <input type="text" class="form-control" name="expense_descriptions[]" placeholder="Description">
        </div>
        <div class="col-md-4">
            <input type="number" class="form-control percentage-input" name="expense_percentages[]" placeholder="Percentage" step="0.01" oninput="calculateExpenseAmount(this); updateTotalPercentage()">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control amount-display" placeholder="Amount" oninput="calculatePercentage(this);" />
        </div>
    `;
    expenseContainer.appendChild(newExpenseEntry);
});


// Add event listeners for partner checkboxes to update total percentage
const partnerCheckboxes = document.querySelectorAll('.partner-checkbox');
partnerCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateTotalPercentage);
});

</script>
<script>
    // Function to update the total cash value and remaining cash value
function updateTotalCashValue() {
    const cashValuePercentage = parseFloat(document.getElementById('cash_value_percentage').value) || 0; // Get cash value percentage
    const cashValueAmount = parseFloat(document.getElementById('cash_value_amount').value) || 0; // Get cash value amount
    const additionalAmounts = document.querySelectorAll('#additional-amounts-container input[type="text"]');
    
    // Calculate the total cash value (including additional amounts)
    let totalCashValue = cashValueAmount; // Start with the cash value amount

    // Add all additional amounts
    additionalAmounts.forEach(input => {
        const additionalAmount = parseFloat(input.value) || 0;
        totalCashValue += additionalAmount; // Add to total cash value
    });

    // Update the Total Cash Value field
    document.getElementById('total_cash_value').value = totalCashValue.toFixed(2); // Display total cash value

    // Now calculate the Remaining Cash Value
    const totalReceivedAmount = parseFloat(document.getElementById('total_received_amount').value) || 0; // Get total received amount
    const remainingCashValue = totalCashValue - totalReceivedAmount; // Calculate remaining cash value
    
    // Update the Remaining Cash Value field
    document.getElementById('remaining_cash_value').value = remainingCashValue.toFixed(2); // Display remaining cash value
}

// Add event listeners to update values on input change
document.getElementById('cash_value_percentage').addEventListener('input', updateTotalCashValue);
document.getElementById('cash_value_amount').addEventListener('input', updateTotalCashValue);
document.getElementById('total_received_amount').addEventListener('input', updateTotalCashValue);

// Also update the total cash value when additional amounts change
const additionalAmountInputs = document.querySelectorAll('#additional-amounts-container input[type="text"]');
additionalAmountInputs.forEach(input => {
    input.addEventListener('input', updateTotalCashValue);
});

</script>


<script>
    function updateTotalCashValue() {
    // Get the base cash value
    let baseCashValue = parseFloat(document.getElementById('cash_value_amount').value) || 0;

    // Get the parking amount (cash) if the checkbox is checked
    let parkingAmountCash = 0;
    if (document.getElementById('addParkingAmountCashCheckbox').checked) {
        parkingAmountCash = parseFloat(document.getElementById('parkingAmountCash').value) || 0;
    }

    // Sum up all additional amounts
    let additionalAmounts = document.querySelectorAll('.additional-amount');
    let totalAdditionalAmount = 0;

    additionalAmounts.forEach(amountField => {
        totalAdditionalAmount += parseFloat(amountField.value) || 0;
    });

    // Calculate total cash value (base + parking + additional)
    let totalCashValue = baseCashValue + parkingAmountCash + totalAdditionalAmount;

    // Update the total cash value field
    document.getElementById('total_cash_value').value = totalCashValue.toFixed(2);

    // Calculate the cheque value if applicable
    calculateChequeValue();  // Call the function to update cheque value if needed
}


</script>


<script>
let baseChequeValue = 0; // Declare at a broader scope

function calculateChequeValue() {
    const finalAmount = parseFloat(document.getElementById('final_amount').value) || 0;
    const totalCashValue = parseFloat(document.getElementById('total_cash_value').value) || 0;

    // Calculate the base cheque value
    baseChequeValue = finalAmount - totalCashValue;

    // Update the Total Cheque Value field
    document.getElementById('total_cheque_value').value = baseChequeValue.toFixed(2);

    // Update the hidden input for form submission
    document.getElementById('total_cheque_value_hidden').value = baseChequeValue.toFixed(2);

    // Calculate total cheque value with additional expenses
    calculateTotalChequeValueWithAdditional(); // Call this function here
}
document.getElementById('add-expense').addEventListener('click', function() {
    const expenseContainer = document.getElementById('expense-container');
    const newExpenseEntry = document.createElement('div');
    newExpenseEntry.classList.add('row', 'mb-2');
    newExpenseEntry.innerHTML = `
        <div class="col-md-6">
            <input type="text" placeholder="Expense Description" class="form-control cheque-expense-description" name="cheque_expense_descriptions[]" />
        </div>
        <div class="col-md-6">
            <input type="number" placeholder="Expense Amount" class="form-control cheque-expense-amount" name="cheque_expense_amounts[]" oninput="calculateTotalChequeValueWithAdditional()" />
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-expense">Remove</button>
        </div>
    `;
    expenseContainer.appendChild(newExpenseEntry);

    // Add event listener for the remove button
    newExpenseEntry.querySelector('.remove-expense').addEventListener('click', function() {
        expenseContainer.removeChild(newExpenseEntry);
        calculateTotalChequeValueWithAdditional(); // Recalculate total after removal
    });
});


</script>
<script>

document.getElementById('gst_percentage').addEventListener('input', calculateGST);

function calculateGST() {
        const gstPercentage = parseFloat(document.getElementById('gst_percentage').value) || 0;
        const totalChequeValueWithAdditional = parseFloat(document.getElementById('total_cheque_value_with_additional').value) || 0;

        // Calculate the GST amount
        const gstAmount = (totalChequeValueWithAdditional * gstPercentage) / 100;

        // Update the GST Amount field
        document.getElementById('gst_amount').value = gstAmount.toFixed(2);

        // Calculate and update the Total Cheque Value (with GST)
        const totalChequeValueWithGST = totalChequeValueWithAdditional + gstAmount;
        document.getElementById('total_cheque_value_with_gst').value = totalChequeValueWithGST.toFixed(2);

        calculateGrandTotal();
    }
    function calculateTotalChequeValueWithAdditional() {
    // Get the base cheque value from the relevant field
    const baseChequeValue = parseFloat(document.getElementById('total_cheque_value').value) || 0;

    // Get all expense amounts
    const expenseAmounts = document.querySelectorAll('.cheque-expense-amount');
    let totalExpenses = 0;

    // Sum all expense amounts
    expenseAmounts.forEach(amount => {
        totalExpenses += parseFloat(amount.value) || 0; // Convert to float, default to 0
    });

    // Calculate the total cheque value with additional expenses
    const totalChequeValueWithAdditional = baseChequeValue + totalExpenses;


    // Update the fields for displaying total cheque value with additional expenses
    document.getElementById('total_cheque_value_with_additional').value = totalChequeValueWithAdditional.toFixed(2); // Update visible input
    document.getElementById('total_cheque_value_with_additional_hidden').value = totalChequeValueWithAdditional.toFixed(2); // Update hidden input

    // Optional: Recalculate GST and Grand Total if necessary
    calculateGST(); // Ensure this function exists and correctly calculates GST
    calculateGrandTotal(); // Ensure this function exists and correctly calculates the grand total
}

//     
function handleLoanTypeChange() {
    const loanType = document.getElementById('loan_type').value;
    const otherLoanDescriptionContainer = document.getElementById('other-loan-description-container');
    const installmentContainer = document.getElementById('installment-container');

    // Show or hide the description field based on loan type selection
    if (loanType === 'others') {
        otherLoanDescriptionContainer.style.display = 'block';  // Show description field for "Others"
        installmentContainer.style.display = 'none';            // Hide installment fields for "Others"
    } else if (loanType !== "") {
        otherLoanDescriptionContainer.style.display = 'none';   // Hide description field
        installmentContainer.style.display = 'block';           // Show installment fields for valid loan types
    } else {
        otherLoanDescriptionContainer.style.display = 'none';   // Hide description field if no loan type is selected
        installmentContainer.style.display = 'none';            // Hide installment fields if no loan type is selected
    }
}

function calculateInstallmentAmount() {
    const balanceAmount = parseFloat(document.getElementById('balance_amount').value) || 0;
    const noOfInstallments = parseInt(document.getElementById('no_of_installments').value) || 1;

    // Calculate installment amount
    const installmentAmount = (balanceAmount / noOfInstallments).toFixed(2);

    // Update the Installment Amount field
    document.getElementById('installment_amount').value = installmentAmount;
}
function calculateBalance() {
    const totalChequeValueWithGst = parseFloat(document.getElementById('total_cheque_value_with_gst').value) || 0;
    const receivedChequeValue = parseFloat(document.getElementById('received_cheque_value').value) || 0;

    // Calculate the balance
    const balanceAmount = totalChequeValueWithGst - receivedChequeValue;

    // Update the balance amount field
    document.getElementById('balance_amount').value = balanceAmount.toFixed(2);
    console.log("Balance Amount: ", balanceAmount.toFixed(2)); // Debug

    const loanTypeContainer = document.getElementById('loan-type-container');
    const installmentContainer = document.getElementById('installment-container');

    // Show loan type and installment fields if balance amount is not zero or if received cheque value is entered
    if (balanceAmount !== 0 || receivedChequeValue > 0) {
        loanTypeContainer.style.display = 'block';  // Show loan type selection
        
        // Automatically show installment fields if received amount is present, regardless of loan type selection
        installmentContainer.style.display = 'block';  // Show installment fields
    } else {
        loanTypeContainer.style.display = 'none';    // Hide loan type selection
        installmentContainer.style.display = 'none'; // Hide installment fields if balance is 0
        document.getElementById('other-loan-description-container').style.display = 'none'; // Hide description field if balance is 0
    }
}


function calculateGrandTotal() {
    // Get values from the fields, ensuring they're treated as numbers
    const totalChequeValueWithAdditional = parseFloat(document.getElementById('total_cheque_value_with_additional').value) || 0;
    const totalChequeValueWithGst = parseFloat(document.getElementById('total_cheque_value_with_gst').value) || 0;

    // Calculate the grand total amount
    const grandTotalAmount = totalChequeValueWithAdditional + totalChequeValueWithGst;

    console.log("Total Cheque Value with Additional Amounts:", totalChequeValueWithAdditional);
    console.log("Total Cheque Value with GST:", totalChequeValueWithGst);
    console.log("Grand Total Amount:", grandTotalAmount);
    console.log("cheque amount:", baseChequeValue);

    // Update the Grand Total Amount field
    document.getElementById('grand_total_amount').value = grandTotalAmount.toFixed(2);
}

// Add event listeners to update the grand total amount when input changes
document.getElementById('total_cheque_value_with_additional').addEventListener('input', calculateGrandTotal);
document.getElementById('total_cheque_value_with_gst').addEventListener('input', calculateGrandTotal);

</script>
<script>
    let remainingCashValue = 0; // This will be updated based on totalCashValue and receivedAmount

    function handleLoanTypeChangeCash() {
        const loanType = document.getElementById('loan_type_cash').value;
        const otherLoanDescriptionContainer = document.getElementById('other-loan-description-container-cash');
        const installmentContainer = document.getElementById('installment-container-cash');

        // Show or hide the description field and installment fields based on loan type
        if (loanType === 'others') {
            otherLoanDescriptionContainer.style.display = 'block';
            installmentContainer.style.display = 'none';
        } else if (loanType !== "") {
            otherLoanDescriptionContainer.style.display = 'none';
            installmentContainer.style.display = 'block';
        } else {
            otherLoanDescriptionContainer.style.display = 'none';
            installmentContainer.style.display = 'none';
        }
    }

    function calculateInstallmentAmountCash() {
        const remainingCashValue = parseFloat(document.getElementById('remaining_cash_value').value) || 0;
        const noOfInstallments = parseInt(document.getElementById('no_of_installments_cash').value) || 1;

        // Calculate installment amount
        const installmentAmount = (remainingCashValue / noOfInstallments).toFixed(2);

        // Update the Installment Amount field
        document.getElementById('installment_amount_cash').value = installmentAmount;
    }

    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form'); // Select your form
    const submitButton = document.querySelector('button[type="submit"]'); // Select the Submit Sale button

    // Listen to the form submit event
    form.addEventListener('submit', function(event) {
        if (event.submitter !== submitButton) {
            // Prevent form submission if the submitter is not the Submit Sale button
            event.preventDefault();
        }
    });
});

</script>
<script>
    // Function to toggle Cash Installment Fields
    function toggleCashInstallmentFields() {
        const cashInstallmentValue = parseFloat(document.getElementById('cash_installment_value').value);
        const cashInstallmentContainer = document.getElementById('cash-installment-container');

        if (cashInstallmentValue > 0) {
            cashInstallmentContainer.style.display = 'block';
        } else {
            cashInstallmentContainer.style.display = 'none';
            // Reset cash installment fields
            document.getElementById('cash_loan_type').value = '';
            document.getElementById('other-loan-description-container-cash').style.display = 'none';
            document.getElementById('other_loan_description_cash').value = '';
            document.getElementById('cash_installment_frequency').value = '';
            document.getElementById('cash_installment_start_date').value = '';
            document.getElementById('cash_no_of_installments').value = '';
            document.getElementById('cash_installment_amount').value = '';
        }
    }

    // Function to handle Cash Loan Type change
    function handleLoanTypeChangeCash() {
        const loanType = document.getElementById('cash_loan_type').value;
        const otherLoanDescriptionContainer = document.getElementById('other-loan-description-container-cash');

        if (loanType === 'others') {
            otherLoanDescriptionContainer.style.display = 'block';
        } else {
            otherLoanDescriptionContainer.style.display = 'none';
            document.getElementById('other_loan_description_cash').value = '';
        }
    }

    // Attach the loan type change handler
    document.getElementById('cash_loan_type').addEventListener('change', handleLoanTypeChangeCash);

    // Function to calculate Cash Installment Amount
    function calculateCashInstallmentAmount() {
    const cashInstallmentValue = parseFloat(document.getElementById('cash_installment_value').value) || 0;
    const cashNoOfInstallments = parseInt(document.getElementById('cash_no_of_installments').value) || 0;

    if (cashNoOfInstallments > 0 && cashInstallmentValue > 0) {
        const installmentAmount = (cashInstallmentValue / cashNoOfInstallments).toFixed(2);
        document.getElementById('cash_installment_amount').value = installmentAmount;
    } else {
        document.getElementById('cash_installment_amount').value = '';
    }
}


console.log('Installment Amount:', installmentAmount);
    document.getElementById('loan_type').addEventListener('change', handleLoanTypeChange);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
     const availableParkings = @json($availableParkings); 
     const parkingFloorDropdown = document.getElementById('parkingFloor');
     const parkingSlotDropdown = document.getElementById('parkingSlot');
 
     // When a floor is selected
     parkingFloorDropdown.addEventListener('change', function () {
         const selectedFloor = this.value;
 
         // Clear previous options
         parkingSlotDropdown.innerHTML = '<option value="">-- Select a Parking Slot --</option>';
 
         // Filter and populate slots for the selected floor
         const filteredSlots = availableParkings.filter(parking => parking.floor_number == selectedFloor);
 
         filteredSlots.forEach(parking => {
             const option = document.createElement('option');
             option.value = parking.id; // Store parking ID here
             option.textContent = `Slot #${parking.slot_number} - ₹${parking.amount}`;
             parkingSlotDropdown.appendChild(option);
         });
     });
 });
 
 </script>
 <script>
    document.addEventListener('DOMContentLoaded', function () {
        const addParkingAmountCheckbox = document.getElementById('addParkingAmountCheckbox');
        const parkingAmountGroup = document.getElementById('parkingAmountGroup');
        const parkingAmountInput = document.getElementById('parkingAmount');
        const parkingSlotDropdown = document.getElementById('parkingSlot');
        const parkingAmountError = document.getElementById('parkingAmountError');
        const totalCashValueField = document.getElementById('total_cash_value');
        const cashValueAmountField = document.getElementById('cash_value_amount');
        const additionalAmountFields = document.querySelectorAll('.additional-amount');

        // Show/hide the parking amount field based on checkbox
        addParkingAmountCheckbox.addEventListener('change', function () {
            parkingAmountGroup.style.display = this.checked ? 'block' : 'none';
            parkingAmountInput.value = '';  // Clear any previous input
            parkingAmountError.style.display = 'none';  // Hide error message
            updateTotalCashValue(); // Update total cash value
        });

        // Validate parking amount when the input field loses focus or the slot changes
        function validateParkingAmount() {
            const selectedSlotId = parkingSlotDropdown.value;
            const enteredAmount = parseFloat(parkingAmountInput.value);

            if (selectedSlotId) {
                // Find the selected parking slot's details
                const selectedParking = availableParkings.find(parking => parking.id == selectedSlotId);
                
                if (selectedParking) {
                    const slotAmount = parseFloat(selectedParking.amount);

                    // Validate entered parking amount
                    if (isNaN(enteredAmount) || enteredAmount <= 0) {
                        // Show error if entered amount is less than or equal to 0
                        parkingAmountError.style.display = 'block';
                        parkingAmountError.textContent = 'Parking amount must be greater than 0.';
                        return false;
                    } else if (enteredAmount > slotAmount) {
                        // Show error if entered amount is greater than selected slot amount
                        parkingAmountError.style.display = 'block';
                        parkingAmountError.textContent = `Amount cannot be greater than the selected parking slot amount of $${slotAmount}.`;
                        return false;
                    } else {
                        // Hide error if the entered amount is valid
                        parkingAmountError.style.display = 'none';
                        return true;
                    }
                }
            }

            // If no slot is selected, don't show any error
            parkingAmountError.style.display = 'none';
            return true;
        }

        // Event listeners for validation
        parkingAmountInput.addEventListener('blur', validateParkingAmount);
        parkingSlotDropdown.addEventListener('change', validateParkingAmount);

        // Function to update total cash value (with parking amount)
        function updateTotalCashValue() {
            let baseCashValue = parseFloat(cashValueAmountField.value) || 0;

            // Calculate additional amounts from the additional fields
            let totalAdditionalAmount = 0;
            additionalAmountFields.forEach(amountField => {
                totalAdditionalAmount += parseFloat(amountField.value) || 0;
            });

            // Add the entered parking amount if the checkbox is checked
            let parkingAmount = 0;
            if (addParkingAmountCheckbox.checked) {
                parkingAmount = parseFloat(parkingAmountInput.value) || 0;
            }

            // Calculate the total cash value
            let totalCashValue = baseCashValue + totalAdditionalAmount + parkingAmount;
            totalCashValueField.value = totalCashValue.toFixed(2); // Display the result
        }

        // Update total cash value when inputs change
        cashValueAmountField.addEventListener('input', updateTotalCashValue);
        additionalAmountFields.forEach(field => {
            field.addEventListener('input', updateTotalCashValue);
        });
        parkingAmountInput.addEventListener('input', updateTotalCashValue); // When parking amount is changed
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const addParkingAmountCashCheckbox = document.getElementById('addParkingAmountCashCheckbox');
    const parkingAmountCashGroup = document.getElementById('parkingAmountCashGroup');
    const parkingAmountCashInput = document.getElementById('parkingAmountCash');
    const parkingAmountCashError = document.getElementById('parkingAmountCashError');
    const totalCashValueField = document.getElementById('total_cash_value'); // Assuming same field for total

    // Show/hide parking cash amount field based on checkbox
    addParkingAmountCashCheckbox.addEventListener('change', function () {
        parkingAmountCashGroup.style.display = this.checked ? 'block' : 'none';
        parkingAmountCashInput.value = '';  // Clear previous input
        parkingAmountCashError.style.display = 'none';  // Hide error message
        updateTotalCashValue(); // Update total cash value
    });

    // Validate parking amount (cash)
    function validateParkingAmountCash() {
        const enteredAmount = parseFloat(parkingAmountCashInput.value);

        if (isNaN(enteredAmount) || enteredAmount <= 0) {
            parkingAmountCashError.style.display = 'block';
            parkingAmountCashError.textContent = 'Parking amount must be greater than 0.';
            return false;
        } else {
            parkingAmountCashError.style.display = 'none';
            return true;
        }
    }

    // Update total cash value calculation
    function updateTotalCashValue() {
        let baseCashValue = parseFloat(document.getElementById('cash_value_amount').value) || 0;

        // Add entered parking cash amount if the checkbox is checked
        let parkingAmountCash = 0;
        if (addParkingAmountCashCheckbox.checked) {
            parkingAmountCash = parseFloat(parkingAmountCashInput.value) || 0;
        }

        // Calculate and update total cash value
        let totalCashValue = baseCashValue + parkingAmountCash;
        totalCashValueField.value = totalCashValue.toFixed(2); // Update displayed value
    }

    // Event listeners for validation and calculation
    parkingAmountCashInput.addEventListener('blur', validateParkingAmountCash);
    parkingAmountCashInput.addEventListener('input', updateTotalCashValue);
});

</script>

    <script>
        function calculateBalance() {
    const totalChequeValueWithGst = parseFloat(document.getElementById('total_cheque_value_with_gst').value) || 0;
    const receivedChequeValue = parseFloat(document.getElementById('received_cheque_value').value) || 0;

    // Calculate the balance
    const balanceAmount = totalChequeValueWithGst - receivedChequeValue;

    // Update the balance amount field
    document.getElementById('balance_amount').value = balanceAmount.toFixed(2);
    console.log("Balance Amount: ", balanceAmount.toFixed(2)); // Debug

    const loanTypeContainer = document.getElementById('loan-type-container');
    const installmentContainer = document.getElementById('installment-container');
    const descriptionContainer = document.getElementById('description-container'); // Get the description container

    // Show loan type and installment fields if balance amount is not zero or if received cheque value is entered
    if (balanceAmount !== 0 || receivedChequeValue > 0) {
        loanTypeContainer.style.display = 'block';  // Show loan type selection
        
        // Automatically show installment fields if received amount is present, regardless of loan type selection
        installmentContainer.style.display = 'block';  // Show installment fields
        
        // Show description field if receivedChequeValue > 0
        if (receivedChequeValue > 0) {
            descriptionContainer.style.display = 'block';
        }
    } else {
        loanTypeContainer.style.display = 'none';    // Hide loan type selection
        installmentContainer.style.display = 'none'; // Hide installment fields if balance is 0
        document.getElementById('other-loan-description-container').style.display = 'none'; // Hide description field if balance is 0
        descriptionContainer.style.display = 'none'; // Hide description field if receivedChequeValue is 0
    }
}

    </script>
<script>
    let totalLandAmount = 0; // Track total land amounts to subtract from total amount
    let landCounter = 0; // Counter for dynamically added fields

    // Function to add land details
    function addLandFields() {
        landCounter++; // Increment the counter for each new land entry

        // Create a new div for land description and amount
        const landDiv = document.createElement('div');
        landDiv.classList.add('land-entry');
        landDiv.id = `land-entry-${landCounter}`;

        const landHTML = `
<div class="form-group">
    <div class="form-row align-items-center">
        <div class="col-md-6">
            <label for="land_description_${landCounter}">Land Description ${landCounter}</label>
            <input type="text" class="form-control" id="land_description_${landCounter}" name="land_description[]" placeholder="Enter land description">
        </div>
        <div class="col-md-5">
            <label for="land_amount_${landCounter}">Land Amount</label>
            <input type="number" class="form-control" id="land_amount_${landCounter}" name="land_amount[]" placeholder="Enter land amount" oninput="updateLandAmount(${landCounter})">
        </div>
        <div class="d-flex justify-content-end">
            <button 
                type="button" 
                class="btn btn-danger btn-sm align-self-center rounded-circle d-flex justify-content-center align-items-center" 
                style="width: 40px; height: 40px;" 
                onclick="removeLandDetail(${landCounter})">
                <i class="fas fa-times"></i>
            </button></div>

    </div>
</div>

        `;
        landDiv.innerHTML = landHTML;

        // Add the new land fields to the container
        document.getElementById('landFieldsContainer').appendChild(landDiv);
    }

    // Function to remove a land detail and update the total amount
    function removeLandDetail(counter) {
        const landDiv = document.getElementById(`land-entry-${counter}`);
        const landAmount = parseFloat(document.getElementById(`land_amount_${counter}`).value) || 0;

        // Remove the land entry div
        landDiv.remove();

        // Subtract the land amount from the total land amount and update total amount
        totalLandAmount -= landAmount;
        updateTotalAmount();
    }

    // Function to update the total amount by subtracting the land amount
    function updateLandAmount(counter) {
        const landAmountInput = document.getElementById(`land_amount_${counter}`);
        const newLandAmount = parseFloat(landAmountInput.value) || 0;

        // Get the previous land amount from the input field (to handle change)
        const previousLandAmount = parseFloat(landAmountInput.dataset.previousAmount) || 0;

        // If the value is changing, subtract the old value and add the new value
        if (newLandAmount !== previousLandAmount) {
            totalLandAmount -= previousLandAmount; // Remove previous value if any
            totalLandAmount += newLandAmount; // Add the new value
            landAmountInput.dataset.previousAmount = newLandAmount; // Update the stored previous amount
        }

        // Update the total amount field
        updateTotalAmount();
    }

    // Function to update the total amount by subtracting the land amount
    function updateTotalAmount() {
        let saleAmount = parseFloat(document.getElementById('sale_amount').value) || 0;
        let areaType = document.getElementById('area_calculation_type').value;
        let totalAmount = 0;

        if (saleAmount && areaType) {
            if (areaType === 'super_build_up_area') {
                totalAmount = saleAmount * parseFloat(document.getElementById('build_up_area')?.value || 0);
            } else if (areaType === 'carpet_area') {
                totalAmount = saleAmount * parseFloat(document.getElementById('carpet_area')?.value || 0);
            }
        }

        // Subtract the total land amount
        totalAmount -= totalLandAmount;

        // Update the total amount field
        document.getElementById('total_amount').value = totalAmount.toFixed(2);

        // Recalculate other fields that depend on total amount
        calculateDiscountFromPercentage();
    }

    // Event listener for the "+" button
    document.getElementById('addLandButton').addEventListener('click', addLandFields);
</script>
<script>
    // Function to calculate the total cheque value including additional expenses and parking amount
    function calculateTotalChequeValueWithAdditional() {
        let baseChequeValue = parseFloat(document.getElementById('total_cheque_value').value) || 0;

        // Calculate the sum of all additional expenses
        let totalExpenses = 0;
        const expenseAmountFields = document.querySelectorAll('.cheque-expense-amount');
        expenseAmountFields.forEach(field => {
            totalExpenses += parseFloat(field.value) || 0;
        });

        // Add the parking amount if the checkbox is checked
        const addParkingAmountCheckbox = document.getElementById('addParkingAmountCheckbox');
        let parkingAmount = 0;
        if (addParkingAmountCheckbox.checked) {
            parkingAmount = parseFloat(document.getElementById('parkingAmount').value) || 0;
        }

        // Calculate the total cheque value with additional expenses and parking amount
        const totalChequeValueWithAdditional = baseChequeValue + totalExpenses + parkingAmount;

        // Update the "Total Cheque Value with Additional Expenses" field
        document.getElementById('total_cheque_value_with_additional').value = totalChequeValueWithAdditional.toFixed(2);
        document.getElementById('total_cheque_value_with_additional_hidden').value = totalChequeValueWithAdditional.toFixed(2); // Update hidden field for form submission
    }

    // Event listeners for input fields to trigger the calculation dynamically
    document.getElementById('parkingAmount').addEventListener('input', calculateTotalChequeValueWithAdditional);
    document.getElementById('addParkingAmountCheckbox').addEventListener('change', calculateTotalChequeValueWithAdditional);

    // Add dynamic expense fields with event listeners
    document.getElementById('add-expense').addEventListener('click', function () {
        const expenseContainer = document.getElementById('expense-container');
        const newExpenseEntry = document.createElement('div');
        newExpenseEntry.classList.add('row', 'mb-2');
        newExpenseEntry.innerHTML = `
            <div class="col-md-6">
                <input type="text" placeholder="Expense Description" class="form-control cheque-expense-description" name="cheque_expense_descriptions[]" />
            </div>
            <div class="col-md-6">
                <input type="number" placeholder="Expense Amount" class="form-control cheque-expense-amount" name="cheque_expense_amounts[]" oninput="calculateTotalChequeValueWithAdditional()" />
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-expense">Remove</button>
            </div>
        `;
        expenseContainer.appendChild(newExpenseEntry);

        // Add event listener for dynamically added expense inputs and remove buttons
        newExpenseEntry.querySelector('.cheque-expense-amount').addEventListener('input', calculateTotalChequeValueWithAdditional);
        newExpenseEntry.querySelector('.remove-expense').addEventListener('click', function () {
            expenseContainer.removeChild(newExpenseEntry);
            calculateTotalChequeValueWithAdditional(); // Recalculate total after removal
        });
    });
</script>