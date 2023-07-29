<?php

namespace App\Http\Controllers\Quiz;

use App\Models\Quiz;
use App\Models\Essay;
use App\Models\Modul;
use App\Models\AnswerMc;
use App\Models\OptionMc;
use App\Models\Draggable;
use App\Models\QuestionMc;
use App\Models\AnswerEssay;
use App\Models\AttemptQuiz;
use Illuminate\Http\Request;
use App\Models\AnswerDraggable;
use App\Models\DraggableOption;
use App\Http\Controllers\Controller;


class QuizManagementController extends Controller
{
    protected function showQuiz()
    {
        $data = [
            'title' => 'Quiz',
            'id_page' => 10,
            'moduls' => Modul::all(),
            'quizzes' => Quiz::all(),
        ];

        return view('quiz.rekap_quiz', $data);
    }

    protected function create_quiz(Request $request)
    {
        $quiz = new Quiz();
        $quiz->quiz_name = $request->quiz_name;
        $quiz->modul_id = $request->modul_id;
        $quiz->quiz_type = $request->quiz_type;
        $quiz->quiz_date = $request->quiz_date;
        $quiz->jam = $request->jam;
        $quiz->menit = $request->menit;
        $quiz->detik = $request->detik;

        $quiz->save();

        return back()->with('success', 'Berhasil membuat kuis');
    }

    protected function hapus_quiz($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $quiz->delete();

        return back()->with('warning', 'Quiz telah dihapus');
    }

    protected function update_quiz($quiz_id, Request $request)
    {
        $quiz = Quiz::find($quiz_id);
        $quiz->quiz_name = $request->quiz_name;
        $quiz->modul_id = $request->modul_id;
        $quiz->quiz_date = $request->quiz_date;
        $quiz->jam = $request->jam;
        $quiz->menit = $request->menit;
        $quiz->detik = $request->detik;

        $quiz->save();

        return back()->with('info', 'Berhasil memperbarui quiz');
    }

    protected function confirm($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);

        if ($quiz->quiz_type == 'Essay') {
            $questions = Essay::count();
        } elseif ($quiz->quiz_type == 'Draggable') {
            $questions = Draggable::count();
        } else {
            $questions = QuestionMc::count();
        }

        $data = [
            'title'     => $quiz->quiz_name,
            'quiz'      => $quiz,
            'attempt'   => AttemptQuiz::where('quiz_id', $quiz_id)->where('user_id', auth()->user()->user_id)->count(),
            'questions' => $questions
        ];

        return view('quiz.confirm', $data);
    }

    // protected function result_quiz($quiz_id, $user_id)
    // {
    //     $quiz = Quiz::findOrFail($quiz_id);
    //     $quiz_type = $quiz->quiz_type;

    //     if ($quiz_type == 'Multiple Choice') {
    //         $sum_poin = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
    //     } elseif ($quiz_type == 'Draggable') {
    //         $sum_poin = AnswerDraggable::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
    //     } else {
    //         $sum_poin = AnswerEssay::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
    //     }

    //     $data = [
    //         'title'     => 'Result Quiz',
    //         'quiz'      => $quiz,
    //         'scores'    => $sum_poin,
    //     ];

    //     return view('quiz.results', $data);
    // }
    protected function result_quiz($quiz_id, $user_id)
    {
        $user = auth()->user();

        // Cek apakah pengguna adalah admin atau dosen
        if ($user->level === 'admin' || $user->level === 'dosen') {
            // Jika admin atau dosen, dapatkan data quiz
            $quiz = Quiz::findOrFail($quiz_id);
            $quiz_type = $quiz->quiz_type;

            // Lakukan penghitungan skor berdasarkan tipe kuis
            if ($quiz_type == 'Multiple Choice') {
                $sum_poin = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
            } elseif ($quiz_type == 'Draggable') {
                $sum_poin = AnswerDraggable::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
            } else {
                $sum_poin = AnswerEssay::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
            }

            $user_asli = AnswerMc::where('user_id', $user_id)->get();

            $data_abc = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->get();

            $question_answer = OptionMc::get();
            $soal_asli = QuestionMc::get();

            // Jika bukan admin atau dosen, ambil data AttemptQuiz berdasarkan user_id
            $attempt = AttemptQuiz::all();


            $soal_essay = Essay::get();
            $jawaban_essay = AnswerEssay::get();


            $drag_option = DraggableOption::get();
            $drag_answer = AnswerDraggable::get();
            $drag_utama = Draggable::get();


            $data = [
                'title'     => 'Result Quiz',
                'quiz'      => $quiz,
                'scores'    => $sum_poin,
                'attempt' => $attempt,
                'user' => $user,
                'data_abc' => $data_abc,
                'data_abc2' => $data_abc,
                'question_answer' => $question_answer,
                'soal_asli' => $soal_asli,
                'soal_essay' => $soal_essay,
                'jawaban_essay' => $jawaban_essay,
                'user_asli' => $user_asli,
                'drag_option' => $drag_option,
                'drag_answer' => $drag_answer,
                'drag_utama' => $drag_utama,


            ];

            return view('quiz.results', $data);
        } else {
            // Jika bukan admin atau dosen, pastikan pengguna hanya bisa mengakses hasil kuis miliknya sendiri
            $auth_user_id = $user->user_id;

            if ($auth_user_id == $user_id) {
                $quiz = Quiz::findOrFail($quiz_id);
                $quiz_type = $quiz->quiz_type;

                // Lakukan penghitungan skor berdasarkan tipe kuis
                if ($quiz_type == 'Multiple Choice') {
                    $sum_poin = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
                } elseif ($quiz_type == 'Draggable') {
                    $sum_poin = AnswerDraggable::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
                } else {
                    $sum_poin = AnswerEssay::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
                }

                $user_asli = AnswerMc::where('user_id', $user_id)->get();

                $data_abc = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->get();
                $data_abc2 = AnswerMc::get();
                $question_answer = OptionMc::get();
                $soal_asli = QuestionMc::get();


                // Jika bukan admin atau dosen, ambil data AttemptQuiz berdasarkan user_id
                $attempt = AttemptQuiz::where('user_id', $user->user_id)->get();

                $soal_essay = Essay::get();
                $jawaban_essay = AnswerEssay::get();

                $drag_option = DraggableOption::get();
                $drag_answer = AnswerDraggable::get();
                $drag_utama = Draggable::get();


                $data = [
                    'title'     => 'Result Quiz',
                    'quiz'      => $quiz,
                    'scores'    => $sum_poin,
                    'attempt' => $attempt,
                    'user' => $user,
                    'data_abc' => $data_abc,
                    'data_abc2' => $data_abc,
                    'question_answer' => $question_answer,
                    'soal_asli' => $soal_asli,
                    'soal_essay' => $soal_essay,
                    'jawaban_essay' => $jawaban_essay,
                    'user_asli' => $user_asli,
                    'drag_option' => $drag_option,
                    'drag_answer' => $drag_answer,
                    'drag_utama' => $drag_utama,

                ];

                return view('quiz.results', $data);
            } else {
                // Jika pengguna mencoba mengakses hasil kuis milik pengguna lain, berikan pesan akses ditolak atau redirect ke halaman lain
                return back()->with('error', 'Akses ditolak! Anda hanya dapat mengakses hasil kuis Anda sendiri.');
            }
        }
    }
    
    
//     protected function result_quiz($quiz_id, $user_id)
// {
//     $user = auth()->user();

//     // Cek apakah pengguna adalah admin atau dosen
//     if ($user->level === 'admin' || $user->level === 'dosen') {
//         $quiz = Quiz::findOrFail($quiz_id);
//         $quiz_type = $quiz->quiz_type;

//         // Lakukan penghitungan skor berdasarkan tipe kuis
//         if ($quiz_type == 'Multiple Choice') {
//             $sum_poin = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
//         } elseif ($quiz_type == 'Draggable') {
//             $sum_poin = AnswerDraggable::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
//         } else {
//             $sum_poin = AnswerEssay::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
//         }

//         // Ambil data jawaban Multiple Choice berdasarkan user_id
//         $user_asli = AnswerMc::where('user_id', $user_id)->get();

//         // Ambil data jawaban berdasarkan quiz_id dan user_id
//         $data_abc = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->get();

//         // Ambil data opsi jawaban Multiple Choice
//         $question_answer = OptionMc::get();
//         $soal_asli = QuestionMc::get();

//         // Jika bukan admin atau dosen, ambil data AttemptQuiz berdasarkan user_id
//         $attempt = AttemptQuiz::all();

//         // Ambil data jawaban essay
//         $soal_essay = Essay::get();
//         $jawaban_essay = AnswerEssay::get();

//         // Ambil data opsi jawaban Draggable
//         $drag_option = DraggableOption::get();
//         $drag_answer = AnswerDraggable::get();
//         $drag_utama = Draggable::get();

//         $data = [
//             'title' => 'Result Quiz',
//             'quiz' => $quiz,
//             'scores' => $sum_poin,
//             'attempt' => $attempt,
//             'user' => $user,
//             'data_abc' => $data_abc,
//             'data_abc2' => $data_abc,
//             'question_answer' => $question_answer,
//             'soal_asli' => $soal_asli,
//             'soal_essay' => $soal_essay,
//             'jawaban_essay' => $jawaban_essay,
//             'user_asli' => $user_asli,
//             'drag_option' => $drag_option,
//             'drag_answer' => $drag_answer,
//             'drag_utama' => $drag_utama,
//         ];

//         return view('quiz.results', $data);
//     } else {
//         // Kode lain untuk pengguna bukan admin atau dosen
//         // Misalnya untuk mengambil data quiz berdasarkan user_id
//         $quiz = Quiz::where('id', $quiz_id)->where('user_id', $user_id)->first();

//         if (!$quiz) {
//             // Kuis tidak ditemukan atau bukan milik pengguna, maka redirect atau tampilkan pesan error
//             return back()->with('error', 'Kuis tidak ditemukan atau bukan milik Anda.');
//         }

//         // Lakukan penghitungan skor berdasarkan tipe kuis
//         if ($quiz->quiz_type == 'Multiple Choice') {
//             $sum_poin = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
//         } elseif ($quiz->quiz_type == 'Draggable') {
//             $sum_poin = AnswerDraggable::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
//         } else {
//             $sum_poin = AnswerEssay::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
//         }

//         // Ambil data jawaban berdasarkan quiz_id dan user_id
//         $data_abc = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->get();

//         // Ambil data opsi jawaban Multiple Choice
//         $question_answer = OptionMc::get();
//         $soal_asli = QuestionMc::get();

//         // Ambil data jawaban essay
//         $soal_essay = Essay::get();
//         $jawaban_essay = AnswerEssay::get();

//         // Ambil data opsi jawaban Draggable
//         $drag_option = DraggableOption::get();
//         $drag_answer = AnswerDraggable::get();
//         $drag_utama = Draggable::get();

//         $data = [
//             'title' => 'Result Quiz',
//             'quiz' => $quiz,
//             'scores' => $sum_poin,
//             'attempt' => $attempt,
//             'user' => $user,
//                         'data_abc' => $data_abc,
//             'data_abc2' => $data_abc,
//             'question_answer' => $question_answer,
//             'soal_asli' => $soal_asli,
//             'soal_essay' => $soal_essay,
//             'jawaban_essay' => $jawaban_essay,
//             'user_asli' => $user_asli,
//             'drag_option' => $drag_option,
//             'drag_answer' => $drag_answer,
//             'drag_utama' => $drag_utama,
//         ];

//         return view('quiz.results', $data);
//     }
// }


}
