<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TV extends Model
{
    protected $fillable = [
        'name', 'path', 'image', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

}
