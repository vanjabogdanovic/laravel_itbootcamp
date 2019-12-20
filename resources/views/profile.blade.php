@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>

                <div class="card-body">
                    @foreach($posts as $post)
                        <h5>

                            <img src="../images/{{ $post->user->id }}.jpg" width=10% onerror="this.onerror=null;this.src='../images/default.png';">
                            {{ $post->user->name }} ({{ $post->user->email }})
                        </h5>
                        <p>{{ $post->content }}</p>
                        <small>{{ $post->created_at->format("d.m.Y. H:i:s") }}</small>
                        <small>{{ $post->created_at->diffForHumans() }}</small>
                        <hr>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
