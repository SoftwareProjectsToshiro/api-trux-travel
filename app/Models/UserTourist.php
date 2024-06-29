<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTourist extends Model
{
    use HasFactory;

    protected $table = 'user_tourist';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'tourist_id',
        'created_at',
        'updated_at'
    ];

    public function tourist()
    {
        return $this->belongsTo(Tourist::class, 'tourist_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
