@extends('layouts.dash')

@section('dash-content')
<div class="container-fluid page__container">
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Class</span>
                    <button class="btn" style="background: navy; color:white" data-toggle="modal" data-target="#create">+ Create Class</button>
                </div>
                <div class="modal fade" tabindex="-1" id="create" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header" style="background: navy">
                          <h5 class="modal-title text-light">Create Class</h5>
                          <button type="button" style="color: white" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                          <form action="/learning/create_kelas" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body" style="overflow-y: auto">
                                <div class="col-md-12 mt-1 px-0">
                                  <label for="nama_kelas" class="mb-0">Class:</label>
                                  <input type="text" required name="nama_kelas" id="nama_kelas" class="form-control" placeholder="ex. Kelas A">
                                </div>
                            </div>
                  
                            <div class="modal-footer bg-whitesmoke br">
                              <button type="submit" class="btn" style="background: navy; color:white">Submit</button>
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
                                    <th class="text-center">Class</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration . ').' }}</td>
                                        <td class="text-center">{{ $item->nama_kelas }}</td>
                                        <td class="text-center">
                                            <button class="btn" data-toggle="modal" data-target="{{ '#hapus' . $item->kelas_id }}">
                                                <i class="fa fa-trash text-danger"></i>
                                            </button>
                                            <button class="btn" data-toggle="modal" data-target="{{ '#edit' . $item->kelas_id }}">
                                                <i class="fa fa-cog" style="color: orange"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- hapus modal --}}
                                    <div class="modal fade" id="{{ 'hapus' . $item->kelas_id }}" tabindex="-1" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                <h5 class="modal-title text-light" id="createLabelModal">Attention Pleasee !!! </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body">
                                                   Are you sure to delete class data <strong>{{ $item->nama_kelas }} ?</strong>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <form action="{{ url('/learning/hapus_kelas/'.$item->kelas_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- update modal --}}
                                    <div class="modal fade" tabindex="-1" id="{{ 'edit' . $item->kelas_id }}" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                          <div class="modal-content">
                                            <div class="modal-header" style="background: orange">
                                              <h5 class="modal-title text-light">Class Edit</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                              <form action="{{ url('/learning/update_kelas/'.$item->kelas_id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body" style="overflow-y: auto">
                                                    <div class="col-md-12 mt-1 px-0">
                                                      <label for="nama_kelas" class="mb-0">Class:</label>
                                                      <input type="text" value="{{ $item->nama_kelas }}" required name="nama_kelas" id="nama_kelas" class="form-control" placeholder="ex. Kelas A">
                                                    </div>
                                                </div>
                                      
                                                <div class="modal-footer bg-whitesmoke br">
                                                  <button type="submit" class="btn" style="background: orange; color:white">Update</button>
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