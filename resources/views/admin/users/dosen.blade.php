@extends('layouts.dash')

@section('dash-content')
    <div class="container-fluid page__container">
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Data Dosen</span>
                        <button class="btn btn-info" data-toggle="modal" data-target="#create" >+ Tambah
                            Dosen</button>
                    </div>
                    <div class="modal fade" tabindex="-1" id="create" data-backdrop="false"
                        style="background-color: rgba(0, 0, 0, 0.5);">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title text-light">Tambah Dosen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/users/create_user" method="POST">
                                    @csrf
                                    <div class="modal-body" style="height: 70vh; overflow-y: auto">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="nama" class="mb-0">Nama:</label>
                                                <input type="text" required placeholder="Enter nama" class="form-control"
                                                    name="nama" id="nama">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="username" class="mb-0">Username:</label>
                                                <input type="text" required placeholder="Enter username"
                                                    class="form-control" name="username" id="username">
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="email" class="mb-0">Email:</label>
                                            <input type="email" required name="email" id="email"
                                                class="form-control" placeholder="example@gmail.com">
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="level" class="mb-0">Level:</label>
                                            <select name="level" id="level" class="form-control">
                                                <option value="dosen" selected>Dosen</option>
                                            </select>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label for="jenis_kelamin" class="mb-0">Jenis Kelamin:</label>
                                                <p>
                                                    <input type="radio" value="Laki-Laki" required name="jenis_kelamin"
                                                        id="jenis_kelamin"> Laki-Laki
                                                    <input type="radio" value="Perempuan" name="jenis_kelamin"
                                                        id="jenis_kelamin"> Perempuan
                                                </p>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="nip" class="mb-0">NIP</label>
                                                <input type="text" required placeholder="NIP" class="form-control"
                                                    name="nip" id="nip">
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="no_telepon" class="mb-0">No. Telepon:</label>
                                            <input type="no_telepon" required name="no_telepon" id="no_telepon"
                                                class="form-control" placeholder="0823****8921">
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
                                    <tr style="white-space: nowrap;">
                                        <th>Profil</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>NIP</th>
                                        <th>Email</th>
                                        <th>Level</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                        <tr style="white-space: nowrap">


                                            {{-- hapus modal --}}
                                            <div class="modal fade" id="{{ 'hapus' . $user->user_id }}" tabindex="-1"
                                                data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title text-light" id="createLabelModal">Perhatian !!!</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah Anda yakin untuk menghapus dosen
                                                            <strong>{{ $user->username }} ?</strong>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <form action="{{ url('/users/hapus_user/' . $user->user_id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- edit modal --}}
                                            <div class="modal fade" tabindex="-1" id="{{ 'edit' . $user->user_id }}"
                                                data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title text-light">Edit Dosen</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ url('/users/update_user/' . $user->user_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="modal-body"
                                                                style="height: 70vh; overflow-y: auto">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label for="nama" class="mb-0">Nama:</label>
                                                                        <input type="text" value="{{ $user->nama }}"
                                                                            required placeholder="Enter nama"
                                                                            class="form-control" name="nama"
                                                                            id="nama">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="username"
                                                                            class="mb-0">Username:</label>
                                                                        <input type="text"
                                                                            value="{{ $user->username }}" required
                                                                            placeholder="Enter username"
                                                                            class="form-control" name="username"
                                                                            id="username">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 mt-3 px-0">
                                                                    <label for="email" class="mb-0">Email:</label>
                                                                    <input type="email" value="{{ $user->email }}"
                                                                        required name="email" id="email"
                                                                        class="form-control"
                                                                        placeholder="example@gmail.com">
                                                                </div>

                                                                <div class="col-md-12 mt-3 px-0">
                                                                    <label for="level" class="mb-0">Level:</label>
                                                                    <select name="level" id="level"
                                                                        class="form-control">
                                                                        <option value="dosen" selected>Dosen</option>
                                                                    </select>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="col-md-4">
                                                                        <label for="jenis_kelamin" class="mb-0">Jenis
                                                                            Kelamin:</label>
                                                                        <p>
                                                                            <input type="radio" value="Laki-Laki"
                                                                                @if ($user->jenis_kelamin == 'Laki-Laki') checked @endif
                                                                                required name="jenis_kelamin"
                                                                                id="jenis_kelamin"> Laki-Laki
                                                                            <input type="radio" value="Perempuan"
                                                                                @if ($user->jenis_kelamin == 'Perempuan') checked @endif
                                                                                name="jenis_kelamin" id="jenis_kelamin">
                                                                            Perempuan
                                                                        </p>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="nip" class="mb-0">NIP:</label>
                                                                        <input type="text" value="{{ $user->nip }}"
                                                                            required placeholder="NIP"
                                                                            class="form-control" name="nip"
                                                                            id="nip">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 mt-3 px-0">
                                                                    <label for="no_telepon" class="mb-0">No.
                                                                        Telepon:</label>
                                                                    <input type="no_telepon"
                                                                        value="{{ $user->no_telepon }}" required
                                                                        name="no_telepon" id="no_telepon"
                                                                        class="form-control" placeholder="0823****8921">
                                                                </div>

                                                            </div>

                                                            <div class="modal-footer bg-whitesmoke br">
                                                                <button type="submit"
                                                                    class="btn btn-info">Perbarui</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <td>
                                                <img src="@if ($user->image == 'default.png') {{ asset('img/default.png') }} @else {{ asset('storage/images/' . $user->image) }} @endif"
                                                    width="40" height="40" style="border-radius: 100%"
                                                    alt="">
                                            </td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->nip }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ ucfirst($user->level) }}</td>
                                            <td>{{ $user->jenis_kelamin }}</td>
                                            <td>
                                                @if ($user->status == 'terverifikasi')
                                                    <span
                                                        class="bg-success rounded text-light px-3">{{ ucfirst($user->status) }}</span>
                                                @else
                                                    <span
                                                        class="bg-danger rounded text-light px-3">{{ ucfirst($user->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn text-danger" data-toggle="modal"
                                                    data-target="{{ '#hapus' . $user->user_id }}"><i
                                                        class="fa fa-trash"></i></button>
                                                <button class="btn text-info" data-toggle="modal"
                                                    data-target="{{ '#edit' . $user->user_id }}"><i
                                                        class="fa fa-cog"></i></button>
                                            </td>

                                        </tr>
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
