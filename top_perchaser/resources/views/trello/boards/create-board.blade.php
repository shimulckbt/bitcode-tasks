@extends('layouts.app')
@section('content')
    <div class="container pt-5">
        <div class="items-center">
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
