@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 col-md-6 col-sm-12 mt-3">
                <div class="card text-center" style="width: 36rem;">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <h5 class="card-title">{{ $singleCard['name'] }}</h5>
                        <p>{{ $singleCard['desc'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
