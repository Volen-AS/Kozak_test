<?php

namespace App\Http\Controllers;

use App\Repositories\PostsRepository;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *@return array  with 50   posts each element:
     * latest, oldest, rand
     *
     */
    public function index()
    {
        $posts = (new PostsRepository)->getTargetPostsWithCachePaginate();

        return $posts;
    }
}
