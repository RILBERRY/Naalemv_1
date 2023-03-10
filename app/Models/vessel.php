<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vessel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'island',
        'regno',
        'status',
    ];
    public function VesselName()
    {
        return $this->hasOne(package::class, 'vessel_id');
    }
}
