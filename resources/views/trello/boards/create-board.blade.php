@extends('layouts.app')
@section('content')
    <div class="container pt-5">
        <div class="items-center">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $error }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach

            <form method="POST" action="{{ route('store.board') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Board Name</label>
                    <input name="name" type="text" class="form-control" id="exampleInputName"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputDescription" class="form-label">Description</label>
                    <input name="description" type="text" class="form-control" id="exampleInputDescription">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
