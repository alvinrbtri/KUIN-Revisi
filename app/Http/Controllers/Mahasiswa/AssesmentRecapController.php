<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AttemptQuiz;
use Illuminate\Http\Request;

class AssesmentRecapController extends Controller
{
    protected function showAssesmentRecap()
    {
        $data = [
            'title' => 'Assesment Recap',
            'id_page' => 15,
            'attempt' => AttemptQuiz::where('user_id', auth()->user()->user_id)->get(),
        ];

        return view('mahasiswa.assesment_rekap', $data);
    }
}
