@extends('layouts.app')
@section('content')
    <div class="container pt-5">
        <div class="items-center">
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
