<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\PracticeHeader;
use App\Models\PracticeTarget;

class PracticeController extends Controller
{
    protected $redirectTo = '/';
    private $resultTrue = null;
    private $resultFalse = null;

    public function __construct()
    {
       $this->resultTrue = json_encode([
            "result"=>true
        ]);

       $this->resultFalse = json_encode([
            "result"=>false
        ]);

    }

    //
    public function index(Request $request)
    {
        $user = Auth::user();

        $practiceQuery = PracticeHeader::where('user_id', '=', $user->id);

        $pinId = null;
        if(!empty($_COOKIE['pinPractice'])){
            $pinId = $_COOKIE['pinPractice'];
            if(!empty($pinId)){
                $practiceQuery->where('id', '=', $pinId);
            }
        }

        $practices = $practiceQuery->orderBy('date_time', 'desc')->get();

        return view('practice', [
            'practices' => $practices,
            'user' => $user,
            'pin' => $pinId,
            'pinAmmo' => empty($_COOKIE['ammo']) ? null : $_COOKIE['ammo'],
            'pinGear' => empty($_COOKIE['gear']) ? null : $_COOKIE['gear'],
            'pinLocation' => empty($_COOKIE['location']) ? null : $_COOKIE['location'],
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

    public function removePracticeElement(Request $request)
    {
        $user = Auth::user();
        if(!empty($request->elementType) && !empty($request->practiceId)){

            if($request->elementType == "target"){
                $targetQuery = PracticeTarget::where('id', '=', $request->practiceId)->get();
                if($targetQuery->count()>0) {

                    $target = $targetQuery->first();
                    if($target->header->user_id == $user->id){

                        $target->delete();
                        return json_encode([
                            "result"=>true
                        ]);
                    }
                }
            }else{
                $id = substr($request->practiceId, strlen($request->elementType));
                $practiceQuery = PracticeHeader::where('user_id', '=', $user->id)
                    ->where('id', '=', $id)->get();
                if($practiceQuery->count()>0) {
                    $practice = $practiceQuery->first();
                    if($request->elementType == "loc"){
                        $practice->location_id = null;
                    }
                    if($request->elementType == "gear"){
                        $practice->gear_id = null;
                    }
                    if($request->elementType == "ammo"){
                        $practice->ammo_id = null;
                    }

                    $practice->save();
                    return $this->resultTrue;
                }
            }
        }

        return $this->resultFalse;
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

    public function updateTarget(Request $request)
    {
        $user = Auth::user();
        if (!empty($request->targetId)) {

            $targetQuery = PracticeTarget::where('id', '=', $request->targetId)->get();
            if ($targetQuery->count() > 0) {

                $target = $targetQuery->first();
                if ($target->header->user_id == $user->id) {
                    $target->rounds = $request->rounds;
                    $target->value = $request->value;
                    $target->save();

                    return $target;
                }
            }

        }
        return $this->resultFalse;
    }
}
