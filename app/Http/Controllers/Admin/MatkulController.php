<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matkul;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MatkulController extends Controller
{
    // handle matkul view
    protected function showMatkul()
    {
        $data = [
            'title'     => 'Course',
            'id_page'   => 5,
            'dosen'     => User::where('level', 'dosen')->select(['user_id', 'nama'])->get(),
            'semester'  => Semester::all(),
            'matkul'    => Matkul::with(['semester', 'dosen'])->get()
        ];

        return view('admin.matkul', $data);
    }

    // handle create data mata kuliah
    protected function create_matkul(Request $request)
    {
        $matkul = new Matkul();
        $check_data = Matkul::where('nama_matkul', '=', $request->nama_matkul)->first();

        if ($check_data == false) {

            $image = $request->file('image');
            $image_name = time() . '_' . $image->getClientOriginalName();

            Storage::putFileAs('public/images', $image, $image_name);

            $matkul->dosen_id = $request->dosen_id;
            $matkul->image = $image_name;
            $matkul->nama_matkul = $request->nama_matkul;
            $matkul->semester_id = $request->semester_id;
            $matkul->deskripsi = $request->deskripsi;
            $matkul->status = $request->status;

            $matkul->save();

            return back()->with('success', 'Berhasil menambahkan mata kuliah.');
        }

        return back()->with('error', 'Data mata kuliah yang anda masukkan sudah digunakan.');
    }

    protected function update_matkul($matkul_id, Request $request)
    {
        $matkul = Matkul::find($matkul_id);
        $old_img = $matkul->image;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $img_req = $request->file('image');
            $image = time() . '_' . $img_req->getClientOriginalName();
            Storage::putFileAs('public/images', $img_req, $image);
            $matkul->image = $image;

            if ($old_img != $image) {
                Storage::delete('public/images/' . $old_img);
            }
        }

        $matkul->dosen_id = $request->dosen_id;
        $matkul->nama_matkul = $request->nama_matkul;
        $matkul->semester_id = $request->semester_id;
        $matkul->deskripsi = $request->deskripsi;
        $matkul->status = $request->status;

        $matkul->save();

        return back()->with('success', 'Berhasil mengupdate mata kuliah.');
    }


    protected function hapus_matkul($matkul_id)
    {
        $matkul = Matkul::find($matkul_id);

        Storage::delete('public/images' . $matkul->image);

        $matkul->delete();

        return back()->with('warning', 'Mata kuliah telah dihapus.');
    }
}
