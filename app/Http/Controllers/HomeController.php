<?php

namespace App\Http\Controllers;

use App\Repositories\PostsRepository;
use Auth;
use App\Models\User_mute;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Redis;

//use Illuminate\Support\Facades\Redis;


class HomeController extends Controller
{

    public function index()
    {
        return (new PostsRepository)->getTargetPostsWithCache();;
    }
}
