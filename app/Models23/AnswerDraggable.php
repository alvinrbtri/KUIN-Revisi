<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnswerDraggable extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'answer_draggable';
    protected $primaryKey = 'answer_id';
    protected $fillable = [
        'user_id',
        'quiz_id',
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
}
