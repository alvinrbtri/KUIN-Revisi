@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4 mx-2">
            <div class="col-md">
                <a href="{{ url('/draggable/master/'.$quiz->quiz_id) }}" class="btn btn-dark" style="font-size: 12px">Kembali</a>
            </div>
        </div>
        
        <form action="{{ url('/draggable/create_draggable') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4  mx-2">
                <input type="hidden" name="quiz_id" id="quiz_id" value="{{ $quiz->quiz_id }}">
                <div class="col-md-8">
                   <div class="card">
                      <textarea name="draggable_question" class="form-control @error('draggable_question') is-invalid @enderror" id="draggable_question" rows="7" placeholder="What's your draggable question?" style="resize: none;">{{ old('draggable_question') }}</textarea>
                    </div>
                    @error('draggable_question')
                        <span class="text-danger" style="font-size: 13px">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="col-md-4">
                   <div class="card">
                    <div class="card-body">
                        <div class="mt-1">
                            <label for="draggable_poin">Poin:</label>
                            <input type="number" min="0" class="form-control @error('draggable_poin') is-invalid @enderror" placeholder="Poin this question" value="{{ old('draggable_poin') }}" name="draggable_poin" id="draggable_poin">
                            @error('draggable_poin')
                                <span class="text-danger" style="font-size: 13px">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
    
                        <div class="mt-4">
                            <label for="draggable_image">Question Image (optional)</label>
                            <input type="file" class="form-control" name="draggable_image" id="draggable_image">
                        </div>
                    </div>
                   </div>
                </div>
            </div>
    
            <div class="row mx-2">
                <div class="col-md mt-4">
                    <button name="new_question" class="btn btn-primary" style="font-weight: 700; font-size: 13px">+ New Question</button>
                    <button name="save" type="submit" class="btn btn-success px-4" style="font-weight: 700; font-size: 13px">Simpan & Keluar</button>
                </div>
            </div>
            
        </form>


    </div>
@endsection