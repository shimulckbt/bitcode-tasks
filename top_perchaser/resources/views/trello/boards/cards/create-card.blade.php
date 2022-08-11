@extends('layouts.app')
@section('content')
    <div class="container pt-5">
        <div class="items-center">
            <form method="POST" action="{{ route('store.card') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Card Name</label>
                    <input name="name" type="text" class="form-control" id="exampleInputName"
                        aria-describedby="emailHelp">

                    <label for="exampleInputDescription" class="form-label">Card Description</label>
                    <textarea name="description" class="form-control" id="exampleInputDescription" cols="30" rows="10"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
