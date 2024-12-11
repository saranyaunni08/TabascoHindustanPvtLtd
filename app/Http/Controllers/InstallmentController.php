<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Installment;
use App\Models\InstallmentPayment;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;


class InstallmentController extends Controller
{
    // Show the installment details for a customer
    public function show($saleId)
{
    $sale = Sale::with('installments')->findOrFail($saleId);
    $page ="installment";
    $title ="installment";
    
    return view('installments.index', compact('sale','title','page'));
}

    // Mark an installment as paid
    public function markPayment(Request $request)
{
    $validatedData = $request->validate([
        'installment_id' => 'required|integer',
        'paid_amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date',
    ]);

    // Find the installment
    $installment = Installment::findOrFail($validatedData['installment_id']);

    // Record the payment in the installment_payments table
    $payment = new InstallmentPayment();
    $payment->installment_id = $installment->id;
    $payment->paid_amount = $validatedData['paid_amount'];
    $payment->payment_date = $validatedData['payment_date'];
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