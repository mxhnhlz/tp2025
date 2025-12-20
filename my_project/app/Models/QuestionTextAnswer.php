<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionTextAnswer extends Model
{
//    protected $fillable = [
//        'question_id',
//        'correct_answer',
//        'is_case_sensitive',
//        'is_exact_match'
//    ];

    protected $guarded = [];

    protected $casts = [
        'is_exact_match' => 'boolean',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function checkAnswer(string $userAnswer): bool
    {
        $correct = $this->correct_answer;
        $user = $userAnswer;

        $correct = mb_strtolower($correct);
        $user = mb_strtolower($user);

        if ($this->is_exact_match) {
            return trim($correct) === trim($user);
        } else {
            return str_contains($user, $correct);
        }
    }
}
