<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TourPackageTourist extends Pivot
{
    use HasFactory;
    public $incrementing = true;
    protected $table = 'tour_package_tourist';
    protected $fillable = ['tour_package_id', 'tourist_id'];
}
