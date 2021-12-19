<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" rel="stylesheet">

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
<div class="container">
    <div class="row" style="padding-top: 50px;">
        
            <!-- Avaerage Event count -->
        <div class="col-sm-12 col-md-4 text-center" > 
            <div class="card text-white bg-secondary mb-3" style="max-width: 20rem;">
                <div class="card-header">Average Event Count</div>
                <div class="card-body">
                    
                    <h4 class="card-title">
                        <i class="fas fa-calendar" style="margin-right:15px;"></i>
                    {{$average_event_count}}</h4>
                    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                </div>
            </div>
        </div>
        <!-- Total Event count -->
        <div class="col-sm-12 col-md-4 text-center" > 
            <div class="card text-white bg-danger mb-3" style="max-width: 20rem;">
                <div class="card-header">Total Events</div>
                <div class="card-body">
                    
                    <h4 class="card-title"><i class="fas fa-calendar-alt" style="margin-right:15px;"></i>{{$total_event_count}}</h4>
                    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                </div>
            </div>
        </div>
        <!-- Total User count -->
        <div class="col-sm-12 col-md-4 text-center" > 
            <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
                <div class="card-header">Total Event Conductor</div>
                <div class="card-body">
                    
                    <h4 class="card-title"><i class="fas fa-users" style="margin-right:15px;"></i>{{$total_event_conductor}}</h4>
                    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                </div>
            </div>
        </div>
        <!-- card end -->
    </div>

    <div class="row" style="margin-top:20px;">
        <div class="col-sm-12 col-md-3"></div>
        <div class="col-sm-12 col-md-6">

            <div id="table_holder" style="margin-top:50px;">
                         @if(count($users_avg_event_count_array)>0)   
                         <?php $count = 0;?>      
                            
                            <table class="table table-hover" border="1">
                                  <thead>
                                    <tr>
                                      <th scope="col">User Name</th>
                                      <th scope="col">Average Event</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  @foreach($users_avg_event_count_array as $key => $each_value)
                                  <?php $count++; 
                                        $avg[]=$each_value;
                                  ?>
                                  
                                    <tr class="<?php if($count%2 == 0){ echo ""; }else{ echo "table-primary"; } ?>">
                                      <td scope="row">{{$key}}</td>
                                      <td>{{$each_value}}</td>
                                      
                                      
                                    </tr>
                                     @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Total</td>
                                        <td>
                                            {{array_sum($avg)}}
                                            <br/>
                                            Round of {{round(array_sum($avg))}}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        
                        
                        @else
                          <h6 style="text-align: center;padding: 20px 0px;">No Events are available</h6>
                        @endif
                        </div>
            
        </div>
        <div class="col-sm-12 col-md-3"></div>
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