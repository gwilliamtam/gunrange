<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function dashboardCount()
    {
        $userId = $this->id;
        $query = <<<QUERY
            select
                (select count(id) from locations 
                  where locations.user_id = $userId) as locationsCount,
                (select count(id) from gear 
                  where user_id = $userId) as gearCount,
                (select count(id) from ammo 
                  where user_id = $userId) as ammoCount,
                (select count(id) from practice_header 
                  where user_id = $userId) as practiceCount,
                (select count(practice_targets.id) from practice_header, practice_targets 
                  where practice_header.user_id = $userId and practice_targets.header_id = practice_header.id) as targetsCount
QUERY;

        $dashboardCount = DB::select(DB::raw($query));
        return $dashboardCount[0];
    }
}
