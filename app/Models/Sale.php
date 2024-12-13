<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Fillable attributes for mass assignment.
     */
    protected $fillable = [
        // Customer details
        'customer_name',
        'customer_email',
        'customer_contact',

        // Sale details
        'room_id',
        'sale_amount',
        'total_amount',
        'discount_percentage',
        'discount_amount',
        'final_amount',

        // Financial details
        'gst_percentage',
        'gst_amount',
        'total_cash_value',
        'total_cheque_value',
        'balance_amount',
        
        // Installment details
        'installment_start_date',
        'installment_frequency',
        'number_of_installments',
        'installment_amount',
        'cash_installment_start_date',
        'cash_installment_frequency',
        'cash_no_of_installments',
        'cash_installment_amount',

        // Parking and other expenses
        'parking_floor',
        'parking_id',
        'parking_amount_cash',
        'parking_amount_cheque',
        'expense_descriptions',
        'expense_amounts',
        'cheque_expense_descriptions',
        'cheque_expense_amounts',

        // Exchange details
        'exchangestatus',
        'exchange_sale_id',
    ];

    /**
     * Cast attributes for data conversion.
     */
    protected $casts = [
        'partner_distribution' => 'array',
        'partner_percentages' => 'array',
        'partner_amounts' => 'array',
        'cheque_expense_descriptions' => 'array',
        'cheque_expense_amounts' => 'array',
    ];

    /**
     * Define the relationship with Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Define the relationship with Installments.
     */
    public function installments()
    {
        return $this->hasMany(Installment::class, 'sale_id');
    }

    /**
     * Define the relationship with PartnerDistributions.
     */
    public function partnerDistributions()
    {
        return $this->hasMany(PartnerDistribution::class);
    }

    /**
     * Define the relationship with CashInstallments.
     */
    public function cashInstallments()
    {
        return $this->hasMany(CashInstallment::class, 'sale_id');
    }

    /**
     * Define the relationship with Buildings.
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Define the relationship for exchanged sales.
     */
    public function exchangedSale()
    {
        return $this->belongsTo(Sale::class, 'exchange_sale_id');
    }
}
