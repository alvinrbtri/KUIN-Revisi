@extends('layouts.dash')

@section('dash-content')
    <div class="row mx-2">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    Score Recap
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="data">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Quiz</th>
                                    <th>Quiz Type</th>
                                    <th>Score</th>
                                </tr>    
                            </thead>
                            <tbody>
                                @foreach ($attempt as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->user->nama }}</td>
                                        <td>{{ $item->quiz->quiz_name }}</td>
                                        <td>{{ $item->quiz->quiz_type }}</td>
                                        <td>
                                            <a target="_blank" href="{{ '/results/'.$item->quiz->quiz_id.'/'.$item->user->user_id }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
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
@endsection