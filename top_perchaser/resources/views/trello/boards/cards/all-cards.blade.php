@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- <a href="{{ route('create.list') }}" class="btn btn-primary mt-3">Create New List</a> --}}
        <a href="{{ route('create.card') }}" class="btn btn-primary mt-3">Create New Card</a>
        <div class="row">
            @foreach ($allCards as $allCard)
                <div class="col-12 col-lg-3 col-md-3 col-sm-12 mt-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $allCard['name'] }}</h5>
                            <a href="{{ route('show.card', $allCard['id']) }}" class="btn btn-primary">Show Card</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
