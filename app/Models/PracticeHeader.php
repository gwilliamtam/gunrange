<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PracticeHeader extends Model
{
    protected $table = "practice_header";
    //

    public function ammo()
    {
        return $this->hasOne('App\Models\Ammo', 'id', 'ammo_id');
    }

    public function gear()
    {
        return $this->hasOne('App\Models\Gear', 'id', 'gear_id');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function targets()
    {
        return $this->hasMany('App\Models\PracticeTarget', 'header_id', 'id');
    }

}
