<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable
        = [
            'user_id',
            'title',
            'body'
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
