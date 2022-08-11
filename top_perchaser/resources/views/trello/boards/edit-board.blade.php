@extends('layouts.app')
@section('content')
    <div class="container pt-5">
        <div class="items-center">
            {{-- <form method="POST" action="{{ route('update.board') }}"> --}}
            <form method="POST" action="{{ route('update.board', $data->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Enter Your API key</label>
                    <input name="name" type="text" class="form-control" value="{{ $data->name }}" id="exampleInputName"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputDescription" class="form-label">Enter Your API Token</label>
                    <input name="description" type="text" class="form-control" value="{{ $data->desc }}"
                        id="exampleInputDescription">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
