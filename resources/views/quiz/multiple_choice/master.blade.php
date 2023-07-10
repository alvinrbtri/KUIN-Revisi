@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-md d-flex justify-content-between align-items-center">
                <h3 class="text-dark" style="font-weight: 800">
                    {{ $quiz->quiz_name }}
                </h3>
                <div class="d-flex">
                    <a href="{{ url('/multiple_choice/review/'.$quiz->quiz_id) }}" class="btn btn-warning me-2" style="font-size: 12px">Review</a>
                    <a href="{{ url('/multiple_choice/create_question/'.$quiz->quiz_id) }}" class="btn btn-primary me-2" style="font-size: 12px">Create Question</a>
                    <a href="{{ route('quiz') }}" class="btn btn-secondary" style="font-size: 12px">Kembali</a>
                </div>
            </div>
        </div>

        <div class="row mt-2" style="row-gap: 20px">
            @foreach ($questions as $question)
            <div class="col-md-2 text-decoration-none">
                <div class="card">
                    <a href="{{ '/multiple_choice/detail/'.$question->quiz_id . '/' . $question->question_id }}" class="text-decoration-none card-body d-flex flex-column justify-content-center align-items-center" style="color: navy;">
                        <p style="letter-spacing: 2px; font-weight: 500">SOAL</p>
                        <h1 style="font-weight: 700">{{ $loop->iteration }}</h1>
                    </a>
                    <div class="card-footer d-flex justify-content-center align-items-center">
                        <p class="text-center mb-0">Poin: {{ $question->question_poin }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if ($questions->isEmpty())
        <div class="row mt-2 mx-5 justify-content-center align-items-center">
            <div class="col-md-8" style="height: 70vh">
                <img src="{{ asset('img/empty.jpg') }}" style="width: 100%; height: 100%; object-fit: contain;" alt="">
                <h6 class="text-center" style="font-weight: 700; color: #ccc">No question here</h6>
            </div>
        </div>
        @endif
    </div>
@endsection