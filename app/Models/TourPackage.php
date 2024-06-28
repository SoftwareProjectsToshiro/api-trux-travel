<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tour;
use App\Models\Reservation;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_paquete',
        'precio',
        'imagen',
        'isActived',
        'isDeleted',
        'created_at',
        'updated_at',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class, 'tour_package_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'package_id');
    }

    public function tourists()
    {
        return $this->belongsToMany(Tourist::class, 'tour_package_tourist')
            ->using(TourPackageTourist::class)
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
