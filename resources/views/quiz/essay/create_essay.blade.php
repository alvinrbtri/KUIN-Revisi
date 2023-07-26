@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4 mx-2">
            <div class="col-md">
                <a href="{{ url('/essay/master/'.$quiz->quiz_id) }}" class="btn btn-dark" style="font-size: 12px">Back</a>
            </div>
        </div>
        
        <form action="{{ url('/essay/create_essay') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4  mx-2">
                <input type="hidden" name="quiz_id" id="quiz_id" value="{{ $quiz->quiz_id }}">
                <div class="col-md-8">
                   <div class="card">
                      <textarea name="essay_question" class="form-control @error('essay_question') is-invalid @enderror" id="essay_question" rows="7" placeholder="What's your essay question?" style="resize: none;">{{ old('essay_question') }}</textarea>
                    </div>
                    @error('essay_question')
                        <span class="text-danger" style="font-size: 13px">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="col-md-4">
                   <div class="card">
                    <div class="card-body">
                        <div class="mt-1">
                            <label for="essay_poin">Poin:</label>
                            <input type="number" min="0" class="form-control @error('essay_poin') is-invalid @enderror" placeholder="Poin this question" value="{{ old('essay_poin') }}" name="essay_poin" id="essay_poin">
                            @error('essay_poin')
                                <span class="text-danger" style="font-size: 13px">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
    
                        <div class="mt-4">
                            <label for="essay_image">Question Image (optional)</label>
                            <input type="file" class="form-control" name="essay_image" id="essay_image">
                        </div>
                    </div>
                   </div>
                </div>
            </div>
    
            <div class="row mx-2">
                <div class="col-md mt-4">
                    <button name="new_question" class="btn btn-primary" style="font-weight: 700; font-size: 13px">+ New Question</button>
                    <button name="save" type="submit" class="btn btn-success px-4" style="font-weight: 700; font-size: 13px">Save & Out</button>
                </div>
            </div>
            
        </form>


    </div>
@endsection