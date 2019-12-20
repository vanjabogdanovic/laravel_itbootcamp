@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ $event->name }}</h3>
                        <h5>{{ $event->location }}</h5>
                        <h5>{{ $event->date }}</h5>
                        <h5>{{ $event->user->name }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
