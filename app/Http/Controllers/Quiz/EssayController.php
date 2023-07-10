<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\AnswerEssay;
use App\Models\AttemptQuiz;
use App\Models\Essay;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EssayController extends Controller
{
    protected function index()
    {
        $data = [
            'title' => 'Essay',
            'id_page' => 12,
            'essay' => Quiz::with('modul')->where('quiz_type', 'Essay')->get(),
        ];

        return view('quiz.essay', $data);
    }

    protected function attempt_quiz(Request $request, $quiz_id, $user_id)
    {
        $quiz = Quiz::find($quiz_id);

        $data = [
            'title' => $quiz->quiz_name,
            'quiz'  => Quiz::find($quiz_id),
            'essay' => Essay::with('quiz')->where('quiz_id', $quiz_id)->inRandomOrder()->get(),
            'mahasiswa'  => User::where('user_id', $user_id)->first(),
        ];

        if (isset($_GET['start_quiz'])) {
            DB::table('attempt_quiz')->insert([
                'user_id'   => $request->user_id,
                'quiz_id'   => $request->quiz_id
            ]);

            return redirect('/essay');
        }

        return view('quiz.essay.questions', $data);
    }

    protected function save_answer(Request $request, $quiz_id)
    {
        $essay = Essay::where('quiz_id', $quiz_id)->get();
        foreach ($essay as $item) {
            $answer_model = new AnswerEssay();
            $answer_model->user_id = $request->input('user_id-' . $item->essay_id);
            $answer_model->quiz_id = $request->input('quiz_id-' . $item->essay_id);
            $answer_model->essay_id = $request->input('essay_id-' . $item->essay_id);
            $answer_model->answer = $request->input('answer-' . $item->essay_id);

            $answer_model->save();
        }

        return redirect('/results/' . $quiz_id . '/' . auth()->user()->user_id)->with('success', 'Telah menyelesaikan kuis!');
    }


    protected function master($quiz_id)
    {
        $data = [
            'title'     => 'Master',
            'quiz'      => Quiz::find($quiz_id),
            'essay'     => Essay::with('quiz')->where('quiz_id', $quiz_id)->get()
        ];

        return view('quiz.essay.master', $data);
        // dd($data['essay']);
    }

    protected function showCreateEssay($quiz_id)
    {
        $data = [
            'title'     => 'Create Essay',
            'quiz'      => Quiz::find($quiz_id)
        ];

        return view('quiz.essay.create_essay', $data);
    }

    protected function create_essay(Request $request)
    {
        $this->validate($request, [
            'essay_question'    => 'required',
            'essay_poin'        => 'required'
        ]);

        $essay = new Essay();
        $essay->quiz_id = $request->quiz_id;
        $essay->essay_question =  $request->essay_question;
        if ($request->hasFile('essay_image')) {
            $essay_request = $request->file('essay_image');
            $essay_image = time() . '_' . $essay_request->getClientOriginalName();

            Storage::putFileAs('public/images/quiz', $essay_request, $essay_image);

            $essay->essay_image = $essay_image;
        }

        $essay->essay_poin = $request->essay_poin;

        $essay->save();

        if (isset($_POST['new_question'])) {
            return back();
        } elseif (isset($_POST['save'])) {
            return redirect('/essay/master/' . $request->quiz_id);
        }
    }

    protected function detail_essay($quiz_id, $essay_id)
    {
        $data = [
            'title'     => 'Detail Question',
            'quiz'      => Quiz::find($quiz_id),
            'essay'     => Essay::find($essay_id),
        ];

        return view('quiz.essay.detail', $data);
    }

    protected function hapus_essay($essay_id, Request $request)
    {
        $essay = Essay::find($essay_id);

        Storage::delete('public/images/quiz/' . $essay->essay_image);

        $essay->delete();

        return redirect('/essay/master/' . $request->quiz_id);
    }

    protected function update_essay(Request $request, $essay_id)
    {
        $this->validate($request, [
            'essay_question'    => 'required',
            'essay_poin'        => 'required'
        ]);

        $essay = Essay::find($essay_id);
        $old_img = $essay->essay_image;

        $essay->essay_question = $request->essay_question;
        if ($request->hasFile('essay_image') && $request->essay_image == true) {
            $essay_request = $request->file('essay_image');
            $essay_image = time() . '_' . $essay_request->getClientOriginalName();

            Storage::putFileAs('public/images/quiz/', $essay_request, $essay_image);

            $essay->essay_image = $essay_image;

            if ($old_img != $essay_image) {
                Storage::delete('public/images/quiz/' . $old_img);
            }
        }

        $essay->essay_poin = $request->essay_poin;

        $essay->save();

        return redirect('/essay/master/' . $request->quiz_id);
    }

    protected function review_essay($quiz_id)
    {
        $data = [
            'title'         => 'Review Essay',
            'quiz'          => Quiz::find($quiz_id),
            'attempt'       => AttemptQuiz::where('quiz_id', $quiz_id)->get(),
        ];

        // dd($data['answers']);
        return view('quiz.essay.review', $data);
    }

    protected function detail_review($quiz_id, $user_id)
    {
        $user = User::where('user_id', $user_id)->first();
        $essay = Essay::where('quiz_id', $quiz_id)->get();
        $answer = AnswerEssay::where('quiz_id', $quiz_id)->get();
        $data = [
            'title'     => $user->nama,
            'essay'     => $essay,
            'quiz'      => Quiz::find($quiz_id),
            'answers'   => $answer,
        ];

        return view('quiz.essay.detail_review', $data);
    }

    protected function pratinjau($quiz_id, Request $request)
    {
        $essay = Essay::where('quiz_id', $quiz_id)->get();

        foreach ($essay as $item) {
            $answer_essay = AnswerEssay::where('answer_id', $request->input('answer_id-' . $item->essay_id))->first();
            $answer_essay->score = $request->input('poin-' . $item->essay_id);

            $answer_essay->save();
        }

        return redirect('/essay/review/' . $quiz_id);
    }
}
