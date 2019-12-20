@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @elseif(session()->has('alert'))
                        <div class="alert alert-danger">
                            {{ session()->get('alert') }}
                        </div>
                    @endif
                    <form action="/home" method="post">
                        @csrf
                        <textarea name="content" cols="30" rows="5" class="form-control" placeholder="What's on your mind..."></textarea>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Post">
                    </form>
                </div>
                <hr>
                <div class="card-body">
                    @foreach($posts as $post)
                        <h5>
                            @if (file_exists(public_path().'/images/'.$post->user->id . '.jpg'))
                                <img src="images/{{ $post->user->id }}.jpg" width=10%>
                            @else
                                <img src="images/default.png" width=10%>
                            @endif
                            <a href="user/{{ $post->user_id }}">{{ $post->user->name }} ({{ $post->user->email }})</a>
                        </h5>
                        @if($post->user->id == Auth::user()->id)
                            <p style="color:green">{{ $post->content }}</p>
                        @else
                            <p style="color:blue">{{ $post->content }}</p>
                        @endif
                        <small>{{ $post->created_at->format("d.m.Y. H:i:s") }}</small>
                        <small>{{ $post->created_at->diffForHumans() }}</small>
                        <hr>
                    @endforeach
                </div>
                <div class="card-body">
                    @foreach($events as $event)
                        <h5><a href="event/{{ $event->id }}">{{ $event->name }}</a></h5>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if(count($mutuals))
                <div class="card">
                    <div class="card-header">
                        Mutuals friends
                    </div>
                    <div class="card-body">
                        @foreach($mutuals as $follow)
                            <h5><a href="user/{{ $follow->id }}">{{ $follow->name }}</a></h5>
                            <input type="submit" class="btn btn-primary btn-sm" name="mutuals" value="Unfollow">
                        @endforeach
                    </div>
                </div>
            @endif
            @if(count($following))
                <div class="card">
                    <div class="card-header">
                        Users I'm following
                    </div>
                    <div class="card-body">
                        @foreach($following as $follow)
                            <h5><a href="user/{{ $follow->id }}">{{ $follow->name }}</a></h5>
                            <input type="submit" class="btn btn-primary btn-sm" name="following" value="Unfollow">
                        @endforeach
                    </div>
                </div>
            @endif
            @if(count($followers))
                <div class="card">
                    <div class="card-header">
                        My followers
                    </div>
                    <div class="card-body">
                        @foreach($followers as $follow)
                            <h5><a href="user/{{ $follow->id }}">{{ $follow->name }}</a></h5>
                            <input type="submit" class="btn btn-primary btn-sm" name="followers" value="Follow back">
                        @endforeach
                    </div>
                </div>
            @endif
            @if(count($others))
                <div class="card">
                    <div class="card-header">
                        Suggestions
                    </div>
                    <div class="card-body">
                        @foreach($others as $follow)
                            <h5><a href="user/{{ $follow->id }}">{{ $follow->name }}</a></h5>
                            <input type="submit" class="btn btn-primary" name="followers" value="Follow">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
