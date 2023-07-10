<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DraggableOption extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'draggable_option';
    protected $primaryKey = 'draggable_opt_id';
    protected $fillable = [
        'quiz_id',
        'draggable_id',
        'draggable_answer'
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'user_id');
    }

    public function draggable(): BelongsTo
    {
        return $this->belongsTo(Draggable::class, 'draggable_id');
    }
}
