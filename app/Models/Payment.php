<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'amount_received',
        'currency',
        'method_type',
        'service_used',
        'status',
        'transaction_id',
        'transaction_data',
    ];

    protected $casts = [
        'transaction_data' => 'array',
        'status' => PaymentStatus::class
    ];
}
