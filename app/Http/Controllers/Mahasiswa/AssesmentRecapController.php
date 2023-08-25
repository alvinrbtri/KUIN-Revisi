<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\AnswerMc;
use App\Models\AnswerEssay;
use App\Models\AttemptQuiz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AnswerDraggable;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AssesmentRecapExportHandler;


class AssesmentRecapController extends Controller
{
    protected function showAssesmentRecap()
    {
        $user = auth()->user();
        $attempt = null;
        $total_skor = 0;

        if ($user->level === 'admin' || $user->level === 'dosen') {
            // Jika admin atau dosen, ambil semua data AttemptQuiz
            $attempt = AttemptQuiz::all();

            // Inisialisasi total skor untuk admin atau dosen
            $total_skor = 0;

            // Iterasi melalui setiap AttemptQuiz
            foreach ($attempt as $item) {
                // Mengambil total skor untuk setiap quiz_id berdasarkan user_id_attempt
                $quiz_id = $item->quiz_id;
                $user_id_attempt = $item->user_id;
                $skor_per_quiz = AnswerMc::where('user_id', $user_id_attempt)
                    ->where('quiz_id', $quiz_id)
                    ->sum('score');

                // Menambahkan skor dari quiz ini ke total skor admin atau dosen
                $total_skor += $skor_per_quiz;
            }
        } else {
            // Jika bukan admin atau dosen, ambil data AttemptQuiz berdasarkan user_id
            $attempt = AttemptQuiz::where('user_id', $user->user_id)->get();
            $attempt_essay = AttemptQuiz::where('user_id', $user->user_id)->get();
            $attempt_draggable = AttemptQuiz::where('user_id', $user->user_id)->get();

            // Inisialisasi total skor untuk pengguna saat ini
            $total_skor = 0;

            // Iterasi melalui setiap AttemptQuiz pengguna
            foreach ($attempt as $item) {
                // Mengambil total skor untuk setiap quiz_id berdasarkan user_id
                $quiz_id = $item->quiz_id;
                $skor_per_quiz = AnswerMc::where('user_id', $user->user_id)
                    ->where('quiz_id', $quiz_id)
                    ->sum('score');

                // Menambahkan skor dari quiz ini ke total skor pengguna
                $total_skor += $skor_per_quiz;
            }

            foreach ($attempt_essay as $answer_essay) {
                $essay = AnswerEssay::where('user_id', $user->user_id)
                    ->where('quiz_id', $answer_essay->quiz_id)
                    ->first();

                if ($essay) {
                    $total_skor += $essay->score;
                }
            }

            foreach ($attempt_draggable as $answer_draggable) {
                $draggable = AnswerDraggable::where('user_id', $user->user_id)
                    ->where('quiz_id', $answer_draggable->quiz_id)
                    ->first();

                if ($draggable) {
                    $total_skor += $draggable->score;
                }
            }
        }

        $data = [
            'title' => 'Assesment Recap',
            'id_page' => 15,
            'attempt' => $attempt,
            // 'attempt_essay' => $attempt_essay,
            'total_skor' => $total_skor,
            'user' => $user,
        ];

        return view('mahasiswa.assesment_rekap', $data);
    }

    public function exportToCsv()
    {
        $user = auth()->user();
        $attempt = $this->getAttemptData($user);

        // Generate the file using AssesmentRecapExportHandler
        $export = new AssesmentRecapExportHandler($attempt);
        return Excel::download($export, 'assesment-recap.csv');
    }

    protected function getAttemptData($user)
    {
        // Menggunakan logika yang sama seperti method showAssesmentRecap
        $attempt = null;
        $total_skor = 0;

        // Get selected class and quiz
        $selectedClass = request('class');
        $selectedQuiz = request('quiz');
        
        if ($user->level == 'admin' || $user->level == 'dosen') {
            // Jika admin atau dosen, ambil semua data AttemptQuiz
            $attempt = AttemptQuiz::with('user', 'quiz')->get();
        } else {
            // Jika bukan admin atau dosen, ambil data AttemptQuiz berdasarkan user_id
            $attempt = AttemptQuiz::where('user_id', $user->user_id)->with('user', 'quiz')->get();
        }
        
        if ($selectedClass != '') {
            $attempt = $attempt->filter(function ($attempt) use ($selectedClass) {
                return $attempt->user->kelas_id == $selectedClass;
            });
        }
        
        if ($selectedQuiz != '') {
            $attempt = $attempt->filter(function ($attempt) use ($selectedQuiz) {
                return $attempt->quiz->quiz_id == $selectedQuiz;
            });
        }        

        // Kembali ke data
        return $attempt;
    }


}
