<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PprEvent extends Model{
    //
    protected $table = 'ppr_events';
    public function shift()
    {
        return $this->hasOne('App\Http\Models\Shift', 'id', 'shift_id');
    }

    public function telly()
    {
        return $this->hasOne('App\Http\Models\Telly', 'id', 'telly_id');
    }
    
    public function department()
    {
        return $this->hasOne('App\Http\Models\Department', 'id', 'department_id');
    }
            
}

