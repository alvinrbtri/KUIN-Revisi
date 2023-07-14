@extends('layouts.dash')

@section('dash-content')
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Mata Kuliah </span>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#create">+ Tambah Matkul</button>
                    </div>
                    <div class="modal fade" tabindex="-1" id="create" data-backdrop="false"
                        style="background-color: rgba(0, 0, 0, 0.5);">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content" style="height:95svh; overflow-y: auto;">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title text-light">Tambah Matkul</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/learning/create_matkul" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body" style="overflow-y: auto">
                                        <div class="col-md-12 mt-1 px-0">
                                            <label for="dosen_id" class="mb-0">Dosen:</label>
                                            <select name="dosen_id" class="form-control" required id="dosen_id">
                                                <option value="">Pilih Dosen</option>
                                                @foreach ($dosen as $item)
                                                    <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="image" class="mb-0">Cover Matkul:</label>
                                            <input type="file" required name="image" id="image"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="nama_matkul" class="mb-0">Nama Matkul:</label>
                                            <input type="text" required name="nama_matkul"
                                                placeholder="Masukkan nama matkul" id="nama_matkul" class="form-control">
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="semester_id" class="mb-0">Semester:</label>
                                            <select name="semester_id" class="form-control" required id="semester_id">
                                                <option value="">Pilih Semester</option>
                                                @foreach ($semester as $item)
                                                    <option value="{{ $item->semester_id }}">{{ $item->semester_tipe }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="deskripsi" class="mb-0">Deskripsi:</label>
                                            <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsikan mata kuliah" required
                                                rows="5"></textarea>
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="status" class="mb-0">Status:</label>
                                            <select name="status" class="form-control" required id="status">
                                                <option value="">Pilih Status</option>
                                                <option value="aktif">Aktif</option>
                                                <option value="nonaktif">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer bg-whitesmoke br">
                                        <button type="submit" class="btn btn-info">Selesai</button>
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
                                        <th>Matkul</th>
                                        <th>Dosen Pengajar</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($matkul as $data)
                                        <tr>
                                            <td class="d-flex">
                                                <div style="height: 70px; width: 50px;">
                                                    <img src="{{ asset('storage/images/' . $data->image) }}" class="rounded"
                                                        style="width: 100%; height: 100%; object-fit: cover" alt="">
                                                </div>
                                                <div class="ml-2 d-flex flex-column justify-content-center">
                                                    <p class="mb-0">{{ $data->nama_matkul }}</p>
                                                    <p class="mb-0" style="font-size: 11px">
                                                        {{ $data->semester->semester_tipe }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $data->dosen->nama }}
                                            </td>
                                            <td>
                                                {{ $data->deskripsi }}
                                            </td>
                                            <td>
                                                @if ($data->status == 'aktif')
                                                    <span
                                                        class="rounded bg-success px-3 text-light">{{ ucfirst($data->status) }}</span>
                                                @else
                                                    <span
                                                        class="rounded bg-danger px-3 text-light">{{ ucfirst($data->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn" data-toggle="modal"
                                                    data-target="{{ '#hapus' . $data->matkul_id }}">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                                <button class="btn" data-toggle="modal"
                                                    data-target="{{ '#edit' . $data->matkul_id }}">
                                                    <i class="fa fa-cog text-info"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- hapus modal --}}
                                        <div class="modal fade" id="{{ 'hapus' . $data->matkul_id }}" tabindex="-1"
                                            data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title text-light" id="createLabelModal">Perhatian
                                                            !!! - {{ $data->matkul_id }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin untuk menghapus mata kuliah
                                                        <strong>{{ $data->nama_matkul }} ?</strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <form
                                                            action="{{ url('/learning/hapus_matkul/' . $data->matkul_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" tabindex="-1" id="{{ 'edit' . $data->matkul_id }}"
                                            data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content" style="height:95svh; overflow-y: auto;">
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title text-light">Edit Matkul</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ '/learning/update_matkul/' . $data->matkul_id }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body" style="overflow-y: auto">
                                                            <div class="col-md-12 mt-1 px-0">
                                                                <label for="dosen_id" class="mb-0">Dosen:</label>
                                                                <select name="dosen_id" class="form-control" required
                                                                    id="dosen_id">
                                                                    <option value="{{ $data->dosen_id }}">
                                                                        {{ $data->dosen->nama }}</option>
                                                                    <option value="">Pilih Dosen</option>
                                                                    @foreach ($dosen as $item)
                                                                        <option value="{{ $item->user_id }}">
                                                                            {{ $item->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="image" class="mb-0">Cover Matkul:</label>
                                                                <input type="file" name="image" id="image"
                                                                    class="form-control">
                                                            </div>

                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="nama_matkul" class="mb-0">Nama
                                                                    Matkul:</label>
                                                                <input type="text" required name="nama_matkul"
                                                                    placeholder="Masukkan nama matkul" id="nama_matkul"
                                                                    class="form-control"
                                                                    value="{{ $data->nama_matkul }}">
                                                            </div>

                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="semester_id" class="mb-0">Semester:</label>
                                                                <select name="semester_id" class="form-control" required
                                                                    id="semester_id">
                                                                    <option value="{{ $data->semester_id }}">
                                                                        {{ $data->semester->semester_tipe }}</option>
                                                                    <option value="">Pilih Semester</option>
                                                                    @foreach ($semester as $item)
                                                                        <option value="{{ $item->semester_id }}">
                                                                            {{ $item->semester_tipe }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="deskripsi" class="mb-0">Deskripsi:</label>
                                                                <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsikan mata kuliah" required
                                                                    rows="5">{{ $data->deskripsi }}</textarea>
                                                            </div>

                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="status" class="mb-0">Status:</label>
                                                                <select name="status" class="form-control" required
                                                                    id="status">
                                                                    <option value="{{ $data->status }}">
                                                                        {{ ucfirst($data->status) }}</option>
                                                                    <option value="">Pilih Status</option>
                                                                    <option value="aktif">Aktif</option>
                                                                    <option value="nonaktif">Nonaktif</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer bg-whitesmoke br">
                                                            <button type="submit" class="btn btn-info">Perbarui</button>
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
        </div>
    </div>
@endsection
