@extends('layouts.quiz')

@section('quiz-content')
    <div class="container-fluid">
        <div class="row mt-4 mx-2">
            <div class="col-md">
                <a href="{{ url('/draggable/master/'.$quiz->quiz_id) }}" class="btn btn-dark" style="font-size: 12px">Back</a>
                <h4 class="mt-3 mb-0" style="font-weight: bold">Manage The Question Option</h4>
            </div>
        </div>
        
        <div class="row mt-4 mx-2">
            <form action="/draggable/create_option" method="POST" class="col-md-12">
               @csrf
               <input type="hidden" name="quiz_id" value="{{ $quiz->quiz_id }}">
               <div class="card">
                  <textarea name="draggable_answer" class="form-control @error('draggable_answer') is-invalid @enderror" id="draggable_answer" rows="7" placeholder="What's your option?" style="resize: none;">{{ old('draggable_answer') }}</textarea>
                </div>
                @error('draggable_answer')
                    <span class="text-danger" style="font-size: 13px">
                        {{ $message }}
                    </span>
                @enderror

                <div class="mt-4">
                    <div class="col-md mt-4">
                        <button type="submit" class="btn btn-info" style="font-weight: 700; font-size: 13px">Add Option</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row mt-5 mx-2">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-info">
                        <tr>
                            <th>#</th>
                            <th>Options</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody style="vertical-align: middle">
                        @foreach ($options as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->draggable_answer }}</td>
                                <td>
                                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="{{ '#detail' . $item->draggable_opt_id }}" style="font-size: 13px">Detail</button>
                                    <form action="{{ '/draggable/hapus_option/' . $item->draggable_opt_id }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button class="btn btn-danger" type="submit" style="font-size: 13px">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="{{ 'detail' . $item->draggable_opt_id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="exampleModalLabel">Information Detail</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ '/draggable/update_option/' . $item->draggable_opt_id }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mt-1">
                                                <label for="draggable_answer">Option:</label>
                                                <textarea name="draggable_answer" required id="draggable_answer" rows="5" class="form-control" placeholder="Enter the option answer">{{ $item->draggable_answer }}</textarea>
                                            </div>
                                            <div class="mt-3">
                                                <label for="draggable_id">Connect with question:</label>
                                                <select name="draggable_id" id="draggable_id" class="form-control">
                                                    @if ($item->draggable_id != null)
                                                        <option value="{{ $item->draggable_id }}">Connected: {{ $item->draggable->draggable_question }}</option>
                                                    @endif
                                                    <option value="">-Select connection-</option>
                                                    @foreach ($draggable as $question)
                                                        <option value="{{ $question->draggable_id }}">{{ $loop->iteration . '.' }} {{ $question->draggable_question }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="submit" class="btn btn-primary" style="font-size: 13px">Save</button>
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
@endsection