<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
     protected $hidden = [
        'remember_token',
        'created_at',
        'updated_at',
    ];

    public function aspirants()
    {
        return $this->hasMany(Aspirant::class,'post_id');
    }
}
