@extends('layouts.dash')

@section('dash-content')
    <div class="container">
        <h1>Modul Video {{ $modul->modul_id }}</h1>

        <!-- Tambahkan formulir untuk menambahkan video baru jika diperlukan -->
        <div class="row">
            @foreach($modul_video as $video)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $video->nama_video }}</h5>
                            <p class="card-text">{{ $video->deskripsi }}</p>
                            <!-- Tambahkan tautan untuk menampilkan video -->
                            <a href="{{ Storage::url($video->file_modul) }}" class="btn btn-primary">Lihat Video</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
