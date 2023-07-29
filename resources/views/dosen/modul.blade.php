@extends('layouts.dash')

@section('dash-content')
    <div class="container-fluid page__container">
        <div class="row" style="row-gap: 15px;">

            @if (auth()->user()->level == 'mahasiswa')
                <div class="col-12 px-0">
                    <h5>{{ auth()->user()->kelas->nama_kelas }} | {{ auth()->user()->semester->semester_tipe }}</h5>
                </div>
            @endif

            {{-- dosen privilege --}}
            @if (auth()->user()->level == 'dosen')
                <div class="col-md">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>List Modul</span>
                            <button class="btn" style="background: navy; color: #fff;" data-toggle="modal"
                                data-target="#create">+ Create Modul</button>
                        </div>
                        <div class="modal fade" tabindex="-1" id="create" data-backdrop="false"
                            style="background-color: rgba(0, 0, 0, 0.5);">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: navy">
                                        <h5 class="modal-title text-light">Create Modul</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                            style="color: #fff;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="/learning/create_modul" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body" style="overflow-y: auto">
                                            <div class="col-md-12 mt-1 px-0">
                                                <label for="matkul_id" class="mb-0">Mata Kuliah:</label>
                                                <select name="matkul_id" class="form-control" required id="matkul_id">
                                                    <option value="">Pilih Mata Kuliah</option>
                                                    @foreach ($matkul as $item)
                                                        <option value="{{ $item->matkul_id }}">{{ $item->nama_matkul }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 mt-3 px-0">
                                                <label for="kelas_id" class="mb-0">Kelas:</label>
                                                <select name="kelas_id" class="form-control" required id="kelas_id">
                                                    <option value="">Pilih Kelas</option>
                                                    @foreach ($kelas as $item)
                                                        <option value="{{ $item->kelas_id }}">{{ $item->nama_kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 mt-3 px-0">
                                                <label for="nama_modul" class="mb-0">Nama Modul:</label>
                                                <input type="text" required name="nama_modul" id="nama_modul"
                                                    class="form-control" placeholder="ex. Algoritma dan Pemrograman">
                                            </div>

                                            <div class="col-md-12 mt-3 px-0">
                                                <label for="file_modul" class="mb-0">File:</label>
                                                <input type="file" required name="file_modul" accept=".pdf, .docx, .doc"
                                                    id="file_modul" class="form-control"
                                                    placeholder="ex. Algoritma dan Pemrograman">
                                            </div>

                                            <div class="col-md-12 mt-3 px-0">
                                                <label for="deskripsi" class="mb-0">Deskripsi:</label>
                                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required placeholder="Deskripsikan modul"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer bg-whitesmoke br">
                                            <button type="submit" class="btn"
                                                style="background: navy; color: #fff;">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data">
                                    <thead>
                                        <tr>
                                            <th>Modul</th>
                                            <th>Kelas</th>
                                            <th>File Modul</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($modul as $data)
                                            <tr>
                                                <td class="d-flex">
                                                    <div style="height: 70px; width: 50px;">
                                                        <img src="{{ asset('storage/images/' . $data->matkul->image) }}"
                                                            class="rounded"
                                                            style="width: 100%; height: 100%; object-fit: contain;"
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
                                                    <a href="{{ Storage::url($data->file_modul) }}"
                                                        target="_blank">
                                                        <i class="fa fa-eye text-success" style="font-size: 12px"> lihat
                                                            modul</i>
                                                    </a>
                                                </td>
                                                <td>
                                                    {{ $data->deskripsi }}
                                                </td>
                                                <td>
                                                    {{-- <a href="{{ route('modul_video', $data->modul_id) }}" class="btn btn-info">
                                      Isi Video
                                    </a> --}}
                                                    <a href="{{ route('modul_video', ['id' => $data->modul_id]) }}"
                                                        class="btn">
                                                        <i class="fa fa-plus text-info" style="font-size: 12px"> tambah
                                                            video</i>
                                                    </a>

                                                    <button class="btn" data-toggle="modal"
                                                        data-target="{{ '#hapus' . $data->modul_id }}">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </button>
                                                    <button class="btn" data-toggle="modal"
                                                        data-target="{{ '#edit' . $data->modul_id }}">
                                                        <i class="fa fa-cog" style="color: orange"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            {{-- hapus modal --}}
                                            <div class="modal fade" id="{{ 'hapus' . $data->modul_id }}" tabindex="-1"
                                                data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header  bg-danger">
                                                            <h5 class="modal-title" id="createLabelModal"
                                                                style="color: #fff">Perhatian</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close" style="color: #fff">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin untuk menghapus <strong>{{ $data->nama_modul }}</strong>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <form
                                                                action="{{ url('/learning/delete_modul_video/' . $data->modul_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" tabindex="-1" id="{{ 'edit' . $data->modul_id }}"
                                                data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                                <div class="modal-dialog modal-md modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background: orange">
                                                            <h5 class="modal-title text-light">Edit Modul</h5>
                                                            <button type="button" style="color: #fff" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ '/learning/update_modul/' . $data->modul_id }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="modal-body" style="overflow-y: auto">
                                                                <div class="col-md-12 mt-1 px-0">
                                                                    <label for="matkul_id" class="mb-0">Mata
                                                                        Kuliah:</label>
                                                                    <select name="matkul_id" class="form-control" required
                                                                        id="matkul_id">
                                                                        <option value="{{ $data->matkul_id }}">
                                                                            {{ $data->matkul->nama_matkul }}</option>
                                                                        <option value="">Pilih Mata Kuliah</option>
                                                                        @foreach ($matkul as $item)
                                                                            <option value="{{ $item->matkul_id }}">
                                                                                {{ $item->nama_matkul }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-12 mt-3 px-0">
                                                                    <label for="kelas_id" class="mb-0">Kelas:</label>
                                                                    <select name="kelas_id" class="form-control" required
                                                                        id="kelas_id">
                                                                        @if ($data->kelas_id != null)
                                                                            <option value="{{ $data->kelas_id }}">
                                                                                {{ $data->kelas->nama_kelas }}</option>
                                                                        @endif
                                                                        <option value="">Pilih Kelas</option>
                                                                        @foreach ($kelas as $item)
                                                                            <option value="{{ $item->kelas_id }}">
                                                                                {{ $item->nama_kelas }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-12 mt-3 px-0">
                                                                    <label for="nama_modul" class="mb-0">Nama
                                                                        Modul:</label>
                                                                    <input type="text" required name="nama_modul"
                                                                        id="nama_modul" class="form-control"
                                                                        placeholder="ex. Algoritma dan Pemrograman"
                                                                        value="{{ $data->nama_modul }}">
                                                                </div>

                                                                <div class="col-md-12 mt-3 px-0">
                                                                    <label for="file_modul" class="mb-0">File:</label>
                                                                    <input type="file" name="file_modul"
                                                                        accept=".pdf, .docx, .doc" id="file_modul"
                                                                        class="form-control"
                                                                        placeholder="ex. Algoritma dan Pemrograman">
                                                                </div>

                                                                <div class="col-md-12 mt-3 px-0">
                                                                    <label for="deskripsi"
                                                                        class="mb-0">Descripsi:</label>
                                                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required
                                                                        placeholder="Deskripsikan modul">{{ $data->deskripsi }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer bg-whitesmoke br">
                                                                <button type="submit" class="btn"
                                                                    style="background: orange; color: white">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif




            {{-- mahasiswa privilege --}}
            @if (auth()->user()->level != 'dosen')
                @foreach ($modul as $item)
                    <div class="card col-md-4 d-flex align-items-stretch h-100">
                        <div class="card-body p-0 bg-danger" style="height: 150px;">
                            <img src="{{ asset('storage/images/' . $item->matkul->image) }}"
                                title="{{ $item->nama_modul }}" style="width: 100%; height: 100%; object-fit: cover;"
                                alt="modul_image">
                        </div>
                        <div class="card-footer d-flex flex-column justify-content-between">
                            <div class="text-center">
                                <h6 class="text-muted">{{ $item->nama_modul }} - {{ $item->nama_kelas }}</h6>
                                <p style="color: #bbb">{{ $item->matkul->nama_matkul }}</p>
                            </div>
                            <div class="text-center">
                                <img src="@if ($item->matkul->dosen->image == 'default.png') {{ asset('img/default.png') }} @else {{ asset('storage/images/' . $item->matkul->dosen->image) }} @endif"
                                    style="height: 25px; width: 25px; border-radius: 100%;" alt="">
                                <span class="ml-2 text-muted">{{ $item->matkul->dosen->nama }}</span>
                            </div>
                            <div class="text-center mt-2">
                                <!--<a href="{{ asset('storage/images/' . $item->file_modul) }}" target="_blank"-->
                                <!--    class="btn btn-primary btn-md">Lihat Modul</a>-->
                                                                <a href="{{ Storage::url($item->file_modul) }}" target="_blank"
                                    class="btn btn-primary btn-md">Lihat Modul</a>
                                <a href="{{ route('modul_video.show', $item->modul_id) }}"
                                    class="btn btn-primary btn-md">Lihat Video</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($modul->isEmpty())
                    <p class="text-muted">Belum ada modul di kelas anda</p>
                @endif
            @endif
        </div>
    </div>




@endsection
