@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('create.board') }}" class="btn btn-primary mt-3">Create New Board</a>
        <div class="row">
            @foreach ($allBoards as $allBoard)
                <div class="col-12 col-lg-3 col-md-3 col-sm-12 mt-3 mb-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $allBoard['name'] }}</h5>
                            <p class="card-text">{{ $allBoard['desc'] }}</p>
                            <a href="{{ route('all.lists', $allBoard['id']) }}" class="btn btn-primary">ALL Lists</a>
                            <a href="{{ route('edit.board', $allBoard['id']) }}" class="btn btn-info">Update</a>
                            <a href="{{ route('delete.board', $allBoard['id']) }}" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
