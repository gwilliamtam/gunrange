<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Location;

class LocationsController extends Controller
{
    protected $redirectTo = '/';

    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $locations = Location::where('user_id', '=', $user->id)->orderBy('name')->get();

        return view('locations', [
            'locations' => $locations,
            'file' => 'max:5120', //5MB
        ]);
    }

    public function save(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'name' => 'required|max:255'
        ]);

        if(empty($request->locationId)){
            $location = new Location();
        }else{
            $query = Location::where('user_id', '=', $user->id)
                ->where('id', '=', $request->locationId);
            $location = $query->first();
        }
        $location->user_id = $user->id;
        $location->name = $request->name;
//        $location->photo = $request->

        if ($request->has('address')) {
            $location->address = $request->address;
        }else{
            $location->address = null;
        }
        if ($request->has('coordinates')) {
            $location->coordinates = $request->coordinates;
        }else{
            $location->coordinates = null;
        }
        if ($request->has('map')) {
            $location->map = $request->map;
        }else{
            $location->map = null;
        }

        // Save now because we need the id for the image name
        $location->save();
        if($request->photoChanged == "1"){
            $location->addPhoto($request);
        }

        return redirect()->route('locations.index');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        if(!empty($request->locationId)){
            Location::where('user_id', '=', $user->id)
                ->where('id', '=', $request->locationId)
                ->delete();
        }

        return redirect()->route('locations.index');

    }
}
