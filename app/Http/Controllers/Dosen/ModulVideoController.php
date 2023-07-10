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

class ModulVideoController extends Controller
{
    // handle modul video view
    // protected function showModulVideo()
    // {

    //     $access_modul_video = auth()->user();

    //     if ($access_modul_video->level == 'admin') {
    //         $modul_video = ModulVideo::with(['kelas', 'matkul'])->whereHas('matkul', function ($query) {
    //             $query->where('status', 'aktif');
    //         })->get();
    //     } elseif ($access_modul_video->level == 'mahasiswa') {
    //         $modul_video = ModulVideo::with(['kelas', 'matkul'])->whereHas('matkul', function ($query) {
    //             $query->where('semester_id', auth()->user()->semester_id)->where('status', 'aktif');
    //         })->where('kelas_id', auth()->user()->kelas_id)->get();
    //     } elseif ($access_modul_video->level == 'dosen') {
    //         $modul_video = ModulVideo::with(['kelas', 'matkul'])->whereHas('matkul', function ($query) {
    //             $query->where('dosen_id', auth()->user()->user_id)->where('status', 'aktif');
    //         })->get();
    //     }

    //     $data = [
    //         'nama_video'     => 'Modul Video',
    //         'id_page'   => 17,
    //         'modul'    => Modul::where('dosen_id', auth()->user()->user_id)->get(),
    //         'modul_video'     => $modul_video,
    //         'kelas'     => Kelas::all(),
    //     ];

    //     return view('dosen.modul_video', $data);
    // }

    public function showModulVideo($id)
    {

        $access_modul_video = auth()->user();

    
        $data = [
            'title'     => 'Modul Video',
            'id_page'   => 17,
            // 'modul'    => Modul::where('dosen_id', auth()->user()->user_id)->find($id),
            'modul'    => Modul::find($id),
            'modul_video' => ModulVideo::where('modul_id', $id)->orderByDesc('created_at')->get(),
            'kelas'     => Kelas::all(),
        ];

        // return view('dosen.modul_video', $data);
        return view('dosen.modul_video_id', $data);
    }

    // protected function detail_modul_video($modul_video_id)
    // {
    //     $modul_video = ModulVideo::find($modul_video_id);
    //     $data = [
    //         'nama_video'     => $modul_video->nama_modul_video,
    //         'id_page'   => 9,
    //         'modul_video'     => $modul_video
    //     ];

    //     return view('global.detail_modul_video', $data);
    // }

    // handle create data modul/materi
    // protected function create_modul_video(Request $request)
    // {
    //     $modul_video = new ModulVideo();
    //     $file_modul_videos = $request->file('file_modul_video');
    
    //     foreach ($file_modul_videos as $file_modul_video) {
    //         $modul_video = new ModulVideo();
    //         $modul_video_name = time() . '_' . $file_modul_video->getClientOriginalName();
    
    //         $file_modul_video->storeAs('public/videos', $modul_video_name);
    
    //         $modul_video->matkul_id = $request->matkul_id;
    //         $modul_video->nama_modul_video = $file_modul_video->getClientOriginalName();
    //         $modul_video->kelas_id = $request->kelas_id;
    //         $modul_video->file_modul_video = $modul_video_name;
    //         $modul_video->deskripsi = $request->deskripsi;
    
    //         $modul_video->save();
    //     }
    
    //     return back()->with('success', 'Berhasil menambahkan modul.');
    // }

    protected function create_modul_video($id, Request $request)
    {
        $request->validate([
            'modul_id' => 'nullable',
            'nama_video' => 'required',
            'file_modul' => 'nullable|mimes:mp4',
            'deskripsi' => 'required',
        ]);
    
        $modul_video = new ModulVideo();
        $modul_video->modul_id = $request->modul_id;
        $modul_video->nama_video = $request->nama_video;
        $modul_video->deskripsi = $request->deskripsi;
    
        if ($request->hasFile('file_modul')) {
            $file_modul = $request->file_modul;
            $file_name = time() . '_' . $file_modul->getClientOriginalName();
            $file_path = 'public/videos/' . $file_name;
            $file_modul->storeAs('public/videos', $file_name);
            $modul_video->file_modul = $file_path;
        }
        
    
        $modul_video->save();
    
        return back()->with('success', 'Berhasil menambahkan modul.');
    }
    


    // handle update modul_video
    
    protected function UpdateModulVideo(Request $request, $modul_video_id)
    {
        $modul_video = ModulVideo::findOrFail($modul_video_id);

        $request->validate([
            'nama_video' => 'required',
            'file_modul' => 'nullable|mimes:mp4',
            'deskripsi' => 'required',
        ]);

        // Hapus file video lama jika ada
        if ($modul_video->file_modul) {
            Storage::delete($modul_video->file_modul);
        }

        $modul_video->nama_video = $request->nama_video;
        $modul_video->deskripsi = $request->deskripsi;

        if ($request->hasFile('file_modul')) {
            $file_modul = $request->file_modul;
            $file_name = time() . '_' . $file_modul->getClientOriginalName();
            $file_path = 'public/videos/' . $file_name;
            $file_modul->storeAs('public/videos', $file_name);
            $modul_video->file_modul = $file_path;
        }

        $modul_video->save();

        return back()->with('warning', 'Modul video berhasil diperbarui.');
    }

    // handle delete modul
    // protected function hapus_modul_video($modul_video_id)
    // {
    //     DB::table('modul_video')->where('modul_video_id', $modul_video_id)->delete();

    //     return back()->with('warning', 'Modul Video telah dihapus.');
    // }
    protected function delete_modul_video($id)
{
    $modul_video = ModulVideo::find($id);

    if (!$modul_video) {
        return back()->with('error', 'Modul video tidak ditemukan.');
    }

    // Hapus file video jika ada
    if ($modul_video->file_modul) {
        Storage::delete($modul_video->file_modul);
    }

    $modul_video->delete();

    return back()->with('success', 'Modul video berhasil dihapus.');
}
}