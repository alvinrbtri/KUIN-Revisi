<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\AnswerDraggable;
use App\Models\AnswerEssay;
use App\Models\AttemptQuiz;
use App\Models\Draggable;
use App\Models\DraggableOption;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DraggableController extends Controller 
{
    protected function index()
    {
        $data = [
            'title' => 'Draggable',
            'id_page' => 13,
            'draggable' => Quiz::with('modul')->where('quiz_type', 'Draggable')->get(),
        ];

        return view('quiz.draggable', $data);
    }

    protected function attempt_quiz(Request $request, $quiz_id, $user_id)
    {
        $quiz = Quiz::find($quiz_id);

        $data = [
            'title' => $quiz->quiz_name,
            'quiz'  => Quiz::find($quiz_id),
            'draggable' => DB::table('draggable')->where('quiz_id', $quiz_id)->inRandomOrder()->get(),
            'mahasiswa'  => User::where('user_id', $user_id)->first(),
            'options'   => DB::table('draggable_option')->where('quiz_id', $quiz_id)->inRandomOrder()->get(),
        ];

        if (isset($_GET['start_quiz'])) {
            DB::table('attempt_quiz')->insert([
                'user_id'   => $request->user_id,
                'quiz_id'   => $request->quiz_id
            ]);

            return redirect('/draggable');
        }

        return view('quiz.draggable.questions', $data);
    }

    protected function save_answer(Request $request, $quiz_id)
    {
        $draggable = Draggable::where('quiz_id', $quiz_id)->get();

        foreach ($draggable as $item) {
            $answer_model = new AnswerDraggable();
            $answer_model->user_id = $request->input('user_id-' . $item->draggable_id);
            $answer_model->quiz_id = $quiz_id;

            if ($request->input('answer-' . $item->draggable_id) == $request->input('draggable_answer-' . $item->draggable_id)) {
                $answer_model->score = $request->input('draggable_poin-' . $item->draggable_id);
            } else {
                $answer_model->score = 0;
            }

            $answer_model->answer = $request->input('answer-' . $item->draggable_id);

            $answer_model->save();
        }

        return redirect('/results/' . $quiz_id . '/' . auth()->user()->user_id)->with('success', 'Telah menyelesaikan kuis!');
    }

    protected function master($quiz_id)
    {
        $data = [
            'title'     => 'Master',
            'quiz'      => Quiz::find($quiz_id),
            'draggable' => Draggable::with('quiz')->where('quiz_id', $quiz_id)->get()
        ];

        return view('quiz.draggable.master', $data);
    }

    protected function showCreateDraggable($quiz_id)
    {
        $data = [
            'title'     => 'Create Draggable',
            'quiz'      => Quiz::find($quiz_id)
        ];

        return view('quiz.draggable.create_draggable', $data);
    }

    protected function create_draggable(Request $request)
    {
        $this->validate($request, [
            'draggable_question'    => 'required',
            'draggable_poin'        => 'required'
        ]);

        $draggable = new Draggable();
        $draggable->quiz_id = $request->quiz_id;
        $draggable->draggable_question =  $request->draggable_question;
        if ($request->hasFile('draggable_image')) {
            $draggable_request = $request->file('draggable_image');
            $draggable_image = time() . '_' . $draggable_request->getClientOriginalName();

            Storage::putFileAs('public/images/quiz', $draggable_request, $draggable_image);

            $draggable->draggable_image = $draggable_image;
        }

        $draggable->draggable_poin = $request->draggable_poin;

        $draggable->save();

        if (isset($_POST['new_question'])) {
            return back();
        } elseif (isset($_POST['save'])) {
            return redirect('/draggable/master/' . $request->quiz_id);
        }
    }

    protected function detail_draggable($quiz_id, $draggable_id)
    {
        $data = [
            'title'     => 'Detail Question',
            'quiz'      => Quiz::find($quiz_id),
            'draggable'     => Draggable::find($draggable_id),
        ];

        return view('quiz.draggable.detail', $data);
    }

    protected function hapus_draggable($draggable_id, Request $request)
    {
        $draggable = Draggable::find($draggable_id);

        Storage::delete('public/images/quiz/' . $draggable->draggable_image);

        $draggable->delete();

        return redirect('/draggable/master/' . $request->quiz_id);
    }

    protected function update_draggable(Request $request, $draggable_id)
    {
        $this->validate($request, [
            'draggable_question'    => 'required',
            'draggable_poin'        => 'required'
        ]);

        $draggable = Draggable::find($draggable_id);
        $old_img = $draggable->draggable_image;

        $draggable->draggable_question = $request->draggable_question;
        if ($request->hasFile('draggable_image') && $request->draggable_image == true) {
            $draggable_request = $request->file('draggable_image');
            $draggable_image = time() . '_' . $draggable_request->getClientOriginalName();

            Storage::putFileAs('public/images/quiz/', $draggable_request, $draggable_image);

            $draggable->draggable_image = $draggable_image;

            if ($old_img != $draggable_image) {
                Storage::delete('public/images/quiz/' . $old_img);
            }
        }

        $draggable->draggable_poin = $request->draggable_poin;

        $draggable->save();

        return redirect('/draggable/master/' . $request->quiz_id);
    }

    protected function manage_options($quiz_id)
    {
        $data = [
            'title'     => 'Manage Options',
            'quiz'      => Quiz::find($quiz_id),
            'draggable' => Draggable::where('quiz_id', $quiz_id)->select(['draggable_id', 'draggable_question'])->get(),
            'options'   => DraggableOption::where('quiz_id', $quiz_id)->get(),
        ];

        return view('quiz.draggable.manage_options', $data);
    }

    protected function create_option(Request $request)
    {
        $this->validate($request, [
            'draggable_answer' => 'required',
        ]);

        $option = new DraggableOption();
        $option->quiz_id = $request->quiz_id;
        $option->draggable_id = null;
        $option->draggable_answer = $request->draggable_answer;

        $option->save();

        return back();
    }

    protected function update_option(Request $request, $draggable_opt_id)
    {
        $option = DraggableOption::find($draggable_opt_id);
        $option->draggable_id = $request->draggable_id;
        $option->draggable_answer = $request->draggable_answer;

        $option->save();

        return back();
    }

    protected function hapus_option($draggable_opt_id)
    {
        $option = DraggableOption::find($draggable_opt_id);
        $option->delete();

        return back();
    }

    protected function review_draggable($quiz_id)
    {
        $data = [
            'title'         => 'Review Multiple Choice',
            'quiz'          => Quiz::find($quiz_id),
            'attempt'       => AttemptQuiz::where('quiz_id', $quiz_id)->get(),
        ];

        // dd($data['answers']);
        return view('quiz.draggable.review', $data);
    }
}
