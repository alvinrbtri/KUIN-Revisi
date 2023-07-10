<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\AttemptQuiz;
use Illuminate\Http\Request;

class ClassRecapController extends Controller
{
    protected function showClassRecap()
    {
        $data = [
            'title' => 'Assesment Recap',
            'id_page' => 15,
            'attempt' => AttemptQuiz::all(),
        ];

        return view('dosen.class_recap', $data);
    }
}
