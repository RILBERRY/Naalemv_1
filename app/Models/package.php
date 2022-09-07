<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class package extends Model
{
    use HasFactory;
    protected $fillable = [
        'CustAddress',
        'from',
        'to',
        'status',
        'customer_id',
    ];
    public function payment_status()
    {
        return $this->hasOne(receivables::class, 'packID');
    }
}
