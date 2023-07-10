@extends('layouts.dash')

@section('dash-content')
    <div class="row mx-2">
        <div class="col-md">
            <div class="card" style="border-top: 4px solid #123088">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md d-flex justify-content-between align-items-center">
                            <h6 style="font-weight: 600">Quiz Management</h6>
                            <button class="btn btn-light px-4" data-toggle="modal" data-target="#create" style="border: 1px solid #ccc">Create Quiz</button>
                        </div>
                    </div>

                    <div class="modal fade" tabindex="-1" id="create" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header" style="background: navy">
                              <h5 class="modal-title text-light">Create Quiz</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                              <form action="/create_quiz" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body" style="overflow-y: auto">
      
                                    <div class="col-md-12 mt-1 px-0">
                                      <label for="quiz_name" class="mb-0">Quiz Name:</label>
                                      <input type="text" required name="quiz_name" id="quiz_name" class="form-control" placeholder="Enter name of quiz">
                                    </div>
      
                                    <div class="col-md-12 mt-3 px-0">
                                      <label for="modul_id" class="mb-0">Modul:</label>
                                      <select name="modul_id" class="form-control" required id="modul_id">
                                        <option value="">Buatkan kuis di modul apa?</option>
                                        @foreach ($moduls as $modul)
                                           @if ($modul->matkul->dosen_id == auth()->user()->user_id)
                                             <option value="{{ $modul->modul_id }}">{{ $modul->nama_modul }}</option>
                                           @endif
                                        @endforeach
                                     </select>
                                    </div>
      
                                    <div class="col-md-12 mt-3 px-0">
                                      <label for="quiz_type" class="mb-0">Quiz Type:</label>
                                      <select name="quiz_type" required class="form-control" id="quiz_type">
                                        <option value="">Pilih tipe kuis</option>
                                        <option value="Multiple Choice">Multiple Choice</option>
                                        <option value="Essay">Essay</option>
                                        <option value="Draggable">Draggable</option>
                                      </select>
                                    </div>

                                    <div class="col-md-12 mt-3 px-0">
                                        <label for="quiz_date">Quiz Date</label>
                                        <input type="date" required name="quiz_date" id="quiz_date" class="form-control">
                                    </div>

                                    <div class="col-md-12 mt-3 px-0">
                                        <label for="quiz_time">Quiz Duration</label>
                                        <div class="d-flex">
                                          <div class="col-md-2 px-0">
                                            <select name="jam" required class="form-control" id="jam">
                                              <option value="">Jam</option>
                                              @for($i = 0; $i <= 23; $i++)
                                                <option value="{{ $i }}">@if($i <= 9) {{ '0'.$i }} @else {{ $i }} @endif</option>
                                              @endfor 
                                            </select>
                                          </div>

                                          <div class="col-md-2 px-0 ml-3">
                                            <select name="menit" required class="form-control" id="menit">
                                              <option value="">Menit</option>
                                              @for($i = 0; $i <= 59; $i++)
                                                <option value="{{ $i }}">@if($i <= 9) {{ '0'.$i }} @else {{ $i }} @endif</option>
                                              @endfor 
                                            </select>
                                          </div>
                                          <div class="col-md-2 px-0 ml-3">
                                            <select name="detik" required class="form-control" id="detik">
                                              <option value="">Detik</option>
                                              @for($i = 0; $i <= 59; $i++)
                                                <option value="{{ $i }}">@if($i <= 9) {{ '0'.$i }} @else {{ $i }} @endif</option>
                                              @endfor 
                                            </select>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                      
                                <div class="modal-footer bg-whitesmoke br">
                                  <button type="submit" class="btn" style="background: navy; color: #fff;">Submit</button>
                                </div>
                              </form>
                          </div>
                        </div>
                    </div>            

                    <div class="row mt-4">
                        <div class="col-md">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data">
                                    <thead>
                                        <tr style="white-space: nowrap">
                                            <th>#</th>
                                            <th>Quiz Name</th>
                                            <th>Kelas</th>
                                            <th>Matkul</th>
                                            <th>Modul</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Time Duration</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quizzes as $item)
                                            
                                        <tr style="white-space: nowrap">
                                            <td>{{ $loop->iteration . '.' }}</td>
                                            <td>
                                              @if ($item->quiz_type == 'Multiple Choice')
                                                  
                                              <a href="{{ url('/multiple_choice/master/' . $item->quiz_id) }}">
                                                  {{ $item->quiz_name }}
                                              </a>

                                              @elseif($item->quiz_type == 'Essay')

                                              <a href="{{ url('/essay/master/' . $item->quiz_id) }}">
                                                {{ $item->quiz_name }}
                                              </a>

                                              @else

                                              <a href="{{ url('/draggable/master/' . $item->quiz_id) }}">
                                                {{ $item->quiz_name }}
                                              </a>

                                              @endif
                                            </td>
                                            <td>{{ $item->modul->kelas->nama_kelas }}</td>
                                            <td>{{ $item->modul->matkul->nama_matkul }}</td>
                                            <td>{{ $item->modul->nama_modul }}</td>
                                            <td>{{ $item->quiz_type }}</td>
                                            <td>{{ date('d M Y', strtotime($item->quiz_date)) }}</td>
                                            <td>{{ $item->jam.':'.$item->menit.':'.$item->detik }}</td>
                                            <td class="text-center">
                                                <button class="btn" data-toggle="modal" data-target="{{ '#hapus' . $item->quiz_id }}">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                                <button class="btn" data-toggle="modal" data-target="{{ '#edit' . $item->quiz_id }}">
                                                    <i class="fa fa-cog text-info"></i>
                                                </button>
                                            </td>
                                            <div class="modal fade" id="{{ 'hapus' . $item->quiz_id }}" tabindex="-1" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="createLabelModal">Perhatian</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin untuk menghapus <strong>{{ $item->quiz_name }}</strong>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <form action="{{ url('/hapus_quiz/'.$item->quiz_id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" tabindex="-1" id="{{ 'edit' . $item->quiz_id }}" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                                <div class="modal-dialog modal-md modal-dialog-centered">
                                                  <div class="modal-content">
                                                    <div class="modal-header" style="background: orange">
                                                      <h5 class="modal-title text-light">Edit Quiz</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                      <form action="{{ url('/update_quiz/' . $item->quiz_id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body" style="overflow-y: auto">
                              
                                                            <div class="col-md-12 mt-1 px-0">
                                                              <label for="quiz_name" class="mb-0">Quiz Name:</label>
                                                              <input type="text" required name="quiz_name" value="{{ $item->quiz_name }}" id="quiz_name" class="form-control" placeholder="Enter name of quiz">
                                                            </div>
                              
                                                            <div class="col-md-12 mt-3 px-0">
                                                              <label for="modul_id" class="mb-0">Modul:</label>
                                                              <select name="modul_id" class="form-control" required id="modul_id">
                                                                <option value="{{ $item->modul_id }}">{{ $item->modul->nama_modul }}</option>
                                                                <option>Buatkan kuis di modul apa?</option>
                                                                @foreach ($moduls as $modul)
                                                                   @if ($modul->matkul->dosen_id == auth()->user()->user_id)
                                                                     <option value="{{ $modul->modul_id }}">{{ $modul->nama_modul }}</option>
                                                                   @endif
                                                                @endforeach
                                                             </select>
                                                            </div>
                        
                                                            <div class="col-md-12 mt-3 px-0">
                                                                <label for="quiz_date">Quiz Date</label>
                                                                <input type="date" value="{{ $item->quiz_date }}" required name="quiz_date" id="quiz_date" class="form-control">
                                                            </div>
                        
                                                            
                                                          <div class="col-md-12 mt-3 px-0">
                                                              <label for="quiz_time">Quiz Duration</label>
                                                              <div class="d-flex">
                                                                <div class="col-md-2 px-0">
                                                                  <select name="jam" required class="form-control" id="jam">
                                                                    <option value="{{ $item->jam }}">{{ $item->jam }}</option>
                                                                    @for($i = 0; $i <= 23; $i++)
                                                                      <option value="{{ $i }}">@if($i <= 9) {{ '0'.$i }} @else {{ $i }} @endif</option>
                                                                    @endfor 
                                                                  </select>
                                                                </div>

                                                                <div class="col-md-2 px-0 ml-3">
                                                                  <select name="menit" required class="form-control" id="menit">
                                                                    <option value="{{ $item->menit }}">{{ $item->menit }}</option>
                                                                    @for($i = 0; $i <= 59; $i++)
                                                                      <option value="{{ $i }}">@if($i <= 9) {{ '0'.$i }} @else {{ $i }} @endif</option>
                                                                    @endfor 
                                                                  </select>
                                                                </div>
                                                                <div class="col-md-2 px-0 ml-3">
                                                                  <select name="detik" required class="form-control" id="detik">
                                                                    <option value="{{ $item->detik }}">{{ $item->detik }}</option>
                                                                    @for($i = 0; $i <= 59; $i++)
                                                                      <option value="{{ $i }}">@if($i <= 9) {{ '0'.$i }} @else {{ $i }} @endif</option>
                                                                    @endfor 
                                                                  </select>
                                                                </div>
                                                              </div>
                                                          </div>
                                                        </div>
                                              
                                                        <div class="modal-footer bg-whitesmoke br">
                                                          <button type="submit" class="btn" style="background: orange; color: #fff;">Update</button>
                                                        </div>
                                                      </form>
                                                  </div>
                                                </div>
                                            </div>         
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
    </div>
@endsection