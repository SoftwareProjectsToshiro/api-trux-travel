<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TourPackage;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_package_id',
        'name',
        'description',
        'imagen',
        'incluye_guia',
        'incluye_transporte',
        'hora_inicio',
        'hora_fin',
        'isActived',
        'isDeleted',
        'created_at',
        'updated_at',
    ];

    public function package()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }
}
