<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'vat',
        'service_charge',
        'date',
        'billed_to_line_1',
        'billed_to_line_2',
        'billed_to_line_3',
        'account_name',
        'account_number',
        'bank_name',
        'line_items',
        'currency',
        'discount',
    ];
} 