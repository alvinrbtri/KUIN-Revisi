<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Essay extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'essay';
    protected $primaryKey = 'essay_id';
    protected $fillable = [
        'quiz_id',
        'essay_question',
        'essay_image',
        'essay_poin'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
