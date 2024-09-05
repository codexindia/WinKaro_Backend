<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerWithdrawals extends Model
{
    use HasFactory;
    public function getManager()
    {
        return $this->hasOne(AreaManager::class, 'id', 'mid');
    }
}
