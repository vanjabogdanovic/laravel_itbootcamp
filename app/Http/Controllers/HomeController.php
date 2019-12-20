<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use App\Post;
use Auth;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $user = Auth::user();
        $events = Event::orderBy('date')->get();
        $following = $user->following;
        $followers = $user->followers;

        $followingIds = $user->following->pluck('id')->toArray();
        $followerIds = $user->followers->pluck('id')->toArray();
        $mutualIds = array_intersect($followingIds, $followerIds);
        $followingIds = array_diff($followingIds, $mutualIds);
        $followerIds = array_diff($followerIds, $mutualIds);
        $mutuals = User::whereIn('id', $mutualIds)->orderBy('name')->get();
        $followers = User::whereIn('id', $followerIds)->orderBy('name')->get();
        $following = User::whereIn('id', $followingIds)->orderBy('name')->get();
        $userId = array($user->id);
        $others = User::whereNotIn('id', array_merge($mutualIds, $followingIds, $followerIds, $userId))->orderBy('name')->get();

        return view('home', ['posts' => $posts, 'following' => $following, 'followers' => $followers, 'mutuals' => $mutuals, 'others' => $others, 'events' => $events]);
    }

    public function publish()
    {
        $content = request('content');
        $id = Auth::user()->id;

        if (empty($content))
        {
            return redirect('\home')->with('alert', 'Post is empty!');
        }
        else
        {
            $post = new Post();
            $post->user_id = $id;
            $post->content = $content;
            $post->save();

            return redirect('\home')->with('success', 'Post published!');
        }
    }
}
