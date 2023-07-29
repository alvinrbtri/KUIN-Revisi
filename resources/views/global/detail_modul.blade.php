@extends('layouts.dash')

@section('dash-content')
    <div class="m-5">

        <!-- Tambahkan formulir untuk menambahkan video baru jika diperlukan -->
        {{-- <h3>Modul Utama</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4 h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $modul->nama_modul }}</h5>
                        <p class="card-text">{{ $modul->deskripsi }}</p>
                        <!-- Ubah tautan untuk menampilkan video -->
                        <video src="{{ Storage::url($modul->file_modul) }}" controls class="w-100"></video>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Tambahkan garis batas di bawah bagian pertama -->
        {{-- <hr>
        <h3>Modul Video</h3> --}}

        {{-- @foreach ($modul_video->where('modul_id', '=', $modul->modul_id) as $item) --}}
        @foreach ($modul_video as $item)
            <div class="col-md-4">
                <div class="card mb-4 h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nama_video }}</h5>
                        <p class="card-text">{{ $item->deskripsi }}</p>
                        <!-- Ubah tautan untuk menampilkan video -->
                        <video src="{{ Storage::url($item->file_modul) }}" controls class="w-100"></video>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
