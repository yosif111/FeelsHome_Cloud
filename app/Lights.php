<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lights extends Model
{
    protected $fillable = [
        'mode_id', 'name', 'brightness', 'color', 'isOn'
    ];
}
