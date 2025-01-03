<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\CashInstallment;
use App\Models\InstallmentPayment;
use App\Models\CashInstallmentPayment;
use App\Models\Sale;
use App\Models\Banks;
use App\Models\Partner;
use App\Models\PartnerCashInstallment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class InstallmentController extends Controller
{
    // Show the installment details for a customer
    public function show($saleId)
{
    $sale = Sale::with('installments')->findOrFail($saleId);
    $banks = Banks::all(); // Fetch all banks

    $page ="installment";
    $title ="installment";
    
    return view('installments.index', compact('sale','title','page','banks'));
}

    // Mark an installment as paid
    public function markPayment(Request $request)
    {
        $validatedData = $request->validate([
            'installment_id' => 'required|integer',
            'paid_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'bank_id' => 'required|exists:banks,id',
            'cheque_number' => 'nullable|string', // Validate cheque_number as nullable string
        ]);
    
        // Find the installment
        $installment = Installment::findOrFail($validatedData['installment_id']);
    
        // Fetch the bank details
        $bank = Banks::findOrFail($validatedData['bank_id']);
    
        // Record the payment in the installment_payments table
        $payment = new InstallmentPayment();
        $payment->installment_id = $installment->id;
        $payment->paid_amount = $validatedData['paid_amount'];
        $payment->payment_date = $validatedData['payment_date'];
        $payment->account_holder_name = $bank->account_holder_name;
        $payment->cheque_number = $validatedData['cheque_number']; // Store cheque number
        $payment->save();
    
        // Update the total paid amount for the installment
        $installment->total_paid += $validatedData['paid_amount'];
    
        // Update status based on total paid amount
        if ($installment->total_paid >= $installment->installment_amount) {
            $installment->status = 'Paid';
        } else {
            $installment->status = 'Partially Paid';
        }
    
        $installment->save();
    
        return back()->with('success', 'Payment recorded successfully.');
    }
    
    
    public function showCashInstallments($saleId)
    {
        // Fetch the sale and its associated cash installments
        $sale = Sale::with('cashInstallments')->findOrFail($saleId);
        $partners = Partner::all(); // Fetch all partners
        // Page and title for the view
        $page = "cash_installment";
        $title = "Cash Installment";
    
        return view('cash_installments.show', compact('sale', 'title', 'page','partners'));
    }
    public function cashMarkPayment(Request $request, $sale)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'installment_id' => 'required|exists:cash_installments,id',
            'paid_amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'partner' => 'nullable|array', // Added partner validation
            'partner.*.id' => 'required_with:partner|exists:partners,id',
            'partner.*.percentage' => 'required_with:partner|numeric|min:0|max:100',
            'partner.*.amount' => 'required_with:partner|numeric|min:0',
        ]);
    
        // Retrieve the specific installment
        $installment = CashInstallment::findOrFail($validatedData['installment_id']);
    
        // Calculate the remaining amount
        $remainingAmount = $installment->installment_amount - ($installment->total_paid ?? 0);
    
        // Check if the paid amount exceeds the remaining balance
        if ($validatedData['paid_amount'] > $remainingAmount) {
            return redirect()->back()->withErrors([
                'paid_amount' => 'Paid amount cannot exceed the remaining balance of ₹' . number_format($remainingAmount, 2),
            ]);
        }
    
        // Start a database transaction to ensure atomic operations
        DB::beginTransaction();
    
        try {
            // Record the payment
            $payment = new CashInstallmentPayment();
            $payment->cash_installment_id = $installment->id;
            $payment->paid_amount = $validatedData['paid_amount'];
            $payment->payment_date = $validatedData['payment_date'];
            $payment->save();
    
            // Update the total paid amount for the cash installment
            $installment->total_paid = ($installment->total_paid ?? 0) + $validatedData['paid_amount'];
    
            // Update status based on total paid amount
            if ($installment->total_paid >= $installment->installment_amount) {
                $installment->status = 'Paid';
            } else {
                $installment->status = 'Partially Paid';
            }
    
            $installment->save();
    
            // Save partner data if provided
            if (isset($validatedData['partner']) && is_array($validatedData['partner'])) {
                foreach ($validatedData['partner'] as $partnerData) {
                    Log::debug('Saving PartnerCashInstallment:', $partnerData); // Log partner data before saving
    
                    // Create PartnerCashInstallment record with the correct payment ID
                    PartnerCashInstallment::create([
                        'cashinstallment_payment_id' => $payment->id, // Store the cashinstallment_payment_id here
                        'partner_id' => $partnerData['id'],
                        'percentage' => $partnerData['percentage'],
                        'amount' => $partnerData['amount'],
                    ]);
                }
            }
    
            // Commit transaction
            DB::commit();
    
            return back()->with('success', 'Payment recorded successfully.');
    
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollback();
            Log::error('Payment processing failed:', ['error' => $e->getMessage()]);
    
            return back()->withErrors($validatedData);
        }
    }
    
public function downloadPdf($saleId)
{
    // Fetch the sale and its installments along with the payment details
    $sale = Sale::with(['installments', 'installments.payments'])->findOrFail($saleId);

    // Filter out paid installments
    $paidInstallments = $sale->installments->filter(function($installment) {
        return $installment->status == 'Paid';
    });

    // Generate the PDF with the data
    $pdf = PDF::loadView('admin.installments.pdf', compact('sale', 'paidInstallments'));

    return $pdf->download('installments_' . $sale->customer_name . '.pdf');
}
public function downloadFullInstallmentPdf($saleId)
{
    $sale = Sale::with('installments', 'room')->findOrFail($saleId);

    $pdf = Pdf::loadView('admin.installments.full_page_pdf', compact('sale'));

    return $pdf->download('full_installment_page_' . $sale->customer_name . '.pdf');
}

}