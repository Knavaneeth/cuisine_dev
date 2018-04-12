<?php if ( $res=FunctionsV3::getMerchantOpeningHours($merchant_id)):?>
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="block-title-2"> Hours </h2>
            </div>
        </div> 
        <table class="table table-striped table-bordered">
            <tbody> 
        <?php foreach ($res as $val):?>
                <tr>
                  <td><?php echo ucfirst(t($val['day']))?></td>
                  <td><?php echo $val['hours']?></td>
                  <td><?php echo $val['open_text']?></td>
                </tr>  
        <?php endforeach;?>
           </tbody>
        </table>  
	</div>
</div>        
<?php else :?>
<div class="text-center alert alert-danger mb-0"> <?php echo t("Not available.")?> </div>
<?php endif;?>