<?php

namespace App\Models;

use App\Models\ModulVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modul extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'modul';
    protected $primaryKey = 'modul_id';
    protected $fillable = [
        'matkul_id',
        'dosen_id',
        'kelas_id',
        'nama_modul',
        'file_modul',
        'deskripsi'
    ];

    public function matkul(): BelongsTo
    {
        return $this->belongsTo(Matkul::class, 'matkul_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function video()
    {
        return $this->hasMany(ModulVideo::class, 'modul_id', 'id');
    }
    
}
