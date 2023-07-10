@extends('layouts.dash')

@section('dash-content')
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Semester</span>
                    <button class="btn btn-info" data-toggle="modal" data-target="#create">+ Create Semester</button>
                </div>
                <div class="modal fade" tabindex="-1" id="create" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header bg-info">
                          <h5 class="modal-title text-light">Create Semester</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                          <form action="/learning/create_semester" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body" style="overflow-y: auto">
                                <div class="col-md-12 mt-1 px-0">
                                  <label for="semester_tipe" class="mb-0">Semester:</label>
                                  <input type="text" required name="semester_tipe" id="semester_tipe" class="form-control" placeholder="ex. Semester 9">
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
                                    <th>No.</th>
                                    <th class="text-center">Semester</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semester as $item)
                                    <tr>
                                        <td>{{ $loop->iteration . ').' }}</td>
                                        <td class="text-center">{{ $item->semester_tipe }}</td>
                                        <td class="text-center">
                                            <button class="btn" data-toggle="modal" data-target="{{ '#hapus' . $item->semester_id }}">
                                                <i class="fa fa-trash text-danger"></i>
                                            </button>
                                            <button class="btn" data-toggle="modal" data-target="{{ '#edit' . $item->semester_id }}">
                                                <i class="fa fa-cog text-info"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- hapus modal --}}
                                    <div class="modal fade" id="{{ 'hapus' . $item->semester_id }}" tabindex="-1" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                <h5 class="modal-title text-light" id="createLabelModal">Perhatian !!!</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin untuk menghapus <strong>{{ $item->semester_tipe }} ? </strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <form action="{{ url('/learning/hapus_semester/'.$item->semester_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- update modal --}}
                                    <div class="modal fade" tabindex="-1" id="{{ 'edit' . $item->semester_id }}" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                          <div class="modal-content">
                                            <div class="modal-header bg-info">
                                              <h5 class="modal-title text-light">Edit Semester</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                              <form action="{{ url('/learning/update_semester/'.$item->semester_id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body" style="overflow-y: auto">
                                                    <div class="col-md-12 mt-1 px-0">
                                                      <label for="semester_tipe" class="mb-0">Semester:</label>
                                                      <input type="text" value="{{ $item->semester_tipe }}" required name="semester_tipe" id="semester_tipe" class="form-control" placeholder="ex. Semester 9">
                                                    </div>
                                                </div>
                                      
                                                <div class="modal-footer bg-whitesmoke br">
                                                  <button type="submit" class="btn btn-info">Update</button>
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