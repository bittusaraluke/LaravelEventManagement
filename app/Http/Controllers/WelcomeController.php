<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class WelcomeController extends Controller
{
    public function index()
    {
        $all_events = Events::paginate(10);
            return view('frontEnd.index',[
                        'all_events' => $all_events
                    ]);
        
    }
    public function filterEvent(Request $request){
        $input = $request->all(); 
        $given_from_date = $input['event_from_date'];
        $search_from_date = str_replace('/', '-', $given_from_date);
        $search_from_date_formated = date('Y-m-d', strtotime($search_from_date));

        $given_to_date = $input['event_to_date'];
        $search_to_date = str_replace('/', '-', $given_to_date);
        $search_to_date_formated = date('Y-m-d', strtotime($search_to_date));
        
        $all_events = Events::when(!empty($given_from_date) , function ($query) use($search_from_date_formated,$search_to_date_formated){
                    $query->where('start_date','>=',$search_from_date_formated);
                    $query->orWhere('end_date','<=',$search_to_date_formated);
                })
            ->get();
        //dd($all_events);exit;
         $returnHTML = (string)view('events.filterEventResult',[
                        'all_events' => $all_events,
                    ]);//->render();
        return response()->json( array('success' => true, 'html'=>$returnHTML) );

         
    }
    public function detailedEventSearch($search_value)
    {
        $all_events = Events::query()
                           ->where('event_name', 'LIKE', "%{$search_value}%") 
                           ->orWhere('start_date', 'LIKE', "%{$search_value}%")  
                           ->orWhere('end_date', 'LIKE', "%{$search_value}%")
                           ->orWhereHas('user', function($q) use ($search_value){
                               $q->where('first_name','like','%'.$search_value.'%');
                               $q->orWhere('last_name','like','%'.$search_value.'%');
                            })  
                           ->get();
        $returnHTML = (string)view('events.filterEventResult',[
                        'all_events' => $all_events,
                    ]);//->render();
        return response()->json( array('success' => true, 'html'=>$returnHTML) );
    }
    public function review()
    {
        //avg();
        $total_event_count = Events::/*where('status','=','Active')->*/count();
        $total_event_conductor =Events::/*where('status','=','Active')->*/distinct()->count('created_by');
        //User::all()->count();
        $average_event_count=round($total_event_count/$total_event_conductor);
        $users_avg_event_count_array =[];
        $all_users = User::all();


        foreach ($all_users as $key => $each_user) {
            $user_name = $each_user->first_name." ".$each_user->last_name;
            $event_count_by_user = Events::where('created_by','=',$each_user->id)->count();
            $avg_event_count_by_user = $event_count_by_user/$total_event_conductor;
           //echo $user_name."-".$avg_event_count_by_user;
            $users_avg_event_count_array[$user_name] = $avg_event_count_by_user;
        }
        
        //exit;
            return view('frontEnd.review',[
                        'total_event_count' => $total_event_count,
                        'total_event_conductor' => $total_event_conductor,
                        'average_event_count' => $average_event_count,
                        'users_avg_event_count_array' => $users_avg_event_count_array,
                    ]);
        
    }
}
