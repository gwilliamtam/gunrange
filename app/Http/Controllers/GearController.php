<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Gear;

class GearController extends Controller
{
    protected $redirectTo = '/';

    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $gears = Gear::where('user_id', '=', $user->id)->orderBy('name')->get();

        return view('gear', [
            'gears' => $gears,
            'pin' => empty($_COOKIE['gear']) ? null : $_COOKIE['gear'],
        ]);
    }

    public function save(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'file' => 'max:5120', //5MB
        ]);

        if(empty($request->gearId)){
            $gear = new Gear();
        }else{
            $query = Gear::where('user_id', '=', $user->id)
                ->where('id', '=', $request->gearId);
            $gear = $query->first();
        }
        $gear->user_id = $user->id;
        $gear->name = $request->name;

        // Save now because we need the id for the image name
        $gear->save();
        if($request->photoChanged == "1"){
            $gear->addPhoto($request);
        }

        return redirect()->route('gear.index');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        if(!empty($request->gearId)){
            Gear::where('user_id', '=', $user->id)
                ->where('id', '=', $request->gearId)
                ->delete();
        }

        return redirect()->route('gear.index');

    }
}
