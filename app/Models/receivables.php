<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receivables extends Model
{
    use HasFactory;
    protected $fillable = [
        'packID',
        'paymentType',
        'payslip',
    ];
}
