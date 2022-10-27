<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'dep_date',
        'visiting_to',
        'dock_island',
        'vessel_name',
        'vessel_Contact',
        'status',
    ];
}
