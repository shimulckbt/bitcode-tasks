@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('create.list') }}" class="btn btn-primary mt-3">Create New List</a>
        <div class="row">
            @foreach ($allLists as $allList)
                <div class="col-12 col-lg-3 col-md-3 col-sm-12 mt-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $allList['name'] }}</h5>
                            <a href="{{ url("/boards/lists/all-cards/{$allList['id']}/{$allList['idBoard']}") }}"
                                class="btn btn-primary">ALL
                                Cards</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
