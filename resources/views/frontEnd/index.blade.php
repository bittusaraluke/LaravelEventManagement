<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- datepicker -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
</head>
<body>
    
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Event Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/review') }}">Review</a>
                    </li>
                </ul>
                <div class="d-flex"> 
                    @if (Route::has('login'))
                    <ul class="navbar-nav me-auto ">
                        @auth
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/home') }}">Home
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('login') }}">Login
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('register') }}">Register
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        @endif
                        @endauth
                    </ul>
                    @endif
                </div>         
                       
                        
                <!-- </div> -->
            
                <!-- <form class="d-flex">
                    <input id="detailedEventSearch" class="form-control me-sm-2" type="text" placeholder="Search">
                    
                </form> -->
            </div>
        </div>
    </nav>
</header>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-12"> 
            <div class="card" style="margin-top: 50px;">
                <div class="card-header text-white bg-secondary" >{{ __('Events') }}
                     <div class="d-flex" style="float:right;">
                    <form class="d-flex">
                        <input id="detailedEventSearch" class="form-control me-sm-2" type="text" placeholder="Search">
                        
                    </form></div>
                </div>
                <div class="card-body">
                    <!-- search -->
                <div class="container">    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Filter By Date
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="div col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">From Date</label>

                                            <input id="event_from_date" class="form-control datepicker" placeholder="DD/MM/YYYY" type="text" name="event_from_date"  autofocus>

                                        </div>
                                    </div>
                                    <div class="div col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">To Date</label>

                                            <input id="event_to_date" class="form-control datepicker" placeholder="DD/MM/YYYY" type="text" name="event_to_date"  autofocus>

                                        </div>
                                    </div>
                                    <div class="div col-md-4">
                                        <div class="form-group">
                                            <label class="form-label"><br/></label>
                                            <br/>
                                            <input type="submit" id="search_submit" value="Search" class="btn btn-primary" />

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- search -->
                    <!-- <p>Date: <input type="text" class="datepicker"></p> -->

                        <div id="table_holder" style="margin-top:50px;">
                         @if(count($all_events)>0)   
                         <?php $count = 0;?>      
                            
                            <table class="table table-hover">
                                  <thead>
                                    <tr>
                                      <th scope="col">Event</th>
                                      <th scope="col">Start Date</th>
                                      <th scope="col">End Date</th>
                                      <th scope="col">Conducted By</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($all_events as $each_event)
                                  <?php $count++; ?>
                                  
                                    <tr class="<?php if($count%2 == 0){ echo ""; }else{ echo "table-primary"; } ?>">
                                      <td scope="row">{{$each_event->event_name}}</td>
                                      <td><?php echo date("d/m/Y", strtotime($each_event->start_date) ); ?></td>
                                      <td><?php echo date("d/m/Y", strtotime($each_event->end_date) ); ?></td>
                                      <td><?php if(!empty($each_event['user'])){ ?>{{$each_event['user']['first_name']}} {{$each_event['user']['last_name']}}
                                        <?php } ?></td>
                                      
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
    </div>
</div> 
<script>
    $(document).on("click", "#search_submit", function () {
      //alert("hi");
      var from_date = $('#event_from_date').val();
      var to_date = $('#event_to_date').val();
    
      $.ajax({
            type:"POST",
            data:{
                "_token": "{{ csrf_token() }}",
               "event_from_date": from_date,
                 "event_to_date": to_date,
                 
              },
            url:"{{url('/filter-event')}}",
            success:function(res){
                  if(res)
                  {
                     $('#table_holder').html(res['html']);
                  }
               }
         });

      
   });
</script>
<script>
  $( function() {
    $( ".datepicker" ).datepicker({
        dateFormat: "dd/mm/yy"
    });

  } );
  </script>
  <script>
$(document).ready(function(){
  $("#detailedEventSearch").keyup(function(){
    inputsearchval = $(this).val();
    
    $.ajax({
        type:"GET",
        url:"{{url('/event-details-search-result')}}"+"/"+inputsearchval,
        success:function(res){
            if(res)
            {
              $('#table_holder').html(res['html']);
              
            }
        }
    });
  });
});
</script>
</body>
</html>