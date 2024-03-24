<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        "place",
        "expense_head",
        "month",
        'date',
        "beneficiary",
        "amount_words",
        "cash_cheque_no",
        "prepared_by",
        "examined_by",
        "authorized_for_payment",
        "date_prepared",
        'line_items',
        "currency",
    ];
}
