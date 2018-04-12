<?php if (is_array($data) && count($data)>=1):?>
<?php
    $merchant_id=$data['merchant_id'];
    $json_details=!empty($data['json_details'])?json_decode($data['json_details'],true):false;
    if ( $json_details !=false){
	    Yii::app()->functions->displayOrderHTML(array(
	       'merchant_id'=>$data['merchant_id'],
	       'order_id'=>$data['order_id'],
	       'delivery_type'=>$data['trans_type'],
	       'delivery_charge'=>$data['delivery_charge'],
	       'packaging'=>$data['packaging'],
	       'cart_tip_value'=>$data['cart_tip_value'],
		   'cart_tip_percentage'=>$data['cart_tip_percentage'],
		   'card_fee'=>$data['card_fee'],
		   'donot_apply_tax_delivery'=>$data['donot_apply_tax_delivery'],
		   'points_discount'=>isset($data['points_discount'])?$data['points_discount']:'' /*POINTS PROGRAM*/
	     ),$json_details,true);
	     
	     $data2=Yii::app()->functions->details;
	     
	     $merchant_info=Yii::app()->functions->getMerchant(isset($merchant_id)?$merchant_id:'');
         $full_merchant_address=$merchant_info['street']." ".$merchant_info['city']. " ".$merchant_info['state'].
         " ".$merchant_info['post_code'];

		 if (isset($data['contact_phone1'])){
			if (!empty($data['contact_phone1'])){
				$data['contact_phone']=$data['contact_phone1'];
			}
		 }				
		 if (isset($data['location_name1'])){
			if (!empty($data['location_name1'])){
				$data['location_name']=$data['location_name1'];
			}
		}
    }    
?>
  
 <table class="table table-striped order-det-table">
    <tbody>	
        <tr>
            <td>Customer Name</td>
            <td class="text-right"><?php echo $data['full_name']; ?></td>
        </tr>
        <tr>
            <td>Merchant Name</td>
            <td class="text-right"><?php echo $data['merchant_name']; ?></td>
        </tr>
        <tr>
            <td>Telephone</td>
            <td class="text-right">9524065882</td>
        </tr>
        <tr>
            <td>Address</td>
            <td class="text-right">address1 city Region 641004</td>
        </tr>
        <tr>
            <td>TRN Type</td>
            <td class="text-right">delivery</td>
        </tr>
        <tr>
            <td>Payment Type</td>
            <td class="text-right">cod</td>
        </tr>
        <tr>
            <td>Reference #</td>
            <td class="text-right">2</td>
        </tr>
        <tr>
            <td>TRN Date</td>
            <td class="text-right">Nov 01,2016 23:43:57</td>
        </tr>
        <tr>
            <td>Delivery Date</td>
            <td class="text-right">Nov 01,2016</td>
        </tr>
        <tr>
            <td>Deliver to</td>
            <td class="text-right">sr avenue coimbatore tamilnadu 641035</td>
        </tr>
        <tr>
            <td>Location Name</td>
            <td class="text-right">Coimbatore</td>
        </tr>
        <tr>
            <td>Contact Number</td>
            <td class="text-right">+919843014641</td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered order-price-table">
   <thead>
        <tr>
            <th>Qty</th>
            <th>Product Name</th>
            <th>Price</th>
            <th><span class="pull-right">Total</span></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span>1</span></td>
            <td>The Big J Burger</td>
            <td><span class="base-price">$ 20</span></td>
            <td><span class="pull-right">$ 3.50</span></td>
        </tr>
        <tr>
            <td colspan="4">
                Subtotal <span class="pull-right">$ 3.50</span>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                Delivery Fee <span class="pull-right">$ 0</span>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="total">
                TOTAL <span class="pull-right">$ 10.00</span>
            </td>
        </tr>
    </tbody>
</table> 

<?php else :?>
<div class="container center top30">
  <p class="text-danger"><?php echo t("receipt not available")?></p>
</div>  
<?php endif;?>