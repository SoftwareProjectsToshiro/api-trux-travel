<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tourist extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_documento',
        'documento_identidad',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'email',
        'telefono',
        'fecha_nacimiento',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tourist', 'tourist_id', 'user_id');
    }

    public function tourPackages()
    {
        return $this->belongsToMany(TourPackage::class, 'tour_package_tourist')
            ->using(TourPackageTourist::class)
            ->withTimestamps();
    }

    public function userTourist()
    {
        return $this->hasOne(UserTourist::class, 'tourist_id', 'id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
