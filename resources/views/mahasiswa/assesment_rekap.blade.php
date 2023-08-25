@extends('layouts.dash')

@section('dash-content')
    <div class="row mx-2">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Score Recap</h5>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="/assesment-recap/export" method="get" class="mb-3">
                        @csrf
                        <input type="hidden" name="class_name" id="classNameInput">
                        <input type="hidden" name="quiz_name" id="quizNameInput">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="classSelector">Pilih Kelas:</label>
                                    <select name="class" class="form-control" id="classSelector">
                                        <option value="">Pilih Semua</option>
                                        @php
                                            $uniqueClasses = $attempt->groupBy('user.kelas.nama_kelas')->map(function ($class) {
                                                return $class->first();
                                            })->sortBy('user.kelas.nama_kelas');
                                        @endphp
                                        @foreach ($uniqueClasses as $item)
                                            @php
                                                $kelas = \App\Models\Kelas::where('kelas_id', $item->user->kelas_id)->first();
                                            @endphp
                                            @if ($kelas)
                                                <option value="{{ $kelas->kelas_id }}">{{ $kelas->nama_kelas }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quizSelector">Pilih Quiz:</label>
                                    <select name="quiz" class="form-control" id="quizSelector">
                                        <option value="">Pilih Semua</option>
                                        @php
                                            $uniqueQuizzes = $attempt->groupBy('quiz.quiz_name')->map(function ($quiz) {
                                                return $quiz->first();
                                            })->sortBy('quiz.quiz_name');
                                        @endphp
                                        @foreach ($uniqueQuizzes as $item)
                                            <option value="{{ $item->quiz->quiz_id }}">{{ $item->quiz->quiz_name }}</option>
                                        @endforeach
                                     </select>
                                </div>
                            </div>

                            <div class="col-md-4 d-flex justify-content-end align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-file-csv mr-1"></i> Export to CSV
                                </button>
                            </div>
                        </div>
                    </form>

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
                                @php
                                    $kelas = \App\Models\Kelas::where('kelas_id', $item->user->kelas_id)->first();
                                    $semester = \App\Models\Semester::where('semester_id', $item->user->semester_id)->first();
                                @endphp
                                    <tr data-class-name="{{ $kelas ? $kelas->nama_kelas : '-' }}" data-quiz-name="{{ $item->quiz->quiz_name }}">
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var classSelector = document.getElementById('classSelector');
            var quizSelector = document.getElementById('quizSelector');
            
            classSelector.addEventListener('change', filterTable);
            quizSelector.addEventListener('change', filterTable);
            
            function filterTable() {
                var className = classSelector.options[classSelector.selectedIndex].text;
                var quizName = quizSelector.options[quizSelector.selectedIndex].text;

                // Ubah nilai dari dua input hidden
                document.getElementById('classNameInput').value = className === 'Pilih Semua' ? '' : className;
                document.getElementById('quizNameInput').value = quizName === 'Pilih Semua' ? '' : quizName;
                
                // Dapatkan semua baris
                var rows = document.querySelectorAll('#data tbody tr');
                
                // Sembunyikan semua baris
                for (var i = 0; i < rows.length; i++) {
                    rows[i].style.display = 'none';
                }

                // Jika user memilih 'Pilih Semua' untuk kedua filter, tampilkan semua baris
                if (className === 'Pilih Semua' && quizName === 'Pilih Semua') {
                    for (var i = 0; i < rows.length; i++) {
                        rows[i].style.display = '';
                    }
                } else {
                    // Filter baris berdasarkan className dan quizName
                    for (var i = 0; i < rows.length; i++) {
                        var row = rows[i];
                        var rowClassName = row.getAttribute('data-class-name');
                        var rowQuizName = row.getAttribute('data-quiz-name');
                        if ((className === 'Pilih Semua' || className === rowClassName) && (quizName === 'Pilih Semua' || quizName === rowQuizName)) {
                            row.style.display = '';
                        }
                    }
                }
            }
        });

    </script>
@endsection

