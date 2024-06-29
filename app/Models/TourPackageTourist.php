<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TourPackageTourist extends Pivot
{
    use HasFactory;
    public $incrementing = true;
    protected $table = 'tour_package_tourist';
    protected $fillable = [
        'tour_package_id',
        'tourist_id',
        'created_at',
        'updated_at'
    ];

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'tour_package_id');
    }

    public function tourist()
    {
        return $this->belongsTo(Tourist::class, 'tourist_id');
    }

    public function userTourist()
    {
        return $this->hasOne(UserTourist::class, 'tourist_id', 'tourist_id');
    }
}
