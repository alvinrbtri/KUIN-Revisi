@extends('layouts.quiz')

@section('quiz-content')

    <div class="container-fluid">
        <div class="row mx-2 mt-5">
            <div class="col-md d-flex flex-row justify-content-between h3">
                <div>
                    {{ $quiz->quiz_name }}
                </div>

                <div id="countdown-{{ $quiz->quiz_id }}" class="position-fixed d-flex justify-content-end" style="width: 96%; z-index: 10">00:00:00</div>

            </div>
            <hr>
        </div>
        <div class="row mx-2">
            <form action="{{ url('/draggable/save_answer/' . $quiz->quiz_id) }}" class="col-md-8" method="POST" id="save_draggable">
                @csrf
                <div class="col-12" style="height: 100vh; overflow-y: auto">
                    @foreach ($draggable as $item)           
                        <input type="hidden" name="{{ 'user_id-' . $item->draggable_id }}" value="{{ auth()->user()->user_id }}"> 
                        <div class="card mb-5" style="border: 0.7px solid #ddd;">
                            <div class="card-header text-light d-flex justify-content-between align-items-center" style="border: none; background: #585656">
                                <h4 style="font-weight: bold">Soal#{{ $loop->iteration }}</h4>
                                <p class="mb-0">Poin: {{ $item->draggable_poin }}</p>
                            </div>
                            <div class="card-body">
                                {{ $item->draggable_question }}
        
                                @if ($item->draggable_image != null)
                                <div class="mt-3 bg-secondary rounded" style="height: 30vh">
                                    <img src="{{ asset('storage/images/quiz/'.$item->draggable_image) }}" style="width: 100%; height: 100%; object-fit: contain" alt="">
                                </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                @foreach ($options as $option)
                                    @if ($item->draggable_id == $option->draggable_id)
                                    <input type="hidden" name="{{ 'draggable_answer-'.$item->draggable_id }}" value="{{ $option->draggable_answer }}">
                                    @endif
                                @endforeach
                                <input type="hidden" name="{{ 'draggable_poin-'.$item->draggable_id }}" value="{{ $item->draggable_poin }}">
                                <input type="text" class="name-input form-control text-center text-dark" name="{{ 'answer-'.$item->draggable_id }}" id="" readonly placeholder="Drop kesini jawaban anda" style="border: none; background: transparent;">
                                <p class="text-center mt-3 mb-0">
                                    <button type="button" class="enable-button btn btn-danger" data-index="{{ $item->draggable_id }}" style="font-size: 12px">Remove</button>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                <button type="submit" class="btn my-5 px-5 btn-success">Submit</button>
            </form>

            <div class="col-md-4">
                <div class="card" style="height: 70vh; overflow-y: auto; border: 1.6px dashed #ccc;">
                    <div class="card-body">
                        <h6 class="mb-3" style="font-weight: 600;">
                            <u>Options</u>
                        </h6>
                        @foreach ($options as $option)
                            <div class="drag-item px-2 py-1 mb-3" style="background: #eee; border-radius: 2px" draggable="true">{{ $option->draggable_answer }}</div>
                        @endforeach
                    </div>
                </div>
            </div>


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
                            document.getElementById('save_draggable').submit();
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
@endsection