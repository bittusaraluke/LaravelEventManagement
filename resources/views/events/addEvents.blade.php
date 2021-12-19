@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #eeeaf5;">{{ __('Add Event') }}</div>

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

                      <div id="error_msg" class="alert alert-dismissible alert-danger">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                       <span id="error_view" class="alert-link"></span>
                    </div>


                      <form method="post" action="{{ route('event-store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-form-label mt-2" for="event_name">Event Name</label>
                                  <input type="text" class="form-control" placeholder="Event Name" id="event_name" name="event_name" required>
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label mt-2" for="start_date">Start Date</label>
                                  <input type="text" class="form-control datepicker" placeholder="DD/MM/YYYY" id="start_date" name="start_date" required>
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label mt-2" for="end_date">End Date</label>
                                  <input type="text" class="form-control datepicker" placeholder="DD/MM/YYYY" id="end_date" name="end_date"  required>
                                  <input type="hidden" name="today" id="today" value="<?php echo date('d/m/Y');?>">
                                </div>
                               <!--  <div class="form-group">
                                  <label class="col-form-label mt-2" for="status">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="pending">Pending</option>
                                        <option value="active">Active</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </div> -->
                                <input id="submit_event" type="submit" class="btn btn-primary" value="{{ __('Submit') }}" style="text-align: center;" />
                            </div>
                            <div class="col-md-3"></div>

                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".datepicker").datepicker({
        minDate: 0,
    });
    $(document).ready(function(e) {
        $('#error_msg').hide(); 
        $('#error_view').html(""); 
        $(document).on("click", "#submit_event", function (e) {
            var event_start_on = $('#start_date').val();
            var event_end_on = $('#end_date').val();
            var today = $('#today').val();
            //alert(today);
            $('#error_msg').hide(); 
            $('#error_view').html(""); 
            if(Date.parse(event_start_on) < Date.parse(today) ){
                $('#error_msg').show(); 
                $('#error_view').html("Date must be in the future.");
                e.preventDefault();
            }
            if(Date.parse(event_end_on) < Date.parse(event_start_on)){
                $('#error_msg').show(); 
                $('#error_view').html("End date should be grater than sart date.");
                e.preventDefault();
            }
    
        });
    });
</script>
@endsection
