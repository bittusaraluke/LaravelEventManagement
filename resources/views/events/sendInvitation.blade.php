@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #eeeaf5;">{{ __('Send Invitation') }}</div>

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
                   <form method="post" action="{{ route('send-invitation') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                @if(count($all_events)>0)  
                                <div class="form-group">
                                  <label for="event" class="form-label mt-4">Selected Event</label>
                                  <select class="form-select" name="eventId" id="eventId">
                                    @foreach($all_events as $each_event)
                                    <option value="{{$each_event->id}}" <?php if($event->id==$each_event->id){ echo "selected"; }?>>{{$each_event->event_name}}</option>
                                    @endforeach
                                  </select>
                                </div>
                                @endif

                                <div class="form-group">
                                    <label class="col-form-label mt-2" for="email">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                      <label class="col-form-label mt-2" for="subject">Subject</label>
                                      <input type="text" class="form-control" placeholder="subject" id="subject" name="subject" required>
                                    </input>
                                </div>
                                <!-- <div class="form-group">
                                      <label class="col-form-label mt-2" for="venue">Venue</label>
                                      <input type="text" class="form-control" placeholder="Venue" id="venue" name="venue" required>
                                </div> -->
                                 <input type="submit" class="btn btn-primary" value="{{ __('Submit') }}" style="text-align: center;" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
