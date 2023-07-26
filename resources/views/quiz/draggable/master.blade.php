@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-md d-flex justify-content-between align-items-center">
                <h3 class="text-dark" style="font-weight: 800">
                    {{ $quiz->quiz_name }}
                </h3>
                <div class="d-flex">
                    <a href="{{ url('/draggable/review/' . $quiz->quiz_id) }}" class="btn me-2 btn-warning text-light" style="font-size: 12px;">Review</a>
                    <a href="{{ url('/draggable/create_draggable/' . $quiz->quiz_id) }}" class="btn me-2 text-light" style="font-size: 12px; background: purple">Create Question</a>
                    <a href="{{ url('/draggable/manage_options/' . $quiz->quiz_id) }}" class="btn me-2 text-light" style="font-size: 12px; background: rgb(22, 22, 104)">Manage Options</a>
                    <a href="{{ route('quiz') }}" class="btn btn-secondary" style="font-size: 12px">Back</a>
                </div>
            </div>
        </div>

        <div class="row mt-2" style="row-gap: 30px">
            @foreach ($draggable as $question)
            <div class="col-md-3 text-decoration-none">
                <div class="card">
                    <a href="{{ '/draggable/detail/' . $question->quiz_id . '/' . $question->draggable_id }}" class="text-decoration-none card-body d-flex flex-column justify-content-center align-items-center" style="color: navy;">
                        <p style="letter-spacing: 2px; font-weight: 500">SOAL</p>
                        <h1 style="font-weight: 700">{{ $loop->iteration }}</h1>
                    </a>
                    <div class="card-footer d-flex justify-content-center align-items-center">
                        <p class="text-center mb-0">Poin: {{ $question->draggable_poin }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if ($draggable->isEmpty())
        <div class="row mt-2 mx-5 justify-content-center align-items-center">
            <div class="col-md-8" style="height: 70vh">
                <img src="{{ asset('img/empty.jpg') }}" style="width: 100%; height: 100%; object-fit: contain;" alt="">
                <h6 class="text-center" style="font-weight: 700; color: #ccc">No question here</h6>
            </div>
        </div>
        @endif
    </div>
@endsection