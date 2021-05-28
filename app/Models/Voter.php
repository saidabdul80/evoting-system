<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    use HasFactory;
    protected $fillable = [
      '*'
    ];


    public function votings()
    {
        return $this->hasMany(Voting::class,'voters_id','voter_id');        
    }
}
