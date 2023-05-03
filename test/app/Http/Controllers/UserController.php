<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController
{
    public function index(){
        $users = DB::table('visits')->get();
        $visit_time_sort_order = 'asc';
        $sort = 'sortByToday';
        return view('data', compact('users', 'visit_time_sort_order', 'sort'));
    }

    public function filtration(Request $request){
        $sort = ($request->input('sort')) == '' ? 'SortByToday' : $request->input('sort');
        $VT_sort_order = ($request->input('visit_time_sort_order')) == '' ? 'asc' : $request->input('visit_time_sort_order');
        switch($sort){
           case "sortByToday":
                $users = DB::table('visits')
                    ->select(DB::raw("*, EXTRACT(EPOCH FROM (stop_time - start_time)) as duration"))
                    ->whereDate('start_time', Carbon::today())
                    ->orderBy('duration', $VT_sort_order)
                    ->get();
                break;
           case "sortByYesterday":
                $users = DB::table('visits')
                    ->select(DB::raw("*, EXTRACT(EPOCH FROM (stop_time - start_time)) as duration"))
                    ->whereDate('start_time', Carbon::yesterday())
                    ->orderBy('duration', $VT_sort_order)
                    ->get();
                break;
           case "sortByWeek":
                $users = DB::table('visits')
                    ->select(DB::raw("*, EXTRACT(EPOCH FROM (stop_time - start_time)) as duration"))
                    ->whereRaw('EXTRACT(WEEK FROM CAST(start_time AS DATE)) = EXTRACT(WEEK FROM NOW())')
                    ->orderBy('duration', $VT_sort_order)
                    ->get();
                break;
           case "sortByMonth":
                $users = DB::table('visits')
                    ->select(DB::raw("*, EXTRACT(EPOCH FROM (stop_time - start_time)) as duration"))
                    ->whereRaw('EXTRACT(MONTH FROM CAST(start_time AS DATE)) = EXTRACT(MONTH FROM NOW())')
                    ->orderBy('duration', $VT_sort_order)
                    ->get();
                break;
       }

       return view('data', ['users' => $users, 'sort' => $sort, 'visit_time_sort_order' => $VT_sort_order]);
   }
}
