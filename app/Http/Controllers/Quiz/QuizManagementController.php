<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\AnswerDraggable;
use App\Models\AnswerEssay;
use App\Models\AnswerMc;
use App\Models\AttemptQuiz;
use App\Models\Draggable;
use App\Models\Essay;
use App\Models\Modul;
use App\Models\QuestionMc;
use App\Models\Quiz;
use Illuminate\Http\Request;

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

    protected function result_quiz($quiz_id, $user_id)
    {
        $quiz = Quiz::find($quiz_id);
        $quiz_type = $quiz->quiz_type;

        if ($quiz_type == 'Multiple Choice') {
            $sum_poin = AnswerMc::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
        } elseif ($quiz_type == 'Draggable') {
            $sum_poin = AnswerDraggable::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
        } else {
            $sum_poin = AnswerEssay::where('quiz_id', $quiz_id)->where('user_id', $user_id)->sum('score');
        }

        $data = [
            'title'     => 'Result Quiz',
            'quiz'      => $quiz,
            'scores'    => $sum_poin,
        ];

        return view('quiz.results', $data);
    }
}
