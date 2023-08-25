<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\Semester;
use App\Models\AnswerMc;
use App\Models\AnswerEssay;
use App\Models\AnswerDraggable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssesmentRecapExportHandler implements FromCollection, WithHeadings 
{
    protected $attempt;

    public function __construct($attempt)
    {
        $this->attempt = $attempt;
    }

    public function collection()
    {
        // Get selected class and quiz
        $selectedClass = request('class');
        $selectedQuiz = request('quiz');
        
        // Filter attempts based on selected class and quiz
        $filteredAttempts = $this->attempt;
        
        if ($selectedClass != '') {
            $filteredAttempts = $filteredAttempts->filter(function ($attempt) use ($selectedClass) {
                return $attempt->user->kelas_id == $selectedClass;
            });
        }
        
        if ($selectedQuiz != '') {
            $filteredAttempts = $filteredAttempts->filter(function ($attempt) use ($selectedQuiz) {
                return $attempt->quiz->quiz_id == $selectedQuiz;
            });
        }

        $data = collect([]);

        // Use $filteredAttempts instead of $this->attempt in the loop
        foreach ($filteredAttempts as $key => $item) {
            $kelas = Kelas::where('kelas_id', $item->user->kelas_id)->first();
            $semester = Semester::where('semester_id', $item->user->semester_id)->first();
            
            $quiz_id = $item->quiz_id;
            $user_id_attempt = $item->user_id;
            $skor_per_quiz = AnswerMc::where('user_id', $user_id_attempt)
                ->where('quiz_id', $quiz_id)
                ->sum('score');
            $skor_per_quiz_essay = AnswerEssay::where('user_id', $user_id_attempt)
                ->where('quiz_id', $quiz_id)
                ->sum('score');
            $skor_per_quiz_draggable = AnswerDraggable::where('user_id', $user_id_attempt)
                ->where('quiz_id', $quiz_id)
                ->sum('score');

            $score = "No Score Available / 0";
            if ($skor_per_quiz_essay > 0) {
                $score = $skor_per_quiz_essay;
            } elseif ($skor_per_quiz > 0) {
                $score = $skor_per_quiz;
            } elseif ($skor_per_quiz_draggable > 0) {
                $score = $skor_per_quiz_draggable;
            }

            $data->push([
                'No.' => $key + 1,
                'Name' => $item->user->nama,
                'Kelas' => $kelas ? $kelas->nama_kelas : '-',
                'Semester' => $semester ? $semester->semester_tipe : '-',
                'Quiz' => $item->quiz->quiz_name,
                'Quiz Type' => $item->quiz->quiz_type,
                'Score' => $score
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Name',
            'Kelas',
            'Semester',
            'Quiz',
            'Quiz Type',
            'Score'
        ];
    }
}
