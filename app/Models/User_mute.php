<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_mute extends Model
{
    public $incrementing = false;

    public $primaryKey = ['user_id', 'mute_id'];

    public $fillable =
        [
            'user_id',
            'mute_id',
            'expired_at'
        ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user_mute()
    {
        return $this->belongsTo(User::class, 'mute_id');
    }
}
