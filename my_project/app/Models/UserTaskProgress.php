<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTaskProgress extends Model
{
    use HasFactory;

    protected $table = 'user_task_progress';

    protected $fillable = [
        'user_id',
        'task_id',
        'score',
        'completed_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function taskProgress()
    {
        return $this->hasMany(UserTaskProgress::class);
    }

}
