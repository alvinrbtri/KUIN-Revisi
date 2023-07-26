@extends('layouts.dash')

@section('dash-content')
    <div class="row mx-2">
        @foreach ($essay as $item)
            @if ($item->modul->kelas->kelas_id == auth()->user()->kelas_id)
            <div class="col-12">
                <div class="card rounded">
                    <div class="card-body d-flex" style="height: 30vh; overflow-y: auto;">
                        <div class="col-md-2 bg-secondary rounded p-0" style="height: 22vh">
                            <img src="{{ asset('storage/images/'.$item->modul->matkul->image) }}" class="rounded" style="width: 100%; height: 100%;" alt="">
                        </div>
                        <div class="ml-3">
                            <h4 class="text-dark mb-0">{{ $item->quiz_name }}</h4>
                            <p class="mb-1 mt-2"><span class="text-danger">{{ $item->modul->nama_modul }}</span> | <span class="text-info">{{ $item->modul->kelas->nama_kelas }}</span> | <span style="color: maroon">{{ $item->modul->matkul->nama_matkul }}</span></p>
                            <p class="mb-3 mt-2 text-muted"><i class="fa fa-calendar"></i> {{ date('d M Y', strtotime($item->quiz_date)) }}</p>
                            @php
                                date_default_timezone_set('Asia/Jakarta');
                            @endphp
                            <a href="{{ route('confirm', $item->quiz_id) }}" class="btn btn-secondary">Start Quiz</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach

        
    
    </div>
@endsection