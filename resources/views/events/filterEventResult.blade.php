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
  
  
  @else
    <h6 style="text-align: center;padding: 20px 0px;">No Events are available</h6>
  @endif