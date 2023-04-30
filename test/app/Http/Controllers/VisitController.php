<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Visit;
use Carbon\Carbon;

class VisitController
{

    public function index(Request $request) {

        $ip = $request->ip();
        $start = now(); //Timer start
        $stop = null; //Timer stop - default value: null
        $visit = Visit::where('ip', $ip)->latest('start_time')->first();

        if ($visit){ // if this entry exists
            if ($visit->stop_time == $visit->start_time){ //if stop_time == start_time -> user on page
                $start = $visit->start_time; //update start_time = last start_time
                return view('welcome');
            }
        }

        $newVisit = new Visit;
        $newVisit->ip = $ip;
        $newVisit->start_time = $start;
        $newVisit->stop_time = $start;
        $newVisit->visit_time = '';
        $newVisit->save();

        return view('welcome');
    }

    public function saveVisit(Request $request){

        $ip = $request->ip(); // user ip
        $visit = Visit::where('ip', $ip)->latest('start_time')->first(); // last entry with ip = $ip

        if(isset($visit->start_time)){
            $stop_time = Carbon::parse(now());
            $visit = Visit::where('ip', $ip)->latest('start_time')->first();
            $start_time = Carbon::parse($visit->start_time); // parse any dateTime value from string to dataTime

            if ($visit){
                if (($visit->stop_time)==($visit->start_time)){ // if stop_time = start_time => this entry needs completion 
                    $visit_time = $start_time->diff($stop_time);
                    $visit->update([ // entry completion
                        'stop_time' => $stop_time,
                        'visit_time' => $visit_time->format('%d дней %h часов %i минут %s секунд'),
                    ]);
                }
            }
        }

        if(Auth::check()){
            return redirect()->route('data');
        }
        else{
            return view('login');
        }
    }
}
