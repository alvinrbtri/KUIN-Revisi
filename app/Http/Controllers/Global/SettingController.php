<?php

namespace App\Http\Controllers\Global;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // handle update profil view
    protected function showEditProfil()
    {
        $data = [
            'title'     => 'Edit Profile',
            'id_page'   => 8,
        ];

        return view('global.update_profil', $data);
    }

    // handle update profil
    protected function handle_update_profil(Request $request)
    {
        if ($request->hasFile('image') && $request->image == true) {
            $imgReq = $request->file('image');
            $user_img = time() . '_' . $imgReq->getClientOriginalName();
            Storage::putFileAs('public/images', $imgReq, $user_img);
            DB::table('users')->where('user_id', auth()->user()->user_id)->update([
                'image' => $user_img
            ]);
        }

        DB::table('users')->where('user_id', auth()->user()->user_id)->update([
            'username'          => $request->username,
            'nama'              => $request->nama,
            'tempat_lahir'      => $request->tempat_lahir,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'no_telepon'        => $request->no_telepon,
            'provinsi'          => $request->provinsi,
            'kabupaten_kota'    => $request->kabupaten_kota,
            'kecamatan'         => $request->kecamatan,
            'desa_kelurahan'    => $request->desa_kelurahan,
            'alamat'            => $request->alamat
        ]);

        return back()->with('success', 'Berhasil mengupdate profil.');
    }
}
