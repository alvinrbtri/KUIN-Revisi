<?php

namespace App\Http\Controllers\Global;

use App\Http\Controllers\Controller;
use App\Models\Matkul;
use App\Models\Modul;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // handle view dashboard
    protected function showDashboard()
    {

        $access_modul = auth()->user();

        if ($access_modul->level == 'admin') {
            $modul = false;
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
            'title'             => 'Dashboard',
            'id_page'           => 1,
            'users'             => User::all(),
            'modul'             => $modul,
            'jumlah_modul'      => Modul::with(['kelas', 'matkul'])->whereHas('matkul', function ($query) {
                $query->where('semester_id', auth()->user()->semester_id)->where('dosen_id', auth()->user()->user_id)->where('status', 'aktif');
            })->count(),
            'jumlah_mahasiswa'  => User::where('level', 'mahasiswa')->count(),
            'jumlah_dosen'      => User::where('level', 'dosen')->count(),
            'jumlah_matkul'     => Matkul::where('status', 'aktif')->count(),

        ];

        return view('global.dashboard', $data);
    }
}
