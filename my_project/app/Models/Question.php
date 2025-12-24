<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    // Если используете fillable:
    protected $fillable = [
        'task_id',
        'content',
        'type',
        'hint',
        'order',
        'points', // <- вот это ключевое
    ];



    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->orderBy('order_position');
    }

    public function textAnswers(): HasOne
    {
        return $this->hasOne(QuestionTextAnswer::class, 'question_id', 'id');
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}
