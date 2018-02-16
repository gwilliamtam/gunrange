<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Location extends Model
{
    //
    public function addPhoto(Request $request)
    {
        $photoName = null;
        if($request->has('photo')) {
            $photo = $request->file('photo');
            $origName = $photo->getClientOriginalName();
            $ext = substr($origName, strrpos($origName, '.'));

            $photoName = $this->user_id . '-' . $this->id . '-' . date("YmdHis") . $ext;
            $photo->move('loc_images', $photoName);
        }

        $this->photo = $photoName;
        $this->save();

    }
}
