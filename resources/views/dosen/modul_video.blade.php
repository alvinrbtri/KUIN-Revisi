@extends('layouts.dash')

@section('dash-content')
<div class="container-fluid page__container">
    <div class="row" style="row-gap: 15px;">
      
      {{-- <div class="">
      <form method="GET" action="{{ route('modul_video') }}">
        <div class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama matkul">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </div>
    </form>
    <div class="">
      @foreach ($modul_video as $item)
      <button class="btn btn-primary search-button" data-search="{{ $item->matkul->nama_matkul }}">
          {{ $item->matkul->nama_matkul }}
      </button>
  @endforeach
  </div>
  </div>

<form id="search-form" method="GET" action="{{ route('modul_video') }}" style="display: none;">
    <input type="hidden" name="search" id="search-input">
</form> --}}

  
    
      @if (auth()->user()->level == 'mahasiswa')
          
      <div class="col-12 px-0">
        <h5>{{ auth()->user()->kelas->nama_kelas }} | {{ auth()->user()->semester->semester_tipe }}</h5>
      </div>

      @endif

      

      {{-- dosen privilege --}}
        {{-- @if (auth()->user()->level == 'dosen' )
        <div class="col-md">
          <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                  <span>List Modul Video</span>
                  <button class="btn btn-info" data-toggle="modal" data-target="#create">+ Create Modul Video</button>
              </div>
              <div class="modal fade" tabindex="-1" id="create" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                  <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header bg-info">
                        <h5 class="modal-title text-light">Create Modul Video</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                        <form action="/learning/create_modul_video" method="POST" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-body" style="overflow-y: auto">
                            
                              <div class="col-md-12 mt-3 px-0">
                                <label for="nama_video" class="mb-0">Nama Modul Video:</label>
                                <input type="text" required name="nama_video" id="nama_video" class="form-control" placeholder="ex. Algoritma dan Pemrograman">
                              </div>

                              <div class="col-md-12 mt-3 px-0">
                                <label for="file_modul_video" class="mb-0">File:</label>
                                <div id="dropzone" class="dropzone">
                                  <span class="dropzone-text">Seret dan lepas file video di sini</span>
                                </div>
                                <input type="file" multiple required name="file_modul_video" accept=".mp4, .docx, .doc" id="file_modul_video" class="form-control" placeholder="ex. Algoritma dan Pemrograman">
                              </div>

                              <div class="col-md-12 mt-3 px-0">
                                <label for="deskripsi" class="mb-0">Deskripsi:</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6" required placeholder="Deskripsikan modul Video"></textarea>
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
                              <th>Kelas</th>
                              <th>File Modul Video</th>
                              <th>Deskripsi</th>
                              <th>Action</th>
                            </tr>
                          </thead>

                          <tbody>
                            @foreach ($modul_video as $data)
                                <tr>
                                    <td class="d-flex">
                                      <div style="height: 70px; width: 50px;">
                                          <img src="{{ asset('storage/images/'.$data->matkul->image) }}"  class="rounded" style="width: 100%; height: 100%; object-fit: cover" alt="">
                                      </div>
                                      <div class="ml-2 d-flex flex-column justify-content-center">
                                          <p class="mb-0">{{ $data->nama_modul_video }}</p>
                                          <p class="mb-0" style="font-size: 11px">{{ $data->matkul->nama_matkul }}</p>
                                      </div>
                                  </td>
                                  <td>@if($data->kelas_id != null) {{ $data->kelas->nama_kelas }} @endif</td>
                                  <td>
                                    <a href="{{ asset('storage/documents/'.$data->file_modul_video) }}" target="_blank">
                                      Lihat Modul Video
                                    </a>
                                  </td>
                                  <td>
                                    {{ $data->deskripsi }}
                                  </td>
                                  <td>
                                    <button class="btn" data-toggle="modal" data-target="{{ '#hapus' . $data->modul_video_id }}">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                    <button class="btn" data-toggle="modal" data-target="{{ '#edit' . $data->modul_video_id }}">
                                        <i class="fa fa-cog text-info"></i>
                                    </button>
                                  </td>
                                </tr>

                                  <div class="modal fade" id="{{ 'hapus' . $data->modul_video_id }}" tabindex="-1" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                              <h5 class="modal-title" id="createLabelModal">Perhatian</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                              </div>
                                              <div class="modal-body">
                                                  Yakin untuk menghapus <strong>{{ $data->nama_modul_video }}</strong>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <form action="{{ url('/learning/hapus_modul_video/'.$data->modul_video_id) }}" method="POST">
                                                  @csrf
                                                  <button type="submit" class="btn btn-danger">Hapus</button>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="modal fade" tabindex="-1" id="{{ 'edit' . $data->modul_video_id }}" data-backdrop="false" style="background-color: rgba(0, 0, 0, 0.5);">
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
                                                <div class="col-md-12 mt-1 px-0">
                                                  <label for="matkul_id" class="mb-0">Mata Kuliah:</label>
                                                  <select name="matkul_id" class="form-control" required id="matkul_id">
                                                    <option value="{{ $data->matkul_id }}">{{ $data->matkul->nama_matkul }}</option>
                                                    <option value="">Pilih Mata Kuliah</option>
                                                    @foreach ($matkul as $item)
                                                        <option value="{{ $item->matkul_id }}">{{ $item->nama_matkul }}</option>
                                                    @endforeach
                                                  </select>
                                                </div>

                                                <div class="col-md-12 mt-3 px-0">
                                                  <label for="kelas_id" class="mb-0">Kelas:</label>
                                                  <select name="kelas_id" class="form-control" required id="kelas_id">
                                                    @if ($data->kelas_id != null)
                                                    <option value="{{ $data->kelas_id }}">{{ $data->kelas->nama_kelas }}</option>
                                                    @endif
                                                    <option value="">Pilih Kelas</option>
                                                    @foreach ($kelas as $item)
                                                        <option value="{{ $item->kelas_id }}">{{ $item->nama_kelas }}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                
                                                <div class="col-md-12 mt-3 px-0">
                                                  <label for="nama_modul_video" class="mb-0">Nama Modul:</label>
                                                  <input type="text" required name="nama_modul_video" id="nama_modul_video" class="form-control" placeholder="ex. Algoritma dan Pemrograman" value="{{ $data->nama_modul_video }}">
                                                </div>
                
                                                <div class="col-md-12 mt-3 px-0">
                                                  <label for="file_modul_video" class="mb-0">File:</label>
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
                                </div>           
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
       @endif --}}

      
    

       {{-- mahasiswa privilege --}}
       {{-- @if (auth()->user()->level != 'dosen')
           @foreach ($modul_video as $item)
           <a href="{{ url('/learning/detail_modul_video/'.$item->modul_video_id) }}"  style="text-decoration: none;">
            <div class="card col-md-4 d-flex align-items-stretch">
                <div class="card-body p-0 bg-danger" style="height: 150px;">
                    <img src="{{ asset('storage/images/'.$item->matkul->image) }}" title="{{ $item->nama_modul_video }}" style="width: 100%; height: 100%; object-fit: cover;" alt="modul_image">
                </div>
                <div class="card-footer d-flex flex-column justify-content-between">
                    <div class="text-center">
                        <h6 class="text-muted">{{ $item->nama_modul_video }} - {{ $item->kelas->nama_kelas }}</h6>
                        <p style="color: #bbb">{{ $item->matkul->nama_matkul }}</p>
                    </div>
                    <div class="text-center">
                        <img src="@if($item->matkul->dosen->image == 'default.png') {{ asset('img/default.png') }} @else {{ asset('storage/images/'.$item->matkul->dosen->image) }} @endif" style="height: 25px; width: 25px; border-radius: 100%;" alt=""> 
                        <span class="ml-2 text-muted">{{ $item->matkul->dosen->nama }}</span>
                    </div>
                    <div class="text-center mt-2" >
                        <a href="{{ asset('storage/documents/'.$item->file_modul_video) }}" target="_blank" class="btn btn-primary">Download</a>
                    </div>
                </div>
            </div>
        </a>
           @endforeach

           @if ($modul_video->isEmpty())
               <p class="text-muted">Belum ada modul video di kelas anda</p>
           @endif
       @endif --}}
    </div>
</div>


@push('script')
<script>
  var searchButtons = document.querySelectorAll('.search-button');
  var searchInput = document.getElementById('search-input');
  var searchForm = document.getElementById('search-form');

  searchButtons.forEach(function(button) {
      button.addEventListener('click', function() {
          var searchKeyword = this.getAttribute('data-search');
          searchInput.value = searchKeyword;
          searchForm.submit();
      });
  });
</script>


<script>
  const dropzone = document.getElementById('dropzone');
  const fileInput = document.getElementById('file_modul_video');

  dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('dragover');
  });

  dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
  });

  dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    fileInput.files = e.dataTransfer.files;
  });

  fileInput.addEventListener('change', () => {
    uploadVideos(fileInput.files);
  });

  function uploadVideos(files) {
    const formData = new FormData();
    const url = '{{ route("modul_video") }}'; // Ganti dengan URL rute Anda

    for (let i = 0; i < files.length; i++) {
      formData.append('file_modul_video[]', files[i]);
    }

    axios.post(url, formData)
      .then(response => {
        // Tangani respons dari server
        console.log(response.data);
      })
      .catch(error => {
        // Tangani kesalahan jika terjadi
        console.error(error);
      });
  }
</script>
@endpush


@endsection