<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;

class PracticeTarget extends Model
{
    protected $table = "practice_targets";
    //

    public static function getUnits()
    {
        return array(null, 'ft', 'yd', 'mt');
    }

    public function addPhoto(Request $request)
    {
        $user = Auth::user();

        $photoName = null;
        if($request->has('photo')) {
            $photo = $request->file('photo');
            $origName = $photo->getClientOriginalName();
            $ext = substr($origName, strrpos($origName, '.'));

            $photoName = $user->id . '-' . $this->id . '-' . date("YmdHis") . $ext;
            $photo->move('target_images', $photoName);
        }

        $this->photo = $photoName;
        $this->save();

    }

    public function removeSeconds()
    {
        $dateTime = $this->date_time;


        if(empty($this->date_time)) {
            return null;
        }

        return substr($dateTime, 0, strrpos($dateTime,":"));
    }

    public function header()
    {
        return $this->hasOne('App\Models\PracticeHeader', 'id', 'header_id');

    }
}
