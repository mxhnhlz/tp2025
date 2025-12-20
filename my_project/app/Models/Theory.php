<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theory extends Model
{
    protected $guarded = [];

    // Связь: теория принадлежит заданию
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
