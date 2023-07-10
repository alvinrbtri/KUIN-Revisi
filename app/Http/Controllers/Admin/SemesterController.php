<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{

    // handle semester view
    protected function showSemester()
    {
        $data = [
            'title'     => 'Semester',
            'id_page'   => 7,
            'semester'  => Semester::orderBy('semester_tipe', 'ASC')->get(),
        ];

        return view('admin.semester', $data);
    }

    // handle create data semester
    protected function create_semester(Request $request)
    {
        $semester = new Semester();
        $check_data = Semester::where('semester_tipe', '=', $request->semester_tipe)->first();

        if ($check_data == false) {
            $semester->semester_tipe = $request->semester_tipe;
            $semester->save();

            return back()->with('success', 'Berhasil menambahkan data semester.');
        }


        return back()->with('error', 'Tipe Data semester yang anda masukkan sudah digunakan.');
    }

    // handle delete data semester
    protected function hapus_semester($semester_id)
    {
        DB::table('semester')->where('semester_id', $semester_id)->delete();

        return back()->with('warning', 'Data semester telah dihapus.');
    }

    // handle update data semester
    protected function update_semester($semester_id, Request $request)
    {
        $semester = Semester::find($semester_id);
        $check_data = Semester::where('semester_tipe', '=', $request->semester_tipe)->first();

        if ($check_data == false) {
            $semester->semester_tipe = $request->semester_tipe;
            $semester->save();

            return back()->with('info', 'Berhasil mengupdate data semester.');
        }

        return back()->with('error', 'Tipe Data semester yang anda masukkan sudah digunakan.');
    }
}
