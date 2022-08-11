@extends('layouts.app')
@section('content')
    <div class="container pt-5">
        <div class="items-center">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ session('success') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('message') }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ $error }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach

            <form method="POST" action="{{ route('authorization.request') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputApiKey" class="form-label">Enter Your API key</label>
                    <input name="apiKey" type="text" class="form-control" id="exampleInputApiKey"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputApiToken" class="form-label">Enter Your API Token</label>
                    <input name="apiToken" type="text" class="form-control" id="exampleInputApiToken">
                </div>
                @error('apiToken')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
