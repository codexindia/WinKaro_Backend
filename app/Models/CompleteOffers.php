<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteOffers extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function GetName()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
