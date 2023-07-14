@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4 mx-3">
            <div class="col-md">
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
