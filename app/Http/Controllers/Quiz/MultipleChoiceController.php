<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\AnswerMc;
use App\Models\AttemptQuiz;
use App\Models\OptionMc;
use App\Models\QuestionMc;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MultipleChoiceController extends Controller
{
    protected function index()
    {
        $data = [
            'title'             => 'Multiple Choice',
            'id_page'           => 11,
            'multiple_choice'   => Quiz::with('modul')->where('quiz_type', 'Multiple Choice')->get(),
        ];

        return view('quiz.multiple_choice', $data);
    }

    protected function attempt_quiz(Request $request, $quiz_id, $user_id)
    {
        $quiz = Quiz::find($quiz_id);

        $data = [
            'title' => $quiz->quiz_name,
            'quiz'  => Quiz::find($quiz_id),
            'multiple_choice' => QuestionMc::with('quiz')->where('quiz_id', $quiz_id)->inRandomOrder()->get(),
            'options'   => DB::table('option_mc')->get(),
            'mahasiswa'  => User::where('user_id', $user_id)->first(),
        ];

        if (isset($_GET['start_quiz'])) {
            DB::table('attempt_quiz')->insert([
                'user_id'   => $request->user_id,
                'quiz_id'   => $request->quiz_id
            ]);

            return redirect('/multiple_choice');
        }

        return view('quiz.multiple_choice.questions', $data);
    }

    protected function save_answer(Request $request, $quiz_id)
    {
        $mc = QuestionMc::where('quiz_id', $quiz_id)->get();

        foreach ($mc as $item) {
            $answer_model = new AnswerMc();
            $answer_model->user_id = $request->input('user_id-' . $item->question_id);
            $answer_model->quiz_id = $quiz_id;

            if ($request->input('answer-' . $item->question_id) == $request->input('key_answer-' . $item->question_id)) {
                $answer_model->score = $request->input('question_poin-' . $item->question_id);
            } else {
                $answer_model->score = 0;
            }
            $answer_model->answer = $request->input('answer-' . $item->question_id);

            $answer_model->save();
        }

        return redirect('/results/' . $quiz_id . '/' . auth()->user()->user_id)->with('success', 'Telah menyelesaikan kuis!');
    }

    protected function master($quiz_id)
    {
        $data = [
            'title'     => 'Master',
            'quiz'      => Quiz::find($quiz_id),
            'questions' => QuestionMc::with('quiz')->where('quiz_id', $quiz_id)->get(),
        ];

        return view('quiz.multiple_choice.master', $data);
    }

    protected function showCreateQuestion($quiz_id)
    {
        $data = [
            'title'     => 'Create Question Multiple Choice',
            'quiz'      => Quiz::find($quiz_id)
        ];

        return view('quiz.multiple_choice.create_question', $data);
    }

    protected function detail_mc($quiz_id, $question_id)
    {
        $data = [
            'title'     => 'Detail Question',
            'quiz'      => Quiz::find($quiz_id),
            'question'  => QuestionMc::where('question_id', $question_id)->first(),
            'option'    => OptionMc::where('question_id', $question_id)->first(),
        ];

        return view('quiz.multiple_choice.detail', $data);
    }


    protected function create_mc(Request $request)
    {
        $this->validate($request, [
            'question'          => 'required',
            'opsi1'             => 'required',
            'opsi2'             => 'required',
            'opsi3'             => 'required',
            'opsi4'             => 'required',
            'opsi5'             => 'required',
            'key_answer'        => 'required',
            'question_poin'     => 'required'
        ]);

        $mc = new QuestionMc();
        $mc->quiz_id = $request->quiz_id;
        $mc->question =  $request->question;

        if ($request->hasFile('question_image')) {
            $mc_request = $request->file('question_image');
            $question_image = time() . '_' . $mc_request->getClientOriginalName();

            Storage::putFileAs('public/images/quiz', $mc_request, $question_image);

            $mc->question_image = $question_image;
        }

        $mc->question_poin = $request->question_poin;
        $mc->save();

        $mcId = $mc->question_id;

        $option = new OptionMc();

        $option->question_id = $mcId;
        $option->opsi1 = $request->opsi1;
        $option->opsi2 = $request->opsi2;
        $option->opsi3 = $request->opsi3;
        $option->opsi4 = $request->opsi4;
        $option->opsi5 = $request->opsi5;
        $option->key_answer = $request->key_answer;

        $option->save();

        if (isset($_POST['new_question'])) {
            return back();
        } elseif (isset($_POST['save'])) {
            return redirect('/multiple_choice/master/' . $request->quiz_id);
        }
    }

    protected function hapus_mc($question_id, Request $request)
    {
        $question = QuestionMc::find($question_id);

        Storage::delete('public/images/quiz/' . $question->question_image);

        $question->delete();

        return redirect('/multiple_choice/master/' . $request->quiz_id);
    }

    protected function update_mc(Request $request, $question_id)
    {
        $this->validate($request, [
            'question'          => 'required',
            'opsi1'             => 'required',
            'opsi2'             => 'required',
            'opsi3'             => 'required',
            'opsi4'             => 'required',
            'opsi5'             => 'required',
            'key_answer'        => 'required',
            'question_poin'     => 'required'
        ]);

        $mc = QuestionMc::find($question_id);
        $option = OptionMc::where('question_id', $question_id)->first();

        $mc->question =  $request->question;
        $mc->question_poin = $request->question_poin;
        $old_img = $mc->question_image;

        if ($request->hasFile('question_image') && $request->image == true) {
            $mc_request = $request->file('question_image');
            $mc_image = time() . '_' . $mc_request->getClientOriginalName();

            Storage::putFileAs('public/images/quiz/', $mc_request, $mc_image);

            $mc->question_image = $mc_image;

            if ($old_img != $mc_image) {
                Storage::delete('public/images/quiz/' . $old_img);
            }
        }

        $mc->save();

        $option->opsi1 = $request->opsi1;
        $option->opsi2 = $request->opsi2;
        $option->opsi3 = $request->opsi3;
        $option->opsi4 = $request->opsi4;
        $option->opsi5 = $request->opsi5;
        $option->key_answer = $request->key_answer;

        $option->save();

        return redirect('/multiple_choice/master/' . $request->quiz_id);
    }

    protected function review_mc($quiz_id)
    {
        $data = [
            'title'         => 'Review Multiple Choice',
            'quiz'          => Quiz::find($quiz_id),
            'attempt'       => AttemptQuiz::where('quiz_id', $quiz_id)->get(),
        ];

        // dd($data['answers']);
        return view('quiz.multiple_choice.review', $data);
    }
}
