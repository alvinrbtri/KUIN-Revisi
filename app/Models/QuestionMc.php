<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionMc extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'question_mc';
    protected $primaryKey = 'question_id';
    protected $fillable = [
        'quiz_id',
        'question',
        'question_image',
        'question_poin'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
