<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompleteTask extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function GetName()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function GetTask()
    {
        return $this->hasOne(AllTasks::class,'id','task_id');
    }
    public function getProofSrcAttribute($value)
    {
        return asset(Storage::url($value));

    }
}
