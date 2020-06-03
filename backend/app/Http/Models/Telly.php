<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Telly extends Model
{
    //
    public $timestamps = false;
    public function tellyType()
    {
        return $this->hasOne('App\Http\Models\TellyType', 'id', 'telly_type_id');
    }
}
