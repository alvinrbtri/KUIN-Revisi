<?php

namespace App\Models;

use App\Models\Essay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnswerEssay extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'answer_essay';
    protected $primaryKey = 'answer_id';
    protected $fillable = [
        'user_id',
        'quiz_id',
        'essay_id',
        'answer',
        'score'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function essay(): BelongsTo
    {
        return $this->belongsTo(Essay::class, 'essay_id');
    }
}
