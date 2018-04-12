<?php if (is_array($data) && count($data)>=1):?>
<?php $payment_list=FunctionsV3::PaymentOptionList();?>
  <table id="order_history_dataTable" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Id</th>
            <th>Merchant</th>
            <th>Amount</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Reorder</th>
        </tr>
    </thead>
    <tbody>
    <?php  
    foreach ($data as $val):?>  
        <tr>
            <td>
                <div class="order-details">
                    <a href="javascript:;" class="view-receipt-front" data-id="<?php echo $val['order_id']?>" >
                     <span><?php echo t("Order")?> #<?php echo $val['order_id']?></span>
                    </a>
					<span class="order-time"><?php echo t("Placed on "); echo date('j M Y H:i A',strtotime($val['date_created'])) ?></span> 
                 </div>
            </td>
            <td>
                <a href="<?php echo Yii::app()->getBaseUrl(true)."/store/menu/merchant/".$val['restaurant_slug']; ?>" data-id="<?php echo $val['order_id']?>" >    
                	<p><?php echo clearString($val['merchant_name'])?></p>    
                </a>
            </td>
            <td><p><?php echo FunctionsV3::prettyPrice($val['bill_total'])?></p>  </td>
            <td>
                <p>
				<?php 
                    $payment_type = '';
				  if (array_key_exists($val['payment_type'],$payment_list))
                  {  
					 $payment_type = trim($payment_list[$val['payment_type']]);
                     
				  } else $payment_type = trim($val['payment_type']);
                  if($payment_type=="Cash On delivery")
                  {
                    $payment_type = "cash"; 
                  }  
                   echo  ucfirst($payment_type);
				  ?>
                </p>
            </td>
            <td>
                <a href="javascript:;" class="view-order-history label label-success" data-id="<?php echo $val['order_id'];?>">
					<?php echo t($val['status'])?>
                </a> 
            </td>
            <td>
                <a href="javascript:;" class="add-to-cart label label-success" data-id="<?php echo $val['order_id'];?>">
                Repeat Order
                </a> 
            </td>
        </tr>
    <!--    <tr class="order-order-history show-history-<?php echo $val['order_id']?>"> 
            <td colspan="5">
             <?php if ( $resh=FunctionsK::orderHistory($val['order_id'])):?>     
             <table class="table table-striped table-bordered" >
               <thead>
                 <tr style="font-size:13px;">
                     <th><?php echo t("Date/Time")?></th>
                     <th><?php echo t("Status")?></th>
                     <th><?php echo t("Remarks")?></th>
                 </tr>
               </thead>
               <tbody>
				   <?php foreach ($resh as $valh):?>
                   <tr style="font-size:12px;">
                     <td><?php  echo date('j M Y H:i A',strtotime($valh['date_created'])) /* echo FormatDateTime($valh['date_created'],true); */ ?></td>
                     <td><?php echo t($valh['status'])?></td>
                     <td><?php echo $valh['remarks']?></td>
                   </tr>
                   <?php endforeach;?>
               </tbody>
             </table>
             <?php else :?>
             <p class="text-danger small-text"><?php echo t("No history found")?></p>
             <?php endif;?>
            </td>
      </tr>        -->
    <?php endforeach;?>
    </tbody>
</table>  


<!--    <table id="order_history_dataTable" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
            </tr>
            <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
            </tr>
            <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012/03/29</td>
                <td>$433,060</td>
            </tr>
            <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>2008/11/28</td>
                <td>$162,700</td>
            </tr>
            <tr>
                <td>Brielle Williamson</td>
                <td>Integration Specialist</td>
                <td>New York</td>
                <td>61</td>
                <td>2012/12/02</td>
                <td>$372,000</td>
            </tr>
            <tr>
                <td>Herrod Chandler</td>
                <td>Sales Assistant</td>
                <td>San Francisco</td>
                <td>59</td>
                <td>2012/08/06</td>
                <td>$137,500</td>
            </tr>
            <tr>
                <td>Rhona Davidson</td>
                <td>Integration Specialist</td>
                <td>Tokyo</td>
                <td>55</td>
                <td>2010/10/14</td>
                <td>$327,900</td>
            </tr>
            <tr>
                <td>Colleen Hurst</td>
                <td>Javascript Developer</td>
                <td>San Francisco</td>
                <td>39</td>
                <td>2009/09/15</td>
                <td>$205,500</td>
            </tr>
            <tr>
                <td>Sonya Frost</td>
                <td>Software Engineer</td>
                <td>Edinburgh</td>
                <td>23</td>
                <td>2008/12/13</td>
                <td>$103,600</td>
            </tr>             
        </tbody>
    </table> -->




<?php else :?>
   <p class="text-danger"><?php echo t("No order history")?></p>
<?php endif;?>