@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4 mx-2">
            <div class="col-md">
                <a href="{{ url('/essay/master/'.$quiz->quiz_id) }}" class="btn btn-dark" style="font-size: 12px">Back</a>
            </div>
        </div>
        
        <form action="{{ url('/essay/update_essay/'.$essay->essay_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4  mx-2">
                @csrf
                <input type="hidden" name="quiz_id" id="quiz_id" value="{{ $quiz->quiz_id }}">
                <div class="col-md-8">
                   <div class="card">
                      <textarea name="essay_question" class="form-control @error('essay_question') is-invalid @enderror" id="essay_question" rows="7" placeholder="What's your essay question?" style="resize: none;">{{ $essay->essay_question }}</textarea>
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
                        <div>
                            <label for="essay_poin">Poin:</label>
                            <input type="number" min="0" class="form-control @error('essay_poin') is-invalid @enderror" placeholder="Poin this question" value="{{ $essay->essay_poin }}" name="essay_poin" id="essay_poin">
                            @error('essay_poin')
                                <span class="text-danger" style="font-size: 13px">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
    
                        <div class="mt-1">
                            <label for="essay_image">Question Image (optional)</label>
                            <input type="file" class="form-control" name="essay_image" id="essay_image">
                            <span style="font-size: 13px">File Name: @if($essay->essay_image == null) - @else {{ $essay->essay_image }} @endif</span>
                        </div>
                    </div>
                   </div>
                </div>
            </div>
    
            <div class="row mx-2">
                <div class="col-md mt-4">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus" style="font-weight: 700">Delete</button>
                    <button type="submit" class="btn btn-info px-4" style="font-weight: 700">Update</button>
                </div>
            </div>
        </form>
            
        <!-- Modal -->
        <div class="modal fade" id="hapus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-light">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Warning</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        Are you sure to delete the question?
                    </div>
                    
                    <div class="modal-footer">
                        <form action="{{ url('/essay/hapus_essay/' . $essay->essay_id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quiz_id" id="quiz_id" value="{{ $quiz->quiz_id }}">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete it!</button>
                        </form>
                    </div>
                 </div>
            </div>
        </div>


    </div>
@endsection