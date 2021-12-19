@extends('layouts.app')

@section('content')
<script src="{{ asset('js/app.js') }}" defer></script>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #eeeaf5;">{{ __('Invitee List') }}</div>

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
                    <div class="row">
                        <div class="col-md-12">
                            @if(count($all_events)>0)  
                            <div class="form-group">
                              <label for="event_sel" class="form-label mt-4">Selected Event</label>
                              <select class="form-select" id="event_sel" disabled>
                                @foreach($all_events as $each_event)
                                <option value="{{$each_event->id}}" <?php if($event->id==$each_event->id){ echo "selected"; }?>>{{$each_event->event_name}}</option>
                                @endforeach
                              </select>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div id="invitee_list">
                                @if(count($all_invitees)>0)     
                     <?php $count = 0;?>       
                    <table class="table table-hover">
                          <thead>
                            <tr>
                              <th scope="col">Email</th>
                              <th scope="col">Invited On</th>
                              <th scope="col">User/or not</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>

                          @foreach($all_invitees as $key => $value)
                            
                          <?php $count++; ?>
                          
                            <tr class="<?php if($count%2 == 0){ echo ""; }else{ echo "table-primary"; } ?>">
                              <td scope="row">{{$value['email']}}</td>
                              <td scope="row"><?php echo date("d/m/Y", strtotime($value['invited_on']) ); ?></td>
                              <td>{{$value['user_or_not']}}</td>
                              <td>
                                <?php  if($value['user_or_not']=="Yes"){?>
                                    <a href="#" class="btn btn-danger delete_datacenter remove_invitee" data-toggle="modal" data-target="#removeConfirmationModal" data-id="{{ $value['each_invitee_id'] }}">Remove</a>
                                <?php } ?>
                            </td>
                              
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    
                    @else
                      <h6 style="text-align: center;padding: 20px 0px;">No Invitees are available for this Event</h6>
                    @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- confirmation model -->

<div class="modal fade confirm" id="removeConfirmationModal" tabindex="-1" role="dialog"  aria-hidden="true">
   <div class="modal-dialog modal-md" role="document">
      <div class="modal-content ">
         <div class="modal-header">
            <h5 class="modal-title" id="example-Modal3">Remove Invitee</h5>
            <span type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </span>
         </div>
         <div class="modal-body">
            Are you sure you want to remove this Invitee?
         </div>
         <div class="modal-footer">
            
            <input type="hidden" name="invitee_id" id="invitee_id"/>
            <span id="yes_remove_invitee" class="btn btn-success" >Yes</span>
            <span id="no_remove_invitee" class="btn btn-danger" data-dismiss="modal">No</span>
         </div>
            
         </div>
         
      </div>
   </div>
</div>
<!-- confirmation model -->
<script>
    $(document).on("click", ".remove_invitee", function () {
      var invitee_id = $(this).data('id');
      var event_id = $('#event_sel').val();
        //alert(event_id);
      $("#removeConfirmationModal #invitee_id").val(invitee_id);
      
  });
    $(document).on("click", "#yes_remove_invitee", function () {
        var invitee_id = $('#invitee_id').val();
        var event_id = $('#event_sel').val();
        //alert(event_id);
        $.ajax({
            type:"POST",
            data:{
                "_token": "{{ csrf_token() }}",
               "invitee_id": invitee_id,
                 "event_id": event_id,
                 
              },
            url:"{{url('/remove-invitee')}}",
            success:function(res){
                  if(res)
                  {

                    $('.modal-backdrop').removeClass('show');
                    $('#removeConfirmationModal').removeClass('show');
                    $('#removeConfirmationModal').modal('hide');
                     $('#invitee_list').html(res['html']);
                  }
               }
         });

        
          
    });
</script>
@endsection
