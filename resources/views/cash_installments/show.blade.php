@extends('layouts.default')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm p-4">
        <h2 class="text-center mb-4 text-primary">Cash Installments for {{ $sale->customer_name }}</h2>

        <p class="mb-4">Room number: {{ $sale->room->room_number }}, 
            Floor: {{ $sale->room->room_floor }}, 
            Type: {{ $sale->room->room_type }}</p>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($sale->cashInstallments->isEmpty())
        <div class="alert alert-info text-center">No cash installments found for this customer.</div>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th>Installment Date</th>
                    <th>Installment Amount</th>
                    <th>Paid Amount</th>
                    <th>Remaining Balance</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->cashInstallments as $installment)
                @php
                $remainingAmount = $installment->installment_amount - ($installment->total_paid ?? 0);
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($installment->installment_date)->format('d-m-Y') }}</td>
                    <td>₹{{ number_format($installment->installment_amount, 2) }}</td>
                    <td>₹{{ number_format($installment->total_paid ?? 0, 2) }}</td>
                    <td>₹{{ number_format($remainingAmount, 2) }}</td>
                    <td>{{ ucfirst($installment->status) }}</td>
                    <td>
                        @if ($installment->status !== 'Paid')
                        <form id="payment-form-{{ $installment->id }}" action="{{ route('admin.cashInstallments.markPayment', ['sale' => $sale->id]) }}" method="POST">
                          @csrf
                          <input type="hidden" name="installment_id" value="{{ $installment->id }}">
                          
                          <div class="form-group">
                              <label for="paid_amount_{{ $installment->id }}">Enter Paid Amount</label>
                              <input type="number" id="paid_amount_{{ $installment->id }}" name="paid_amount" class="form-control" step="0.01" required>
                          </div>
                      
                          <div class="form-group">
                              <label for="payment_date_{{ $installment->id }}">Payment Date</label>
                              <input type="date" id="payment_date_{{ $installment->id }}" name="payment_date" class="form-control" required>
                          </div>
                          
                          <div class="form-group">
                              <label>Select Partners</label>
                              <div class="d-flex flex-wrap">
                                  @foreach ($partners as $partner)
                                  <div class="form-check mr-3">
                                      <input type="checkbox" class="form-check-input partner-checkbox" id="partner_{{ $partner->id }}_{{ $installment->id }}" name="partner[{{ $partner->id }}][id]" value="{{ $partner->id }}" data-partner-id="{{ $partner->id }}" data-installment-id="{{ $installment->id }}">
                                      <label class="form-check-label" for="partner_{{ $partner->id }}_{{ $installment->id }}">{{ $partner->first_name }}</label>
                                  </div>
                                  @endforeach
                              </div>
                          </div>
                      
                          <div id="partner-details-{{ $installment->id }}"></div>
                      
                          <button type="submit" class="btn btn-primary mt-3">Submit Payment</button>
                      </form>
                      
                        @else
                        <span class="text-success">Fully Paid</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function() {
      @foreach ($sale->cashInstallments as $installment)
          const partnerDetailsDiv{{ $installment->id }} = document.getElementById('partner-details-{{ $installment->id }}');
          const paidAmountInput{{ $installment->id }} = document.getElementById('paid_amount_{{ $installment->id }}');
  
          document.querySelectorAll(`.partner-checkbox[data-installment-id="{{ $installment->id }}"]`).forEach(checkbox => {
              checkbox.addEventListener('change', function() {
                  const partnerId = this.dataset.partnerId;
                  const isChecked = this.checked;
  
                  if (isChecked) {
                      const partnerDiv = document.createElement('div');
                      partnerDiv.id = `partner-fields-${partnerId}-{{ $installment->id }}`;
                      partnerDiv.className = 'form-group';
  
                      const percentageLabel = document.createElement('label');
                      percentageLabel.textContent = `Percentage for Partner ${partnerId}`;
                      partnerDiv.appendChild(percentageLabel);
  
                      const percentageInput = document.createElement('input');
                      percentageInput.type = 'number';
                      percentageInput.name = `partner[${partnerId}][percentage]`;
                      percentageInput.className = 'form-control partner-percentage';
                      percentageInput.step = '0.01';
                      percentageInput.dataset.partnerId = partnerId;
                      percentageInput.dataset.installmentId = '{{ $installment->id }}';
                      partnerDiv.appendChild(percentageInput);
  
                      const amountLabel = document.createElement('label');
                      amountLabel.textContent = `Amount for Partner ${partnerId}`;
                      partnerDiv.appendChild(amountLabel);
  
                      const amountInput = document.createElement('input');
                      amountInput.type = 'number';
                      amountInput.name = `partner[${partnerId}][amount]`;
                      amountInput.className = 'form-control partner-amount';
                      amountInput.step = '0.01';
                      amountInput.dataset.partnerId = partnerId;
                      amountInput.dataset.installmentId = '{{ $installment->id }}';
                      partnerDiv.appendChild(amountInput);
  
                      // Append partner div
                      partnerDetailsDiv{{ $installment->id }}.appendChild(partnerDiv);
  
                      // Add listeners for calculation
                      percentageInput.addEventListener('input', function() {
                          const paidAmount = parseFloat(paidAmountInput{{ $installment->id }}.value) || 0;
                          amountInput.value = (paidAmount * (this.value / 100)).toFixed(2);
                      });
  
                      amountInput.addEventListener('input', function() {
                          const paidAmount = parseFloat(paidAmountInput{{ $installment->id }}.value) || 0;
                          percentageInput.value = ((this.value / paidAmount) * 100).toFixed(2);
                      });
                  } else {
                      // Remove partner fields when unchecked
                      const partnerDiv = document.getElementById(`partner-fields-${partnerId}-{{ $installment->id }}`);
                      if (partnerDiv) partnerDiv.remove();
                  }
              });
          });
      @endforeach
  });
  </script>
  