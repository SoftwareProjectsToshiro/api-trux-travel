<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Tourist extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
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
        return $this->belongsToMany(User::class, 'user_tourist', 'tourist_id', 'user_id')
                    ->withTimestamps();
    }
}
