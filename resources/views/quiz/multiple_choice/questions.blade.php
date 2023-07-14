@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mx-2 mt-5">
            <div class="col-md d-flex flex-row justify-content-between h3">
                <div>
                    {{ $quiz->quiz_name }}
                </div>

                <div id="countdown-{{ $quiz->quiz_id }}" class="position-fixed d-flex justify-content-end" style="width: 96%;">
                    00:00:00</div>
            </div>
            <hr>
        </div>
        <div class="row mx-2">
            <form action="{{ url('/multiple_choice/save_answer/' . $quiz->quiz_id) }}" method="POST" id="save_mc">
                @csrf
                @foreach ($multiple_choice as $item)
                    <input type="hidden" name="{{ 'user_id-' . $item->question_id }}"
                        value="{{ auth()->user()->user_id }}">
                    {{-- <input type="hidden" name="{{ 'essay_id-' . $loop->iteration }}" value="{{ $item->essay_id }}"> --}}
                    <div class="col-md-8 mt-3 mb-5">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 style="font-weight: bold">Soal#{{ $loop->iteration }}</h4>
                                <p class="mb-0">Poin: {{ $item->question_poin }}</p>
                            </div>
                            <div class="card-body">
                                {!! $item->question !!}

                                @if ($item->question_image != null)
                                    <div class="mt-3 bg-secondary rounded" style="height: 30vh">
                                        <img src="{{ asset('storage/images/quiz/' . $item->question_image) }}"
                                            style="width: 100%; height: 100%; object-fit: contain" alt="">
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                @foreach ($options as $option)
                                    @if ($item->question_id == $option->question_id)
                                        <input type="hidden" name="{{ 'key_answer-' . $item->question_id }}"
                                            value="{{ $option->key_answer }}">
                                        <input type="hidden" name="{{ 'question_poin-' . $item->question_id }}"
                                            value="{{ $item->question_poin }}">

                                        <p class="mb-1">
                                            <input type="radio" name="{{ 'answer-' . $item->question_id }}"
                                                id="{{ 'answer-' . $option->opsi1 . $item->question_id }}"
                                                value="{{ $option->opsi1 }}">
                                            <label
                                                for="{{ 'answer-' . $option->opsi1 . $item->question_id }}">{{ $option->opsi1 }}</label>
                                        </p>
                                        <p class="mb-1">
                                            <input type="radio" name="{{ 'answer-' . $item->question_id }}"
                                                id="{{ 'answer-' . $option->opsi2 . $item->question_id }}"
                                                value="{{ $option->opsi2 }}">
                                            <label
                                                for="{{ 'answer-' . $option->opsi2 . $item->question_id }}">{{ $option->opsi2 }}</label>
                                        </p>
                                        <p class="mb-1">
                                            <input type="radio" name="{{ 'answer-' . $item->question_id }}"
                                                id="{{ 'answer-' . $option->opsi3 . $item->question_id }}"
                                                value="{{ $option->opsi3 }}">
                                            <label
                                                for="{{ 'answer-' . $option->opsi3 . $item->question_id }}">{{ $option->opsi3 }}</label>
                                        </p>
                                        <p class="mb-1">
                                            <input type="radio" name="{{ 'answer-' . $item->question_id }}"
                                                id="{{ 'answer-' . $option->opsi4 . $item->question_id }}"
                                                value="{{ $option->opsi4 }}">
                                            <label
                                                for="{{ 'answer-' . $option->opsi4 . $item->question_id }}">{{ $option->opsi4 }}</label>
                                        </p>
                                        <p class="mb-1">
                                            <input type="radio" name="{{ 'answer-' . $item->question_id }}"
                                                id="{{ 'answer-' . $option->opsi5 . $item->question_id }}"
                                                value="{{ $option->opsi5 }}">
                                            <label
                                                for="{{ 'answer-' . $option->opsi5 . $item->question_id }}">{{ $option->opsi5 }}</label>
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn mb-4 px-5 btn-success">Submit</button>
            </form>
        </div>

        @if ($multiple_choice->isEmpty())
            <div class="row mt-2 mx-5 justify-content-center align-items-center">
                <div class="col-md-8" style="height: 70vh">
                    <img src="{{ asset('img/empty.jpg') }}" style="width: 100%; height: 100%; object-fit: contain;"
                        alt="">
                    <h6 class="text-center" style="font-weight: 700; color: #ccc">No question here</h6>
                </div>
            </div>
        @endif
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            // Mendapatkan elemen countdown
            var countdownElement = document.getElementById("countdown-{{ $quiz->quiz_id }}");

            // Memanggil API untuk mendapatkan data waktu dari backend
            function fetchCountdownTime() {
                $.get("/countdown/{{ $quiz->quiz_id }}", function(data) {
                    // Memperbarui teks pada elemen countdown dengan data waktu dari backend
                    countdownElement.innerHTML = formatTime(data.jam, data.menit, data.detik);

                    // Memulai hitung mundur
                    var countdownInterval = setInterval(function() {
                        // Mengurangi 1 detik
                        data.detik--;

                        // Memperbarui waktu jika detik menjadi negatif
                        if (data.detik < 0) {
                            data.detik = 59;
                            data.menit--;
                        }

                        if (data.menit < 0) {
                            data.menit = 59;
                            data.jam--;
                        }

                        // Memperbarui teks pada elemen countdown
                        countdownElement.innerHTML = formatTime(data.jam, data.menit, data.detik);

                        // Berhenti hitung mundur jika waktu telah habis
                        if (data.jam <= 0 && data.menit <= 0 && data.detik <= 0) {
                            clearInterval(countdownInterval);
                            countdownElement.innerHTML = "Waktu Habis!";

                            // Mengalihkan halaman setelah 3 detik
                            setTimeout(function() {
                                // window.location.href = "https://www.contoh.com/halaman-lain";
                                document.getElementById('save_mc').submit();
                            }, 1000);
                        }
                    }, 1000);
                });
            }

            // Fungsi untuk memformat waktu ke format hh:mm:ss
            function formatTime(jam, menit, detik) {
                return (jam < 10 ? "0" + jam : jam) + ":" +
                    (menit < 10 ? "0" + menit : menit) + ":" +
                    (detik < 10 ? "0" + detik : detik);
            }

            // Memanggil fungsi fetchCountdownTime saat halaman selesai dimuat
            $(document).ready(function() {
                fetchCountdownTime();
            });
        </script>
    @endpush
@endsection
