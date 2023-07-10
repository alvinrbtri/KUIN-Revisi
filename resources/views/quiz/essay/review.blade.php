@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4 mx-2">


            <div class="col-md">

                <a href="{{ url('/essay/master/'.$quiz->quiz_id) }}" class="btn btn-dark" style="font-size: 12px">Kembali</a>
                

                <h5 class="my-3" style="font-weight: bold">Data Review</h5>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Mahasiswa</th>
                                <th>Quiz</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($attempt as $item)
                                <tr>
                                    <td>{{ $loop->iteration . '.' }}</td>
                                    <td>{{ $item->user->nama }}</td>
                                    <td>{{ $item->quiz->quiz_name }}</td>
                                    <td>
                                        <a href="{{ '/essay/detail_review/'.$item->quiz_id.'/'.$item->user_id }}" class="btn btn-info" style="font-size: 12px">Pratinjau</a>
                                        <a href="{{ '/results/'.$item->quiz_id.'/'.$item->user_id }}" class="btn btn-success" style="font-size: 12px">View Score</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection