<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Draggable extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'draggable';
    protected $primaryKey = 'draggable_id';
    protected $fillable = [
        'quiz_id',
        'draggable_question',
        'draggable_image',
        'draggable_poin'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
