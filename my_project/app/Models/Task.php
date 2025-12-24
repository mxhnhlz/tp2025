<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    // Связь: Task принадлежит Section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    // Связь: Task имеет много вопросов
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Связь: Task имеет одну теорию
    public function theory()
    {
        return $this->hasOne(Theory::class);
    }

    public function userTaskProgress()
    {
        return $this->hasMany(UserTaskProgress::class);
    }
    // Вычисляемое поле для суммы баллов
    public function getTotalPointsAttribute(): int
    {
        // Суммируем поле points у всех связанных вопросов
        return $this->questions()->sum('points');
    }

}
