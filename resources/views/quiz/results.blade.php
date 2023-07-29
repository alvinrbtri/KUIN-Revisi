@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4 mx-3">
            <div class="col-md">
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        Result Quiz
                    </div>


                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <h1 style="font-weight: bold" class="text-primary">
                            @if ($quiz->quiz_type != 'Essay')
                                {{ $scores }} POIN
                            @else
                                @if ($scores == true)
                                    {{ $scores }} POIN
                                @endif
                                @if ($scores == false)
                                    <h6 style="font-weight: bold">Menungu review dari dosen..</h6>
                                @endif
                            @endif
                        </h1>
                        <p class="mb-0">Terimakasih sudah mengikuti quiz ini.</p>
                        <button class="mt-3 btn btn-secondary"
                            @if (auth()->user()->level == 'mahasiswa' || auth()->user()->level == 'dosen' || auth()->user()->level == 'admin') id="close_window" @else onclick="window.history.back();" @endif>
                            Keluar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">

            <div class="">
                <h3>Jawaban Quiz ( {{ $quiz->quiz_name }} - {{ $quiz->quiz_type }} ) :</h3>
            </div>
            <hr>
            <div class="row">
              @php
                    $isFirstCard = true; // Inisialisasi variabel untuk menandai apakah ini adalah card pertama
                @endphp

                @foreach ($data_abc2 as $item)
                    @php
                        $isUserAnswerCorrect = false; // Inisialisasi variabel untuk menandai apakah jawaban pengguna benar
                        $correctAnswer = null; // Inisialisasi variabel untuk menyimpan jawaban benar
                    @endphp

                    {{-- Loop untuk mencari jawaban benar --}}
                    @foreach ($question_answer as $soal)
                        @if ($soal->key_answer == $item->answer)
                            @php
                                $isUserAnswerCorrect = true; // Set variabel ini menjadi true jika jawaban pengguna benar
                                $correctAnswer = $soal->key_answer; // Simpan jawaban benar
                            @endphp
                        @endif
                    @endforeach

                    {{-- Cari jawaban benar berdasarkan opsi1, opsi2, opsi3, opsi4, dan opsi5 --}}
                    @foreach ($question_answer as $soal)
                        @if (in_array($item->answer, [$soal->opsi1, $soal->opsi2, $soal->opsi3, $soal->opsi4, $soal->opsi5]))
                            @php
                                $correctAnswer = $soal->key_answer;
                            @endphp
                        @break
                    @endif
                @endforeach
                @if ($quiz->quiz_id == $item->quiz_id)
                    @if ($isFirstCard)
                        {{-- Card pertama, tampilkan nama pengguna --}}
                        <p class="card-text"><b>Nama Mahasiswa</b> : {{ $item->user->nama }}</p>
                        <p class="card-text"><b>Kelas</b> : {{ $item->user->kelas->nama_kelas }}</p>
                        <p class="card-text"><b>Semester</b> : {{ $item->user->semester->semester_tipe }}</p>
                        @php
                            $isFirstCard = false; // Set variabel ini menjadi false setelah card pertama ditampilkan
                        @endphp
                    @endif
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header {{ $isUserAnswerCorrect ? '' : '' }}">

                                <h5 class="card-title">Soal {{ $loop->iteration }} - Score: {{ $item->score }}
                                    @if ($isUserAnswerCorrect)
                                        <span style="color: rgb(0, 255, 26);">✓</span>
                                        <!-- Simbol checklist berwarna putih -->
                                    @else
                                        <span style="color: rgb(255, 0, 0);">✗</span> <!-- Simbol "x" berwarna putih -->
                                    @endif
                                </h5>
                            </div>

                            <div class="card-body">

                                @foreach ($question_answer as $soal)
                                    @if (
                                        $soal->key_answer == $item->answer ||
                                            in_array($item->answer, [$soal->opsi1, $soal->opsi2, $soal->opsi3, $soal->opsi4, $soal->opsi5]))
                                        <p class="card-text">Soal Quiz {{ $quiz->quiz_type }}: {!! $soal->question->question !!}
                                        </p>
                                        <hr>
                                    @endif
                                @endforeach
                                <p>Jawaban Mahasiswa: {{ $item->answer }} @if ($isUserAnswerCorrect)
                                        <span style="color: rgb(0, 255, 26);">✓</span>
                                        <!-- Simbol checklist berwarna putih -->
                                    @else
                                        <span style="color: rgb(255, 0, 0);">✗</span> <!-- Simbol "x" berwarna putih -->
                                    @endif
                                </p>
                            </div>
                            <div class="card-footer">
                                @if ($isUserAnswerCorrect)
                                    <p>Jawaban Sistem Benar: <b class="text-capitalize">{{ $correctAnswer }}</b></p>
                                @else
                                    <p class="">Jawaban Sistem Benar:
                                        <b
                                            class="text-capitalize">{{ $correctAnswer ? $correctAnswer : 'Tidak ada jawaban benar' }}</b>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            {{-- @if ($quiz->quiz_id === 'Essay') --}}


            @foreach ($jawaban_essay as $jwb_essay)
                @if ($quiz->quiz_id == $jwb_essay->quiz_id)
                    @if ($isFirstCard)
                        {{-- Card pertama, tampilkan nama pengguna --}}
                        <p class="card-text"><b>Nama Mahasiswa</b> : {{ $jwb_essay->user->nama }}</p>
                        <p class="card-text"><b>Kelas</b> : {{ $jwb_essay->user->kelas->nama_kelas }}</p>
                        <p class="card-text"><b>Semester</b> : {{ $jwb_essay->user->semester->semester_tipe }}</p>
                        @php
                            $isFirstCard = false; // Set variabel ini menjadi false setelah card pertama ditampilkan
                        @endphp
                    @endif

                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Soal {{ $loop->iteration }} - Score: {{ $jwb_essay->score }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <p>Soal Quiz {{ $quiz->quiz_type }}:</p>
                                <p>{{ $jwb_essay->essay->essay_question }}</p>
                                <hr>
                                <p>Jawaban Mahasiswa:</p>
                                <p>{{ $jwb_essay->answer }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach ($drag_answer as $drag_jawaban)
                @if ($quiz->quiz_id == $drag_jawaban->quiz_id)
                    @if ($isFirstCard)
                        {{-- Card pertama, tampilkan nama pengguna --}}
                        <p class="card-text"><b>Nama Mahasiswa</b> : {{ $drag_jawaban->user->nama }}</p>
                        <p class="card-text"><b>Kelas</b> : {{ $drag_jawaban->user->kelas->nama_kelas }}</p>
                        <p class="card-text"><b>Semester</b> : {{ $drag_jawaban->user->semester->semester_tipe }}</p>
                        @php
                            $isFirstCard = false; // Set variabel ini menjadi false setelah card pertama ditampilkan
                        @endphp
                    @endif

                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Soal {{ $loop->iteration }} - Score: {{ $drag_jawaban->score }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <p>Soal Quiz {{ $quiz->quiz_type }}:</p>
                                @php
                                    $draggableQuestion = '';
                                    foreach ($drag_option as $drag_pilihan) {
                                        if ($drag_jawaban->answer == $drag_pilihan->draggable_answer) {
                                            $draggableQuestion = $drag_pilihan->draggable->draggable_question ?? '';
                                            break;
                                        }
                                    }
                                @endphp
                                {{ $draggableQuestion }}
                                <hr>
                                <p>Jawaban Mahasiswa:</p>
                                {{ $drag_jawaban->answer }}
                            </div>
                            <div class="card-footer">
                                @php
                                    $correctAnswer = '';
                                    foreach ($drag_option as $drag_pilihan) {
                                        if (!is_null($drag_pilihan->draggable_id) && $drag_pilihan->draggable_id === $drag_jawaban->draggable_id) {
                                            $correctAnswer = $drag_pilihan->draggable_answer;
                                            break;
                                        }
                                    }
                                @endphp
                                @if (!empty($correctAnswer))
                                    <h5 class="">Jawaban Sistem Benar: <b>{{ $correctAnswer }}</b></h5>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach





            <!-- Add more cards for other quiz results -->

        </div>


    </div>

</div>


<?php
if ($quiz->quiz_type == 'Essay') {
    $redirectLink = '/essay';
} elseif ($quiz->quiz_type == 'Draggable') {
    $redirectLink = '/draggable';
} else {
    $redirectLink = '/multiple_choice/review/' . $quiz->quiz_id . '';
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myButton = document.getElementById('close_window');
        myButton.addEventListener('click', function() {
            window.close();
            window.location.href = '{{ $redirectLink }}';
        });
    });
</script>
@endsection

{{-- @foreach ($option_jawaban_benar_sistem as $jwb)
                                    @if ($jwb->key_answer != $item->answer)
                                        <h5>Jawaban Benar: {{ $jwb->key_answer }}</h5>
                                    @endif
                                @endforeach --}}
