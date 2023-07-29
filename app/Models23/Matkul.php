<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matkul extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table    = 'matkul';
    protected $primaryKey = 'matkul_id';
    protected $fillable = [
        'dosen_id',
        'image',
        'nama_matkul',
        'semester_id',
        'deskripsi',
        'status'
    ];

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
