<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banners extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function getSourceLinkAttribute($value)
    {
        return asset(Storage::url($value));

    }
}
