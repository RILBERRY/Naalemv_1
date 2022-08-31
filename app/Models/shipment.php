<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'qty',
        'unit_price',
        'img_path',
        'category_id',
        'packages_id',
    ];
}
