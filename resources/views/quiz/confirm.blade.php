@extends('layouts.quiz')


@section('quiz-content')
    <div class="container-fluid">
        <div class="row mx-3 mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Perhatian</h5>
                    </div>
                    <div class="card-body">
                    
                        <p>
                            Apakah anda yakin untuk melanjutkan mengerjakan kuis <strong>{{ $quiz->quiz_name }}</strong> ini?
                        </p>

                        <div class="mt-4">
                            @php
                                date_default_timezone_set('Asia/Jakarta');
                            @endphp
                            <form action="@if($quiz->quiz_type == 'Essay') {{ url('/essay/attempt/' . $quiz->quiz_id . '/' . auth()->user()->user_id) }} @elseif($quiz->quiz_type == 'Draggable') {{ url('/draggable/attempt/' . $quiz->quiz_id . '/' . auth()->user()->user_id) }} @else {{ url('/multiple_choice/attempt/' . $quiz->quiz_id . '/' . auth()->user()->user_id) }} @endif" method="GET" style="display: inline-block">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">
                                <input type="hidden" name="quiz_id" value="{{ $quiz->quiz_id }}">
                                @if(date('d M Y', strtotime($quiz->quiz_date)) == date('d M Y', strtotime('now'))) 
                                    @if ($attempt > 0)
                                    <span class="text-light rounded px-2 py-1 bg-success">Already Done</span>
                                    @else
                                        @if ($questions > 0)
                                            <button class="btn btn-primary" id="start_quiz" name="start_quiz">Take a Quiz</button>
                                        
                                        @else 

                                            <span class="rounded px-2 py-1 bg-warning">Not question yet</span>


                                        @endif
                                    @endif
                                @elseif(date('d M Y', strtotime($quiz->quiz_date)) < date('Y-m-d', strtotime('now')))
                                    <span class="text-light rounded px-2 py-1 bg-secondary">Expired</span>
                                @else
                                    <span class="text-light rounded bg-info px-2 py-1">Not Schedule Yet</span>
                                @endif
                            </form>
                            <a href="@if($quiz->quiz_type == 'Essay') /essay @elseif($quiz->quiz_type == 'Draggable') /draggable @else /multiple_choice @endif" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myButton = document.getElementById('start_quiz');
            myButton.addEventListener('click', function() {
                window.open('@if($quiz->quiz_type == "Essay"){{ url("/essay/attempt/" . $quiz->quiz_id . "/" . auth()->user()->user_id) }}@elseif($quiz->quiz_type == "Draggable"){{ url("/draggable/attempt/" . $quiz->quiz_id . "/" . auth()->user()->user_id) }}@else{{ url("/multiple_choice/attempt/" . $quiz->quiz_id . "/" . auth()->user()->user_id) }}@endif', '_blank', 'width=1000,height=800');
            });
    
            // Disable refresh shortcut
            document.addEventListener('keydown', function(event) {
                if (event.keyCode === 116) { // F5 key
                    event.preventDefault(); // Prevent browser refresh
                }
            });
        });
    </script>
    
@endsection