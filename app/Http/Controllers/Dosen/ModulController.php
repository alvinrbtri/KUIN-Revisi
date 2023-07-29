<?php

namespace App\Http\Controllers\Dosen;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Matkul;
use App\Models\ModulVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ModulController extends Controller
{
    // handle modul view
    protected function showModul()
    {

        $access_modul = auth()->user();

        if ($access_modul->level == 'admin') {
            $modul = Modul::with(['kelas', 'matkul'])->whereHas('matkul', function ($query) {
                $query->where('status', 'aktif');
            })->get();
        } elseif ($access_modul->level == 'mahasiswa') {
            $modul = Modul::with(['kelas', 'matkul'])->whereHas('matkul', function ($query) {
                $query->where('semester_id', auth()->user()->semester_id)->where('status', 'aktif');
            })->where('kelas_id', auth()->user()->kelas_id)->get();
        } elseif ($access_modul->level == 'dosen') {
            $modul = Modul::with(['kelas', 'matkul'])->whereHas('matkul', function ($query) {
                $query->where('dosen_id', auth()->user()->user_id)->where('status', 'aktif');
            })->get();
        }

        $data = [
            'title'     => 'Module',
            'id_page'   => 4,
            'matkul'    => Matkul::where('dosen_id', auth()->user()->user_id)->get(),
            'modul'     => $modul,
            'kelas'     => Kelas::all(),
        ];

        return view('dosen.modul', $data);
    }

    protected function detail_modul($modul_id)
    {
        $modul = Modul::find($modul_id);
        $modul_video = ModulVideo::get();
        $data = [
            'title'     => $modul->nama_modul,
            'id_page'   => 9,
            'modul'     => $modul,
            'modul_video'     => $modul_video,
        ];

        return view('global.detail_modul', $data);
    }

    // handle create data modul/materi
       protected function create_modul(Request $request)
    {
        $modul = new Modul();
        $modul->matkul_id = $request->matkul_id;
        $modul->nama_modul = $request->nama_modul;
        $modul->kelas_id = $request->kelas_id;
        $modul->deskripsi = $request->deskripsi;
    
        if ($request->hasFile('file_modul')) {
            $file_modul = $request->file_modul;
            $file_name = time() . '_' . $file_modul->getClientOriginalName();
            $file_path = 'public/images/' . $file_name;
            $file_modul->storeAs('public/images', $file_name);
            $modul->file_modul = $file_path;
        }
    
        $modul->save();
    
        return back()->with('success', 'Berhasil menambahkan modul.');
    }


    // handle update modul
    protected function update_modul(Request $request, $modul_id)
    {
        $modul = Modul::find($modul_id);
        $old_file = $modul->file_modul;


        if ($request->hasFile('file_modul') && $request->file_modul == true) {
            $file_req = $request->file('file_modul');
            $file_modul = time() . '_' . $file_req->getClientOriginalName();
            Storage::putFileAs('public/images', $file_req, $file_modul);
            $modul->file_modul = $file_modul;

            if ($old_file != $file_modul) {
                Storage::delete('public/images/' . $old_file);
            }
        }
        
        //   if ($request->hasFile('file_modul')) {
        //     $file_modul = $request->file_modul;
        //     $file_name = time() . '_' . $file_modul->getClientOriginalName();
        //     $file_path = 'public/documents/' . $file_name;
        //     $file_modul->storeAs('public/documents', $file_name);
        //     $modul->file_modul = $file_path;
        // }

        $modul->matkul_id = $request->matkul_id;
        $modul->kelas_id = $request->kelas_id;
        $modul->nama_modul = $request->nama_modul;
        $modul->deskripsi = $request->deskripsi;

        $modul->save();

        return back()->with('success', 'Berhasil mengupdate modul.');
    }

    // handle delete modul
    protected function hapus_modul($modul_id)
    {
        DB::table('modul')->where('modul_id', $modul_id)->delete();

        return back()->with('warning', 'Modul telah dihapus.');
    }
}
