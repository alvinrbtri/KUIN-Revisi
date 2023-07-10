@extends('layouts.dash')

@section('dash-content')
    <div class="row mx-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12 d-flex">
                        <div class="bg-danger d-flex justify-content-center ali" style="height: 100px; width: 100px; border-radius: 100%">
                            <img src="@if(auth()->user()->image == 'default.png') {{ asset('img/default.png') }} @else {{ asset('storage/images/'.auth()->user()->image) }} @endif" style="width: 100%; height: 100%; object-fit: cover" alt="">
                        </div>
                        <div class="ml-3 d-flex flex-column justify-content-center">
                            <h4>{{ auth()->user()->nama }}</h4>
                            <p class="text-muted mb-1">{{ ucfirst(auth()->user()->level) }}</p>
                            <p class="mb-2" style="color: #bbb">{{ auth()->user()->email }} | {{ auth()->user()->no_telepon }}</p>
                        </div> 
                    </div>
                    <hr>

                    <form action="/setting/handle_update_profil" class="col-12" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-2">
                            <label for="image">Profil Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="username">Username:</label>
                            <input type="text" required name="username" id="username" placeholder="Masukkan username" value="{{ auth()->user()->username }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="nama">Nama:</label>
                            <input type="text" required name="nama" id="nama" placeholder="Masukkan nama" value="{{ auth()->user()->nama }}" class="form-control">
                        </div>

                        @if (auth()->user()->level == 'mahasiswa')
                            
                        <div class="mt-3">
                            <label>Kelas:</label>
                            <input type="text" disabled value="@if(auth()->user()->kelas_id != null) {{ auth()->user()->kelas->nama_kelas }} @else Belum ada kelas @endif" class="form-control">
                        </div>

                        @endif

                        <div class="mt-3">
                            <label for="tempat_lahir">Tempat Lahir:</label>
                            <input type="text" required name="tempat_lahir" id="tempat_lahir" placeholder="Masukkan tempat lahir" value="{{ auth()->user()->tempat_lahir }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="tanggal_lahir">Tanggal Lahir:</label>
                            <input type="date" required name="tanggal_lahir" id="tanggal_lahir" value="{{ auth()->user()->tanggal_lahir }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="no_telepon">No. Telepon:</label>
                            <input type="number" min="0" required name="no_telepon" id="no_telepon" placeholder="Masukkan no telepon" value="{{ auth()->user()->no_telepon }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="provinsi">Provinsi:</label>
                            <input type="text" required name="provinsi" id="provinsi" placeholder="Masukkan provinsi" value="{{ auth()->user()->provinsi }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="kabupaten_kota">Kabupaten/Kota:</label>
                            <input type="text" required name="kabupaten_kota" id="kabupaten_kota" placeholder="Masukkan kabupaten/kota" value="{{ auth()->user()->kabupaten_kota }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="kecamatan">Kecamatan:</label>
                            <input type="text" required name="kecamatan" id="kecamatan" placeholder="Masukkan kecamatan" value="{{ auth()->user()->kecamatan }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="desa_kelurahan">Desa/Kelurahan:</label>
                            <input type="text" required name="desa_kelurahan" id="desa_kelurahan" placeholder="Masukkan desa/kelurahan" value="{{ auth()->user()->desa_kelurahan }}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="alamat">Alamat:</label>
                            <input type="text" required name="alamat" id="alamat" placeholder="Masukkan alamat" value="{{ auth()->user()->alamat }}" class="form-control">
                        </div>

                        <div class="mt-5">
                            <p class="text-left">
                                <button type="submit" class="btn p-2 btn-info" style="width: 100%">Update Profil</button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection