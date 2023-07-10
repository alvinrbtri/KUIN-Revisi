@extends('layouts.dash')

@section('dash-content')
    <div class="container-fluid page__container">
        <div class="row" style="row-gap: 15px;">

            <div class="col-md">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ URL::previous() }}" class="btn btn-dark" style="font-size: 12px">Kembali</a>

                        <button class="btn btn-info" data-toggle="modal" data-target="#create{{ $modul->modul_id }}">+ Create
                            Modul Video</button>
                    </div>

                    <div class="modal fade" tabindex="-1" id="create{{ $modul->modul_id }}" data-backdrop="false"
                        style="background-color: rgba(0, 0, 0, 0.5);">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title text-light">Create Modul Video - {{ $modul->modul_id }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('modul_video.store', $modul->modul_id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body" style="overflow-y: auto">

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="modul_id" class="mb-0">Modul ID:</label>
                                            <input type="text" required name="modul_id" id="modul_id"
                                                value="{{ $modul->modul_id }}" class="form-control"
                                                placeholder="ex. Algoritma dan Pemrograman">
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="nama_video" class="mb-0">Nama Modul Video:</label>
                                            <input type="text" required name="nama_video" id="nama_video"
                                                class="form-control" placeholder="ex. Algoritma dan Pemrograman">
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="file_modul" class="mb-0">File:</label>
                                            <div id="dropzone" class="dropzone">
                                                <span class="dropzone-text"></span>
                                            </div>
                                            <input type="file" multiple name="file_modul" accept=".mp4, .docx, .doc"
                                                id="file_modul" class="form-control"
                                                placeholder="ex. Algoritma dan Pemrograman">
                                        </div>

                                        <div class="col-md-12 mt-3 px-0">
                                            <label for="deskripsi" class="mb-0">Deskripsi:</label>
                                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required
                                                placeholder="Deskripsikan modul Video"></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer bg-whitesmoke br">
                                        <button type="submit" class="btn btn-success">Submit</button>
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
                                        <th>Modul Video</th>
                                        <th>Deskripsi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($modul_video as $data)
                                        <tr>
                                            <td class="d-flex">
                                                {{ $data->nama_video }}
                                            </td>
                                            <td>
                                                {{ $data->deskripsi }}
                                            </td>
                                            <td>
                                              <a href="{{ Storage::url($data->file_modul) }}" class="btn">
                                                <i class="fa fa-eye text-success" style="font-size: 12px"> lihat video</i>
                                              </a>
                                                <button class="btn" data-toggle="modal"
                                                    data-target="#delete{{ $data->id }}">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                                <button class="btn" data-toggle="modal"
                                                    data-target="#edit{{ $data->id }}">
                                                    <i class="fa fa-cog text-info"></i>
                                                </button>
                                            </td>
                                        </tr>


                                        <div class="modal fade" id="delete{{ $data->id }}" tabindex="-1"
                                            data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="createLabelModal">Perhatian</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Yakin untuk menghapus <strong>{{ $data->nama_video }}</strong>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <form action="{{ route('delete_modul_video', $data->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="modal fade" tabindex="-1" id="edit{{ $modul_video->id }}" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                      <div class="modal-dialog modal-md modal-dialog-centered">
                                        <div class="modal-content">
                                          <div class="modal-header bg-info">
                                            <h5 class="modal-title text-light">Edit Modul Video</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                            <form action="{{'/learning/update_modul_video/'.$data->modul_video_id}}" method="POST" enctype="multipart/form-data">
                                              @csrf
                                              <div class="modal-body" style="overflow-y: auto">
                                                  
                  
                                                  <div class="col-md-12 mt-3 px-0">
                                                    <label for="nama_video" class="mb-0">Nama Video:</label>
                                                    <input type="text" required name="nama_video" id="nama_video" class="form-control" placeholder="ex. Algoritma dan Pemrograman" value="{{ $data->nama_video }}">
                                                  </div>
                  
                                                  <div class="col-md-12 mt-3 px-0">
                                                    <label for="file_modul" class="mb-0">File:</label>
                                                    <input type="file" name="file_modul_video" accept=".mp4, .web" id="file_modul_vide" class="form-control" placeholder="ex. Algoritma dan Pemrograman">
                                                  </div>
                  
                                                  <div class="col-md-12 mt-3 px-0">
                                                    <label for="deskripsi" class="mb-0">Deskripsi:</label>
                                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required placeholder="Deskripsikan modul Video">{{ $data->deskripsi }}</textarea>
                                                  </div>
                                              </div>
                                    
                                              <div class="modal-footer bg-whitesmoke br">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                              </div>
                                            </form>
                                        </div>
                                      </div>
                                  </div>           --}}

                                        <div class="modal fade" tabindex="-1" id="edit{{ $data->id }}"
                                            data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                            <div class="modal-dialog modal-md modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title text-light">Edit Modul Video</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('UpdateModulVideo', $data->id) }}"
                                                        method="PUT" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body" style="overflow-y: auto">
                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="nama_video" class="mb-0">Nama Video:</label>
                                                                <input type="text" required name="nama_video"
                                                                    id="nama_video" class="form-control"
                                                                    placeholder="ex. Algoritma dan Pemrograman"
                                                                    value="{{ $data->nama_video }}">
                                                            </div>
                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="file_modul" class="mb-0">File:</label>
                                                                <input type="file" name="file_modul"
                                                                    accept=".mp4, .web" id="file_modul"
                                                                    class="form-control"
                                                                    placeholder="ex. Algoritma dan Pemrograman">
                                                            </div>
                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="deskripsi" class="mb-0">Deskripsi:</label>
                                                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required
                                                                    placeholder="Deskripsikan modul Video">{{ $data->deskripsi }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-whitesmoke br">
                                                            <button type="submit" class="btn btn-success">Submit</button>
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
