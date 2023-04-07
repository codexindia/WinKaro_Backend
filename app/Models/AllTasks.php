<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllTasks extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function Check()
    {
        return $this->hasOne(CompleteTask::class.'task_id', 'id');
    }
}
