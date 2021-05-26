<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirant extends Model
{
    use HasFactory;

    protected $fillable = ['fname','lname', 'email','image','counts', 'password', 'profile_image'];
}
