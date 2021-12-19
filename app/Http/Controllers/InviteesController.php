<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invitees;
use App\Events;
use App\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

class InviteesController extends Controller
{
    public function sendInvitation(Request $request){
        $invitees = new Invitees();
        $validator = Validator::make($request->all(), [ 
                'eventId' => 'required',
                'email' => 'required',
                'subject' => 'required',
            ]);
        $errors = $validator->errors();
        if ($validator->fails()) { 
            return redirect()->back()->withErrors($errors);      
        }else{

            $input = $request->all();
            $event=$input['eventId']; 
            $to_email=$input['email']; 
            $subject=$input['subject'];
/*check already invited or not*/
            $invited_obj = Invitees::where('email','=',$to_email)->where('eventId','=',$event)->first();
            if(!empty($invited_obj)){
                return redirect()->back()->with('failure','The invitation has already been sent to this selected email.');
            }else{
    /* getting event information for making invitation body part */

                $events_obj = Events::where('id','=',$event)->first();
                $event_name=$events_obj->event_name;
                $event_start_date =$events_obj->start_date;
                $event_end_date =$events_obj->end_date;
                $event_conductor =$events_obj['user']['first_name'].' '.$events_obj['user']['last_name'];
    /*saving invitation history*/
                 
                $invitees['email'] = $input['email']; 
                $invitees['eventId'] = $input['eventId']; 
                $invitees['invited_on'] = date('Y-m-d'); 
                $invitees['status'] = "Invited";
                $invitees['created_by'] = Auth::user()->id;

    /*invitation mail sending*/
                $details = [
                    'subject' => $subject,
                    'event_name' => $event_name,
                    'event_start_date' => $event_start_date,
                    'event_end_date' => $event_end_date,
                    'event_address' => 'Trivandrum Technopark',
                    'event_time' => '11.00 am',            
                    'user' => $event_conductor,            
                ];
                \Mail::to($to_email)->send(new \App\Mail\EventInvitationMail($details));

                $updated_invitee = $invitees->save();
                
                if($updated_invitee){
                    return redirect('home')->with('success','Invitation sent successfully');  
                }else{
                    return redirect('home')->with('error','Failed send Invitation.');  
                } 
            }
        }
    }

    public function inviteeList($event_id)
    {
        $all_events = Events::all();
        $event = Events::where('id','=',$event_id)->first();
           $logged_user = Auth::user()->id;
             $all_invitees_list = Invitees::where('eventId','=',$event_id)/*->select('id','email')->groupBy('email')*/->get();
             $all_invitees = [];
             foreach ($all_invitees_list as $key => $each_invitee) {
                $each_invitee_email = $each_invitee->email;
                $each_invitee_id = $each_invitee->id;
                $invited_on = $each_invitee->invited_on;
                //echo $each_invitee_id;
                if(User::where('email','=',$each_invitee_email)->exists()){
                    $user_or_not = "Yes";
                }else{
                    $user_or_not = "No";
                }
                $all_invitees[]=array(
                                        'email'=>$each_invitee_email,
                                        'user_or_not'=>$user_or_not,
                                        'each_invitee_id'=>$each_invitee_id,
                                        'invited_on'=>$invited_on,
                                        );
             }

             //print_r($all_invitees);
//exit;
            return view('events.inviteeList',[
                        'all_invitees' => $all_invitees,
                        'event' => $event,
                        'all_events' => $all_events
                    ]);
        
    }

    public function removeInvitee(Request $request)
    {
        $input = $request->all(); 
        
        $invitee_id = $input['invitee_id'];
        $event_id = $input['event_id'];

       $delete_invitee =  Invitees::where('id', $invitee_id)
            ->delete();
            if($delete_invitee){

        $all_invitees_list = Invitees::where('eventId','=',$event_id)->get();
             $all_invitees = [];
             foreach ($all_invitees_list as $key => $each_invitee) {
                $each_invitee_email = $each_invitee->email;
                $each_invitee_id = $each_invitee->id;
                if(User::where('email','=',$each_invitee_email)->exists()){
                    $user_or_not = "Yes";
                }else{
                    $user_or_not = "No";
                }
                $all_invitees[]=array(
                                        'email'=>$each_invitee_email,
                                        'user_or_not'=>$user_or_not,
                                        'each_invitee_id'=>$each_invitee_id,
                                        );
             }
         $returnHTML = (string)view('events.inviteeListAjaxResult',[
                        'all_invitees' => $all_invitees,
                        
                    ]);
        return response()->json( array('success' => true, 'html'=>$returnHTML) );
        
        /*return redirect('datacenter')->with('response','Data Center deleted successfully');  */

            }
    }
}
