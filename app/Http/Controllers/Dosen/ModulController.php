<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Matkul;
use App\Models\Modul;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $data = [
            'title'     => $modul->nama_modul,
            'id_page'   => 9,
            'modul'     => $modul
        ];

        return view('global.detail_modul', $data);
    }

    // handle create data modul/materi
    protected function create_modul(Request $request)
    {
        $modul = new Modul();
        $file_modul = $request->file('file_modul');
        $modul_name = time() . '_' . $file_modul->getClientOriginalName();

        Storage::putFileAs('public/documents', $file_modul, $modul_name);

        $modul->matkul_id = $request->matkul_id;
        $modul->nama_modul = $request->nama_modul;
        $modul->kelas_id = $request->kelas_id;
        $modul->file_modul = $modul_name;
        $modul->deskripsi = $request->deskripsi;

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
            Storage::putFileAs('public/documents', $file_req, $file_modul);
            $modul->file_modul = $file_modul;

            if ($old_file != $file_modul) {
                Storage::delete('public/documents/' . $old_file);
            }
        }

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
