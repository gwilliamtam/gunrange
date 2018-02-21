<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\PracticeHeader;
use App\Models\PracticeTarget;

class PracticeController extends Controller
{
    protected $redirectTo = '/';

    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $practices = PracticeHeader::where('user_id', '=', $user->id)
            ->orderBy('date_time', 'desc')
            ->get();
        return view('practice', [
            'practices' => $practices,
            'user' => $user
        ]);
    }

    public function save(Request $request)
    {
        $user = Auth::user();
        $commaPos = strpos($request->date_time, ",");
        if(substr_count($request->date_time,":") == 1){
            $request->date_time = substr($request->date_time, $commaPos + 2) . ":00";
        }


        $validatedData = $request->validate([
            'date_time' => 'required',
        ]);

        if(empty($request->practiceId)){
            $practice = new PracticeHeader();
        }else{
            $query = PracticeHeader::where('user_id', '=', $user->id)
                ->where('id', '=', $request->practiceId);
            $practice = $query->first();
        }
        $practice->user_id = $user->id;
        $practice->date_time = $request->date_time;

        $practice->save();

        return redirect()->route('practice.index');
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        if(!empty($request->practiceId)){
            PracticeHeader::where('user_id', '=', $user->id)
                ->where('id', '=', $request->practiceId)
                ->delete();
        }

        return redirect()->route('practice.index');
    }

    public function addElements(Request $request)
    {
        $user = Auth::user();
        if(!empty($request->practiceId)){
            $practiceQuery = PracticeHeader::where('user_id', '=', $user->id)
                ->where('id', '=', $request->practiceId);
            if($practiceQuery->count()>0){
                $practice = $practiceQuery->first();

                if(empty($practice->location_id) and !empty($_COOKIE['location'])){
                    $practice->location_id = $_COOKIE['location'];
                }
                if(empty($practice->ammo_id) and !empty($_COOKIE['ammo'])){
                    $practice->ammo_id = $_COOKIE['ammo'];
                }
                if(empty($practice->gear_id) and !empty($_COOKIE['gear'])){
                    $practice->gear_id = $_COOKIE['gear'];
                }

                $practice->save();
            }
        }

        return redirect()->route('practice.index');
    }

    public function addTarget(Request $request)
    {
        $practiceTarget = new PracticeTarget();
        $practiceTarget->header_id = $request->practiceId;

        if(!empty($request->value)){
            $practiceTarget->value = $request->value;
        }

        if(!empty($request->rounds)){
            $practiceTarget->rounds = $request->rounds;
        }

        // Save now because we need the id for the image name
        $practiceTarget->save();

        if(!empty($request->photo)){
            $practiceTarget->addPhoto($request);
        }

        return redirect()->route('practice.index');
    }
}
