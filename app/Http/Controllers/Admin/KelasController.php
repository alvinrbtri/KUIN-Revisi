<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    // handle view form kelas
    protected function showKelas()
    {
        $data = [
            'title'     => 'Kelas',
            'id_page'   => 6,
            'kelas'     => Kelas::all()
        ];

        return view('admin.kelas', $data);
    }

    // handle create data kelas
    protected function create_kelas(Request $request)
    {
        $kelas = new Kelas();
        $check_data = Kelas::where('nama_kelas', '=', $request->nama_kelas)->first();

        if ($check_data == false) {
            $kelas->nama_kelas = $request->nama_kelas;
            $kelas->save();

            return back()->with('success', 'Berhasil menambahkan data kelas.');
        }


        return back()->with('error', 'Tipe Data kelas yang anda masukkan sudah digunakan.');
    }

    // handle delete data kelas
    protected function hapus_kelas($kelas_id)
    {
        DB::table('kelas')->where('kelas_id', $kelas_id)->delete();

        return back()->with('warning', 'Data kelas telah dihapus.');
    }

    // handle update data kelas
    protected function update_kelas($kelas_id, Request $request)
    {
        $kelas = Kelas::find($kelas_id);
        $check_data = Kelas::where('nama_kelas', '=', $request->nama_kelas)->first();

        if ($check_data == false) {
            $kelas->nama_kelas = $request->nama_kelas;
            $kelas->save();

            return back()->with('info', 'Berhasil mengupdate data kelas.');
        }

        return back()->with('error', 'Tipe Data kelas yang anda masukkan sudah digunakan.');
    }
}
