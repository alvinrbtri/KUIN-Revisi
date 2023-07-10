<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Quiz extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'quiz_id';
    protected $table = 'quizzes';
    protected $fillable = [
        'quiz_name',
        'modul_id',
        'quiz_type',
        'quiz_date',
        'jam',
        'menit',
        'detik'
    ];

    // relation table model
    public function modul(): BelongsTo
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }
}
