<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AllTasks extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function Check()
    {
        return $this->hasOne(CompleteTask::class.'task_id', 'id');
    }
    public function Question()
    {
        return $this->hasMany(Question::class.'task_id', 'id');
    }
    public function getThumbnailImageAttribute($value)
    {
        return asset(Storage::url($value));

    }
}
