<?php if (!empty($promo['offer'])):?>
<div class="row offers-promo mb-15">
    <div class="col-lg-12">
        <h2 class="block-title-2"> <?php echo t("Offers")?> </h2>
    </div>
    <div class="col-xs-12 col-sm-12">
        <p><?php echo $promo['offer']?></p>
    </div>
</div> 
<?php endif;?>

<?php if (isset($promo['voucher'])):?>
<?php if (is_array($promo['voucher']) && count($promo['voucher'])>=1):?>

<div class="row vouchers-promo mb-15">
    <div class="col-lg-12">
        <h2 class="block-title-2"> Vouchers </h2>
    </div>
    <div class="col-xs-12 col-sm-12">
    <?php foreach ($promo['voucher'] as $val): 
      if ( $val['voucher_type']=="fixed amount"){
      	  $amount=FunctionsV3::prettyPrice($val['amount']);
      } else $amount=number_format( ($val['amount']/100)*100 )." %";
		?>
		   <p> <?php echo $val['voucher_name']." - ".$amount." ".t("Discount")?> </p>
		<?php endforeach;?> 
    </div>
</div>  
<?php endif;?>
<?php endif;?>  

<?php if (!empty($promo['free_delivery'])):?> 
<div class="row delivery-promo mb-15">
    <div class="col-lg-12">
        <h2 class="block-title-2"> Delivery </h2>
    </div>
    <div class="col-xs-12 col-sm-12">
        <p> <?php  echo t("Free Delivery On Orders Over")." ". FunctionsV3::prettyPrice($promo['free_delivery'])?></p> 
    </div>
</div>
<?php endif;?>   