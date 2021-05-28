<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspirant extends Model
{
    use HasFactory;

    protected $fillable = ['fname','lname', 'email','image','counts', 'password', 'profile_image'];
    public function voters()
    {
    	 //return $this->hasManyThrough(Voting::class, Aspirant::class,'post_id','aspirant_id','voters_id','id');  
    	 /*return $this->hasManyThrough(Voting::class, Aspirant::class,'voters_id','id','voters_id','voter_id');*/
        //return $this->hasMany(Voting::class,'voter_id','voters_id');        
    	 return $this->hasMany(Voting::class,'aspirant_id');
    }
}
