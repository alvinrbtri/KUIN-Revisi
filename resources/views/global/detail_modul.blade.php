@extends('layouts.dash')

@section('dash-content')
    <div class="container">

        <!-- Tambahkan formulir untuk menambahkan video baru jika diperlukan -->
        <div class="row">
            @foreach($modul_video as $video)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $video->nama_video }}</h5>
                            <p class="card-text">{{ $video->deskripsi }}</p>
                            <!-- Ubah tautan untuk menampilkan video -->
                            <video src="{{ Storage::url($video->file_modul) }}" controls class="w-100"></video>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
