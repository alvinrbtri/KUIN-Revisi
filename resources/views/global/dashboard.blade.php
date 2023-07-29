@extends('layouts.dash')

@section('dash-content')
    <div class="container-fluid page__container">
        <div class="row">
            @if (auth()->user()->level == 'admin')
                <div class="col-md">
                    <div class="card card-stats">
                        <div class="d-flex align-items-center">
                            <div class="card-header__title flex">Students</div>
                            <span>{{ $jumlah_mahasiswa }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card card-stats">
                        <div class="d-flex align-items-center">
                            <div class="card-header__title flex">Lectures</div>
                            <span>{{ $jumlah_dosen }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card card-stats">
                        <div class="d-flex align-items-center">
                            <div class="card-header__title flex">Courses</div>
                            <span>{{ $jumlah_matkul }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->level == 'dosen')
                <div class="col-md-12">
                    <div class="card card-stats">
                        <div class="d-flex align-items-center">
                            <div class="card-header__title flex">Module</div>
                            <span>{{ $jumlah_modul }}</span>
                        </div>
                    </div>
                </div>
            @endif


        </div>

        <div class="row" style="row-gap: 15px">

            @if (auth()->user()->level == 'admin')
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data">
                                    <thead>
                                        <tr style="white-space: nowrap;">
                                            <th>#</th>
                                            <th>Profile</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Level</th>
                                            <th>Class</th>
                                            <th>Gender</th>
                                            <th>Place of birth</th>
                                            <th>Date of birth</th>
                                            <th>Telephone</th>
                                            <th>Province</th>
                                            <th>Regency/City</th>
                                            <th>Subdistrict</th>
                                            <th>Village</th>
                                            <th>Addres</th>
                                            <th>Semester</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr style="white-space: nowrap">
                                                <td>{{ $loop->iteration . '.' }}</td>
                                                <td>
                                                    <img src="@if ($user->image == 'default.png') {{ asset('img/default.png') }} @else {{ asset('storage/images/' . $user->image) }} @endif"
                                                        width="40" height="40" style="border-radius: 100%"
                                                        alt="">
                                                </td>
                                                <td>{{ $user->nama }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ ucfirst($user->level) }}</td>
                                                <td>
                                                    @if ($user->kelas_id != null)
                                                        {{ $user->kelas->nama_kelas }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ $user->jenis_kelamin }}</td>
                                                <td>{{ $user->tempat_lahir }}</td>
                                                <td>{{ $user->tanggal_lahir }}</td>
                                                <td>{{ $user->no_telepon }}</td>
                                                <td>{{ $user->provinsi }}</td>
                                                <td>{{ $user->kabupaten_kota }}</td>
                                                <td>{{ $user->kecamatan }}</td>
                                                <td>{{ $user->desa_kelurahan }}</td>
                                                <td>{{ $user->alamat }}</td>
                                                <td>{{ $user->semester_tipe }}</td>
                                                <td>
                                                    @if ($user->status == 'verified')
                                                        <span
                                                            class="bg-success rounded text-light px-3">{{ ucfirst($user->status) }}</span>
                                                    @else
                                                        <span
                                                            class="bg-danger rounded text-light px-3">{{ ucfirst($user->status) }}</span>
                                                    @endif

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->level == 'dosen')
                <div class="col-md">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>List Modul</span>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th>Class</th>
                                            <th>File Module</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($modul as $data)
                                            <tr>
                                                <td class="d-flex">
                                                    <div style="height: 70px; width: 50px;">
                                                        <img src="{{ asset('storage/images/' . $data->matkul->image) }}"
                                                            class="rounded"
                                                            style="width: 100%; height: 100%; object-fit: cover"
                                                            alt="">
                                                    </div>
                                                    <div class="ml-2 d-flex flex-column justify-content-center">
                                                        <p class="mb-0">{{ $data->nama_modul }}</p>
                                                        <p class="mb-0" style="font-size: 11px">
                                                            {{ $data->matkul->nama_matkul }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($data->kelas_id != null)
                                                        {{ $data->kelas->nama_kelas }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/images/' . $data->file_modul) }}"
                                                        target="_blank">
                                                        View Module
                                                    </a>
                                                    <!-- <a href="{{ Storage::url($data->file_modul) }}" target="_blank">-->
                                                    <!--    View Module-->
                                                    <!--</a>-->
                                                </td>
                                                <td>
                                                    {{ $data->deskripsi }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->level == 'mahasiswa')
                @foreach ($modul as $item)
                    {{-- <a href="{{ url('/learning/detail_modul/'.$item->modul_id) }}" class="col-md-4" style="text-decoration: none;"> --}}
                    <div class="card">
                        <div class="card-body p-0 bg-danger" style="height: 25vh;">
                            <img src="{{ asset('storage/images/' . $item->matkul->image) }}" title="{{ $item->nama_modul }}"
                                style="width: 100%; height: 100%;" alt="modul_image">
                        </div>
                        <div class="card-footer d-flex flex-column justify-content-between"
                            style="height: 25vh; overflow-y: auto">
                            <div class="">
                                <h6 class="text-muted">{{ $item->nama_modul }} - {{ $item->kelas->nama_kelas }}</h6>
                                <p style="color: #bbb">{{ $item->matkul->nama_matkul }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="@if ($item->matkul->dosen->image == 'default.png') {{ asset('img/default.png') }} @else {{ asset('storage/images/' . $item->matkul->dosen->image) }} @endif"
                                    style="height: 25px; width: 25px; border-radius: 100%;" alt="">
                                <span class="ml-2 text-muted">{{ $item->matkul->dosen->nama }}</span>
                            </div>
                        </div>
                    </div>
                    {{-- </a> --}}
                @endforeach

                @if ($modul->isEmpty())
                    <div class="col-12">
                        <p class="text-muted">There is no quizzes in your class yet !</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
