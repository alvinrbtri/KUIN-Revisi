<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Matkul;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulVideo extends Model
{
    use HasFactory;

    protected $table = 'modul_videos';

    // protected $fillable = [
    //     'modul_id',
    //     'nama_video',
    //     'file_modul',
    //     'deskripsi'
    // ];

    protected $guarded = [];


    public function matkul(): BelongsTo
    {
        return $this->belongsTo(Matkul::class, 'matkul_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
