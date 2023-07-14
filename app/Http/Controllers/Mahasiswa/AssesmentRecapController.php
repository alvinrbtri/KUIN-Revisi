<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\AttemptQuiz;
use Illuminate\Http\Request;

class AssesmentRecapController extends Controller
{
    protected function showAssesmentRecap()
    {
        $user = auth()->user();

        if ($user->level === 'admin' || $user->level === 'dosen') {
            $attempt = AttemptQuiz::all();
        } else {
            $attempt = AttemptQuiz::where('user_id', $user->user_id)->get();
        }

        $data = [
            'title' => 'Assesment Recap',
            'id_page' => 15,
            'attempt' => $attempt,
        ];

        return view('mahasiswa.assesment_rekap', $data);
    }
}
