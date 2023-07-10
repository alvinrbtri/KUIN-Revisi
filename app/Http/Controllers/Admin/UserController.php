<?php

namespace App\Http\Controllers\Admin;

use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // handle user view
    protected function showDosen()
    {
        $data = [
            'title'     => 'Mengelola Dosen',
            'id_page'   => 2,
            'users'     => User::where('level', '=', 'dosen')->get(),
        ];

        return view('admin.users.dosen', $data);
    }

    protected function showMahasiswa()
    {
        $data = [
            'title'     => 'Mengelola Mahasiswa',
            'id_page'   => 3,
            'users'     => User::with(['semester', 'kelas'])->where('level', '=', 'mahasiswa')->get(),
            'semesters' => Semester::all(),
            'kelas'     => Kelas::all(),
        ];

        return view('admin.users.mahasiswa', $data);
    }

    // handle create user
    protected function create_user(Request $request)
    {

        if ($request->level == 'dosen') {
            $semester = null;
            $tempat_lahir = null;
            $tanggal_lahir = null;
            $nip = $request->nip;
            $nim = null;
        } elseif ($request->level == 'mahasiswa') {
            $semester = $request->semester_id;
            $tempat_lahir = $request->tempat_lahir;
            $tanggal_lahir = $request->tanggal_lahir;
            $nim = $request->nim;
            $nip = null;
        }

        User::insert([
            'username'          => $request->username,
            'password'          => Hash::make('kuin#' . $request->username),
            'email'             => $request->email,
            'level'             => $request->level,
            'nama'              => $request->nama,
            'nip'               => $nip,
            'nim'               => $nim,
            'kelas_id'          => $request->kelas_id,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tempat_lahir'      => $tempat_lahir,
            'tanggal_lahir'     => $tanggal_lahir,
            'image'             => 'default.png',
            'no_telepon'        => $request->no_telepon,
            'provinsi'          => $request->provinsi,
            'kabupaten_kota'    => $request->kabupaten_kota,
            'kecamatan'         => $request->kecamatan,
            'desa_kelurahan'    => $request->desa_kelurahan,
            'alamat'            => $request->alamat,
            'semester_id'       => $semester,
            'status'            => 'terverifikasi'
        ]);

        return back()->with('success', 'Berhasil membuat user');
    }

    // handle hapus user
    protected function hapus_user($user_id)
    {
        $user = User::find($user_id);
        $user->delete();

        return back()->with('warning', 'User telah dihapus');
    }

    // handle update user
    protected function update_user($user_id, Request $request)
    {
        $user = User::find($user_id);
        $user_old = $user->username;

        if ($user_old != $request->username) {
            $user->username      = $request->username;
            $user->password      = 'kuin#' . $request->username;
        }
        $user->email             = $request->email;
        $user->level             = $request->level;
        $user->nama              = $request->nama;
        $user->nip              = $request->nip;
        $user->nim              = $request->nim;
        $user->kelas_id          = $request->kelas_id;
        $user->jenis_kelamin     = $request->jenis_kelamin;
        $user->tempat_lahir      = $request->tempat_lahir;
        $user->image             = 'default.png';
        $user->no_telepon        = $request->no_telepon;
        $user->provinsi          = $request->provinsi;
        $user->kabupaten_kota    = $request->kabupaten_kota;
        $user->kecamatan         = $request->kecamatan;
        $user->desa_kelurahan    = $request->desa_kelurahan;
        $user->alamat            = $request->alamat;
        $user->semester_id       = $request->semester_id;
        $user->status            = 'terverifikasi';

        $user->save();

        return back()->with('info', 'User berhasil diupdate');
    }
}
