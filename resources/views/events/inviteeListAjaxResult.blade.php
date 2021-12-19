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
                              <td scope="row"><?php echo date("d/m/Y", strtotime($each_event->invited_on) ); ?></td>
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