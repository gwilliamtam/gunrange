<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Auth;

class PracticeTarget extends Model
{
    protected $table = "practice_targets";
    //

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
}
