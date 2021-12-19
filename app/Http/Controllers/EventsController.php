<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Events;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class EventsController extends Controller
{
    public function index()
    {
    	   $logged_user = Auth::user()->id;
             $all_events = Events::where('created_by','=',$logged_user)->paginate(10);
            return view('events.eventList',[
                        'all_events' => $all_events
                    ]);
        
    }
    public function create()
    {
       return view('events.addEvents');
    }

    public function store(Request $request){
    
        $event = new Events();
        $validator = Validator::make($request->all(), [ 
                'event_name' => 'required',
                'start_date' => 'required|after:yesterday',
                'end_date' => 'required|after:yesterday'
            ]);
        $errors = $validator->errors();
        if ($validator->fails()) { 
            return redirect()->back()->withErrors($errors);      
        }else{
           	$input = $request->all();
           	$start_date=$input['start_date']; 
           	$end_date=$input['end_date']; 
           	$event['event_name'] = $input['event_name'];
           	$event['start_date'] = date('Y-m-d',strtotime(str_replace("/","-",$start_date)));//$input['start_date'];
           	$event['end_date'] = date('Y-m-d',strtotime(str_replace("/","-",$end_date)));//$input['end_date'];
           // $event['status'] = $input['status'];
           $event['status'] = "Active";
            $event['created_by'] = Auth::user()->id;
            $updated_event = $event->save();
            
            if($updated_event){
                return redirect('home')->with('success','Event updated successfully');  
            }else{
                return redirect('home')->with('error','Failed update Event.');  
            }
        }
    }
    
    public function createInvitation($eventid)
    {
      $all_events = Events::all();
      $event = Events::where('id','=',$eventid)->first();
       return view('events.sendInvitation',[
                        'event' => $event,
                        'all_events' => $all_events
                    ]);
    }

    /*public function inviteeList($eventid)
    {
      $all_events = Events::all();
      $event = Events::where('id','=',$eventid)->first();
       return view('events.inviteeList',[
                        'event' => $event,
                        'all_events' => $all_events
                    ]);
    }*/
    
}
