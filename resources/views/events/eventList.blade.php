@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #eeeaf5;">{{ __('Events') }}
                    <a href='{{url("/create-event/")}}' class="btn btn-primary" style="float: right;"  >Add Event</a>
                    <!--data-toggle="modal" data-target="#addEventModal" -->
                </div>
                <div class="card-body">
                     @if(count($errors)>0 || session('response') || session('success') || session('failure'))
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-lg-12">
                            @if(count($errors)>0)
                               @foreach($errors->all() as $error)
                               <div class="alert alert-danger" role="alert">
                                  <span type="button" class="close" data-dismiss="alert" aria-hidden="true">×</span>{{$error}}!
                               </div>
                               @endforeach
                            @endif
                            @if(session('response'))
                            <div class="alert alert-primary" role="alert">
                               <span type="button" class="close" data-dismiss="alert" aria-hidden="true">×</span>{{session('response')}}!
                            </div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success" role="alert">
                               <span type="button" class="close" data-dismiss="alert" aria-hidden="true">×</span>{{session('success')}}!
                            </div>
                            @endif
                            @if(session('failure'))
                            <div class="alert alert-danger" role="alert">
                               <span type="button" class="close" data-dismiss="alert" aria-hidden="true">×</span>{{session('failure')}}!
                            </div>
                            @endif
                         </div>
                      </div>
                      @endif

                     @if(count($all_events)>0)     
                     <?php $count = 0;?>       
                    <table class="table table-hover">
                          <thead>
                            <tr>
                              <th scope="col">Event</th>
                              <th scope="col">Start Date</th>
                              <th scope="col">End Date</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($all_events as $each_event)
                          <?php $count++; ?>
                          
                            <tr class="<?php if($count%2 == 0){ echo ""; }else{ echo "table-primary"; } ?>">
                              <td scope="row">{{$each_event->event_name}}</td>
                              <td><?php echo date("d/m/Y", strtotime($each_event->start_date) ); ?></td>
                              <td><?php echo date("d/m/Y", strtotime($each_event->end_date) ); ?></td>
                              <td>
                                    <a href='{{url("/invite-to-event/")}}/{{$each_event->id}}' class="btn btn-primary">Invite to Event</a>
                                    <a href='{{url("/invitee-list/")}}/{{$each_event->id}}' class="btn btn-info">View Invitees</a>
                              </td>
                            </tr>
                             @endforeach
                            
                        </tbody>
                    </table>
                    <div style="text-align:center;">{{ $all_events->links() }}</div>
                    @else
                      <h6 style="text-align: center;padding: 20px 0px;">No Events are available</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
