@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">

        <div class="row mt-2 mx-2">
            <div class="col-md-12 my-4">
                <a href="{{ url('/multiple_choice/master/' . $quiz->quiz_id) }}" class="btn btn-dark"
                    style="font-size: 12px">Kembali</a>
            </div>
            <form action="/multiple_choice/create_mc" method="POST" enctype="multipart/form-data"
                class="d-flex flex-md-row flex-column justify-content-between" style="row-gap: 20px">
                @csrf
                <div class="col-md-7">
                    <input type="hidden" name="quiz_id" value="{{ $quiz->quiz_id }}">
                    <div class="card"
                        style="border: none; border-radius: 10px; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                        <div class="card-body">
                            <textarea name="question" class="form-control" id="my-editor" rows="4" placeholder="Masukkan pertanyaan">{{ old('question') }}</textarea>
                            @error('opsi5')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror

                            <div class="mt-4">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">A</span>
                                    <input type="text" name="opsi1" value="{{ old('opsi1') }}"
                                        class="form-control input-text" data-option="option1" placeholder="Opsi A"
                                        aria-describedby="basic-addon1">
                                    @error('opsi1')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">B</span>
                                    <input type="text" name="opsi2" value="{{ old('opsi2') }}"
                                        class="form-control input-text" data-option="option2" placeholder="Opsi B"
                                        aria-describedby="basic-addon2">
                                    @error('opsi2')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon3">C</span>
                                    <input type="text" name="opsi3" value="{{ old('opsi3') }}"
                                        class="form-control input-text" data-option="option3" placeholder="Opsi C"
                                        aria-describedby="basic-addon3">
                                    @error('opsi3')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon4">D</span>
                                    <input type="text" name="opsi4" value="{{ old('opsi4') }}"
                                        class="form-control input-text" data-option="option4" placeholder="Opsi D"
                                        aria-describedby="basic-addon4">
                                    @error('opsi4')
                                        <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon5">E</span>
                                    <input type="text" name="opsi5" value="{{ old('opsi5') }}"
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
                                @if (old('key_answer'))
                                    <option value="{{ old('key_answer') }}">{{ old('key_answer') }}</option>
                                @endif
                                <option value="">Pilih Opsi</option>
                                <option id="option1"></option>
                                <option id="option2"></option>
                                <option id="option3"></option>
                                <option id="option4"></option>
                                <option id="option5"></option>
                            </select>
                            @error('key_answer')
                                <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                            @enderror

                            <hr>

                            <div class="">
                                <label for="question_poin">Poin</label>
                                <input type="number" name="question_poin" value="{{ old('question_poin') }}"
                                    id="question_poin" class="form-control @error('question_poin') is-invalid @enderror()"
                                    placeholder="Masukkan jumlah poin">
                                @error('question_poin')
                                    <span class="text-danger" style="font-size: 12px">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-2">
                                <label for="question_image">Image</label>
                                <input type="file" name="question_image" id="question_image" class="form-control">
                            </div>
                            {{-- <p>
                                <input type="radio" name="A" id="A">
                            </p> --}}
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button name="new_question" class="btn btn-primary" style="font-size: 13px">+ New
                            Question</button>
                        <button name="save" class="btn btn-success" style="font-size: 13px">Simpan & Keluar</button>
                    </div>
                </div>
            </form>
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
