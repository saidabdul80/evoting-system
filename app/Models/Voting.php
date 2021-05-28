<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;
    protected $fillable = [
      '*'
    ];

    public function aspirants()
    {
        return $this->belongsTo(Aspirant::class,'aspirant_id');
    }

    public function voters()
    {
        return $this->belongsTo(Voter::class,'voter_id');
    }
}
