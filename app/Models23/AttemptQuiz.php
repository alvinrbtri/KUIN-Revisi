<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttemptQuiz extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'attempt_quiz';
    protected $primaryKey = 'attempt_id';
    protected $fillable = [
        'user_id',
        'quiz_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
