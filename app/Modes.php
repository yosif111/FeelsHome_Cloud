<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modes extends Model
{
    protected $fillable = [
        'user_id', 'name', 'playlist_name', 'playlist_uri'
    ];

}
