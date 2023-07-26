@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">

        <div class="row mt-2 mx-2">
            <div class="col-md-12 my-4">
                <a href="{{ url('/multiple_choice/master/' . $quiz->quiz_id) }}" class="btn btn-dark"
                    style="font-size: 12px">Back</a>
            </div>
            <form action="{{ '/multiple_choice/update_mc/' . $question->question_id }}" method="POST"
                enctype="multipart/form-data" class="d-flex flex-md-row flex-column justify-content-between"
                style="row-gap: 20px">
                @csrf
                <div class="col-md-7">
                    <input type="hidden" name="quiz_id" value="{{ $quiz->quiz_id }}">
                    <div class="card"
                        style="border: none; border-radius: 10px; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                        <div class="card-body">
                            <textarea name="question" class="form-control" id="my-editor" rows="4" placeholder="Masukkan pertanyaan">{{ $question->question }}</textarea>
                            @error('opsi5')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror

                            <div class="mt-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">A</span>
                                    <input type="text" name="opsi1" value="{{ $option->opsi1 }}"
                                        class="form-control input-text" data-option="option1" placeholder="Opsi A"
                                        aria-describedby="basic-addon1">
                                    @error('opsi1')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">B</span>
                                    <input type="text" name="opsi2" value="{{ $option->opsi2 }}"
                                        class="form-control input-text" data-option="option2" placeholder="Opsi B"
                                        aria-describedby="basic-addon2">
                                    @error('opsi2')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">C</span>
                                    <input type="text" name="opsi3" value="{{ $option->opsi3 }}"
                                        class="form-control input-text" data-option="option3" placeholder="Opsi C"
                                        aria-describedby="basic-addon3">
                                    @error('opsi3')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon4">D</span>
                                    <input type="text" name="opsi4" value="{{ $option->opsi4 }}"
                                        class="form-control input-text" data-option="option4" placeholder="Opsi D"
                                        aria-describedby="basic-addon4">
                                    @error('opsi4')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon5">E</span>
                                    <input type="text" name="opsi5" value="{{ $option->opsi5 }}"
                                        class="form-control input-text" data-option="option5" placeholder="Opsi E"
                                        aria-describedby="basic-addon5">
                                    @error('opsi5')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card" style="border: 1px solid #ddd; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                        <div class="card-body">
                            <h6>Kunci Jawaban</h6>
                            <select class="form-control @error('key_answer') is-invalid @enderror" name="key_answer"
                                id="options-select">
                                <option value="{{ $option->key_answer }}">{{ $option->key_answer }}</option>
                                <option value="">Pilih Opsi</option>
                                <option id="option1">{{ $option->opsi1 }}</option>
                                <option id="option2">{{ $option->opsi2 }}</option>
                                <option id="option3">{{ $option->opsi3 }}</option>
                                <option id="option4">{{ $option->opsi4 }}</option>
                                <option id="option5">{{ $option->opsi5 }}</option>
                            </select>
                            @error('key_answer')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror

                            <hr>

                            <div class="">
                                <label for="question_poin">Poin</label>
                                <input type="number" name="question_poin" value="{{ $question->question_poin }}"
                                    id="question_poin" class="form-control @error('question_poin') is-invalid @enderror()"
                                    placeholder="Masukkan jumlah poin">
                                @error('question_poin')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-2">
                                <label for="question_image">Image</label>
                                <input type="file" name="question_image" id="question_image" class="form-control">
                                <span style="font-size: 12px" class="text-primary">
                                    File: @if ($question->question_image == null)
                                        -
                                    @else
                                        {{ $question->question_image }}
                                    @endif
                                </span>
                            </div>
                            {{-- <p>
                                <input type="radio" name="A" id="A">
                            </p> --}}
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus"
                            style="font-size: 13px">Delete</button>
                        <button type="submit" class="btn btn-primary" style="font-size: 13px">Update</button>
                    </div>
                </div>
            </form>

            <!-- Modal -->
            <div class="modal fade" id="hapus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-light">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Warning</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            Are you sure to delete the question?
                        </div>

                        <div class="modal-footer">
                            <form action="{{ url('/multiple_choice/hapus_mc/' . $question->question_id) }}"
                                method="POST">
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
    </div>

    @push('script')
        <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
        <script>
            var options = {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };
        </script>
        <script>
            CKEDITOR.replace('my-editor', options);
        </script>
    @endpush
@endsection
