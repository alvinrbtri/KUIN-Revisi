@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4 mx-2">


            <div class="col-md">

                <a href="{{ url('/essay/master/'.$quiz->quiz_id) }}" class="btn btn-dark" style="font-size: 12px">Kembali</a>

                <h5 class="my-3" style="font-weight: bold">{{ $title }}</h5>
                <form action="{{ url('/essay/pratinjau/' . $quiz->quiz_id) }}" method="POST" id="save_essay">
                    @csrf
                    @foreach ($essay as $item)
                        <div class="col-md-8 mt-3 mb-5">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4 style="font-weight: bold">Soal#{{ $loop->iteration }}</h4>
                                    <p class="mb-0">Poin: 
                                        <select name="{{ 'poin-'.$item->essay_id }}" class="form-control" id="">
                                            @foreach ($answers as $answer)
                                                @if ($answer->essay_id == $item->essay_id)
                                                    {{-- <input type="text" name="{{ 'answer_id-'.$item->essay_id }}" value="{{ $answer->answer_id }}" id=""> --}}
                                                    {{-- <p class="mb-0">{{ $answer->score }}</p> --}}
                                                    <option value="{{ $answer->score }}">{{ $answer->score }}</option>
                                                @endif
                                            @endforeach
                                            @for($i = 0; $i <= $item->essay_poin; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </p>
                                </div>
                                <div class="card-body">
                                    {{ $item->essay_question }}
            
                                    @if ($item->essay_image != null)
                                    <div class="mt-3 bg-secondary rounded" style="height: 30vh">
                                        <img src="{{ asset('storage/images/quiz/'.$item->essay_image) }}" style="width: 100%; height: 100%; object-fit: contain" alt="">
                                    </div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <h6 style="font-weight: 600;">Answer:</h6>
                                    @foreach ($answers as $answer)
                                    @if ($answer->essay_id == $item->essay_id)
                                            <input type="hidden" name="{{ 'answer_id-'.$item->essay_id }}" value="{{ $answer->answer_id }}" id="">
                                            <p class="mb-0">{{ $answer->answer }}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
    
                    <button type="submit" class="btn mb-4 px-5 btn-info" id="close_quiz">Pratinjau</button>
                </form>
            </div>
        </div>
    </div>
@endsection