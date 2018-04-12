<?php if (is_array($data) && count($data)>=1):?>
<?php $payment_list=FunctionsV3::PaymentOptionList();?>
 <table class="table table-striped table-bordered">
    <thead>
        <tr>  
            <th>Guest Name</th>
            <th>Restaurant Name</th> 
            <th>Number of Guest</th>            
            <th>Date Booking</th>
            <th>Notes</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $val):?>  
        <tr>
            <td><p><?php echo ucfirst($val['booking_name']);?></p></td>
            <td> <p><?php echo clearString($val['restaurant_name'])?></p></td>
            <td><p><?php echo $val['number_guest'] ;?></p>  </td>
            <td>
                <p>
				<?php                              
				    echo date('d-M-Y',strtotime($val['date_booking'])) ." @ ".$val['booking_time'];
				  ?>
                </p>
            </td>
            <td><p><?php  if(strlen($val['booking_notes'])>10) { echo substr($val['booking_notes'],0,10)."..."; } else { echo $val['booking_notes']; } ?></p>  </td>
            <td>
                
					<?php echo t($val['status'])?>
        
            </td>
        </tr>
               
    <?php endforeach;?>
    </tbody>
</table>
<?php else :?>
   <p class="text-danger"><?php echo t("No Booking history")?></p>
<?php endif;?>