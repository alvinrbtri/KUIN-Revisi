@extends('layouts.dash')

@section('dash-content')
    <div class="row mx-2">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    Score Recap
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="data">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Kelas</th>
                                    <th>Semester</th>
                                    <th>Quiz</th>
                                    <th>Quiz Type</th>
                                    <th>Score</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attempt as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->nama }}</td>
                                        @php
                                            $kelas = \App\Models\Kelas::where('kelas_id', $item->user->kelas_id)->first();
                                            $semester = \App\Models\Semester::where('semester_id', $item->user->semester_id)->first();
                                        @endphp
                                        <td>
                                            @if ($kelas)
                                                {{ $kelas->nama_kelas }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($semester)
                                                {{ $semester->semester_tipe }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->quiz->quiz_name }}</td>
                                        <td>{{ $item->quiz->quiz_type }}</td>
                                        <td>
    @php
        $quiz_id = $item->quiz_id;
        $user_id_attempt = $item->user_id;
        $skor_per_quiz = \App\Models\AnswerMc::where('user_id', $user_id_attempt)
            ->where('quiz_id', $quiz_id)
            ->sum('score');
        $skor_per_quiz_essay = \App\Models\AnswerEssay::where('user_id', $user_id_attempt)
            ->where('quiz_id', $quiz_id)
            ->sum('score');
        $skor_per_quiz_draggable = \App\Models\AnswerDraggable::where('user_id', $user_id_attempt)
            ->where('quiz_id', $quiz_id)
            ->sum('score');
    @endphp

    @if ($user->level === 'admin' || $user->level === 'dosen')
        {{-- Menampilkan total skor untuk admin atau dosen --}}
        @if ($skor_per_quiz_essay > 0)
            {{ $skor_per_quiz_essay }}
        @elseif ($skor_per_quiz > 0)
            {{ $skor_per_quiz }}
        @elseif ($skor_per_quiz_draggable > 0)
            {{ $skor_per_quiz_draggable }}
        @else
            No Score Available / 0
        @endif
    @else
        {{-- Menampilkan total skor per quiz untuk pengguna yang sedang login --}}
        @if ($skor_per_quiz_essay > 0)
            {{ $skor_per_quiz_essay }}
        @elseif ($skor_per_quiz > 0)
            {{ $skor_per_quiz }}
        @elseif ($skor_per_quiz_draggable > 0)
            {{ $skor_per_quiz_draggable }}
        @else
            No Score Available / 0
        @endif
    @endif
</td>



                                        <td>
                                            <a target="_blank"
                                                href="{{ '/results/' . $item->quiz->quiz_id . '/' . $item->user->user_id }}"
                                                class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
