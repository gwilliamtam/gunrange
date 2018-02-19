<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Ammo;

class AmmoController extends Controller
{
    protected $redirectTo = '/';

    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $ammos = Ammo::where('user_id', '=', $user->id)->orderBy('name')->get();

        return view('ammo', [
            'ammos' => $ammos
        ]);
    }

    public function save(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'file' => 'max:5120', //5MB
        ]);

        if(empty($request->ammoId)){
            $ammo = new Ammo();
        }else{
            $query = Ammo::where('user_id', '=', $user->id)
                ->where('id', '=', $request->gearId);
            $gear = $query->first();
        }
        $ammo->user_id = $user->id;
        $ammo->name = $request->name;

        // Save now because we need the id for the image name
        $ammo->save();
        if($request->photoChanged == "1"){
            $ammo->addPhoto($request);
        }

        return redirect()->route('ammo.index');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        if(!empty($request->ammoId)){
            Ammo::where('user_id', '=', $user->id)
                ->where('id', '=', $request->ammoId)
                ->delete();
        }

        return redirect()->route('ammo.index');

    }
}
