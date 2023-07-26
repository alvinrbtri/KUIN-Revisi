<?php

namespace App\Http\Controllers\Global;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Matkul;
use App\Models\ModulVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ShowVideoController extends Controller
{
    public function showModulVideo($id)
    {
        $modul = Modul::findOrFail($id);
        $modul_video = ModulVideo::where('modul_id', $modul->modul_id)->orderByDesc('created_at')->get();

        $data = [
            'title' => 'Video',
            'id_page' => 17,
            'modul' => $modul,
            'modul_video' => $modul_video,
            'kelas' => Kelas::all(),
        ];

        return view('global.detail_modul', $data);
    }


}
