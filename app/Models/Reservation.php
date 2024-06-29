<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TourPackage;
use App\Models\Payment;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'reservation_date',
        'number_of_passengers',
        'payment_method',
        'status',
        'isActived',
        'isDeleted',
        'isPaid',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }

    public function tourists()
    {
        return $this->belongsToMany(Tourist::class, 'tour_package_tourist', 'tour_package_id', 'tourist_id')
            ->whereHas('userTourist', function ($query) {
                $query->where('user_id', $this->user_id);
            });
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'reservation_id');
    }
}
