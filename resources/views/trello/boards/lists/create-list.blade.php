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

            <form method="POST" action="{{ route('store.list') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">List Name</label>
                    <input name="name" type="text" class="form-control" id="exampleInputName"
                        aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
