<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionMc extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'option_mc';
    protected $primaryKey = 'option_id';
    protected $fillable = [
        'question_id',
        'opsi1',
        'opsi2',
        'opsi3',
        'opsi4',
        'opsi5',
        'key_answer'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuestionMc::class, 'question_id');
    }
}
