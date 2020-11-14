<?php

namespace App\Repositories;

use App\Models\Post as Model;
use Auth;
use Carbon\Carbon;

class PostsRepository extends CoreRepository
{
    /** @var \Illuminate\Support\Collection
     *blocks users
     */
    private $mutesUsers;

    public function __construct()
    {
        parent::__construct();
        $this->mutesUsers = $this->getArrayMutesUsers();
    }

    /**
     *@return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     *if not posts in cache put in redis cache
     *@return array with keys 'latest', 'oldest', 'rand'
     */
    public function getTargetPostsWithCachePaginate(){

        $cacheKey = "{$this->getCacheKey(Auth::user()->email)}.posts";

        return \Cache::store('redis')
            ->remember($cacheKey, Carbon::now()->addMinutes(15), function (){
                return ['latest'=> $this->getLatestPostsWithPaginate(),
                        'oldest' => $this->getOldestPostsWithPaginate(),
                        'rand' => $this->getRandPostsWithPaginate()
                    ];
            });
    }

    public function getOldestPostsWithPaginate(){

        try {
            $posts =  Model::whereNotIn('user_id', $this->mutesUsers )
                            ->select('title', 'body')
                            ->orderBy('id', 'desc')
                            ->take(50)
                            ->paginate(15);
        } catch ( \Exception $e){
            return $e->getMessage();
        }
       // dd($posts);
        return $posts;
    }

    public function getLatestPostsWithPaginate(){
        try {
            $posts = Model::whereNotIn('user_id', $this->mutesUsers)
                            ->select('title', 'body')
                            ->orderBy('id', 'asc')
                            ->take(50)
                            ->paginate(15);
        } catch ( \Exception $e){
            return $e->getMessage();
        }
        return $posts;
    }

    public function getRandPostsWithPaginate(){
        try {
            $posts = Model::whereNotIn('user_id', $this->mutesUsers )
                            ->select('title', 'body')
                            ->inRandomOrder()
                            ->limit(50)
                            ->paginate(15);
        } catch ( \Exception $e){
            return $e->getMessage();
        }
        return $posts;
    }

    /**
     * @param string  use user->email
     * @return string md5('string')
     */
    protected function getCacheKey($name)
    {
        return md5($name);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function getArrayMutesUsers()
    {
        return Auth::user()->arrayMutesUsers();
    }
}
