
<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/deliveryboys/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/deliveryboys" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
<!-- <a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/subCategoryList/Do/Sort" class="uk-button"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>  -->
</div>

<form id="frm_table_list" method="POST" >
<input type="hidden" name="action" id="action" value="deliveryboysList">
<input type="hidden" name="tbl" id="tbl" value="delivery_boys">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="id">
<input type="hidden" name="slug" id="slug" value="deliveryboys/Do/Add">
<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
  <caption>Merchant List</caption>
   <thead>
        <tr>
            <th><input type="checkbox" id="chk_all" class="chk_all"></th>
            <th><?php echo Yii::t('default',"Driver Name")?></th>
            <th><?php echo Yii::t('default',"Mobile Number")?></th>            
            <th><?php echo Yii::t('default',"Email ID")?></th>
            <th><?php echo Yii::t('default',"Driving License No")?></th>
            <th><?php echo Yii::t('default',"Created Date")?></th>  
            <th><?php echo Yii::t('default',"Status")?></th>            
        </tr>
    </thead>
    <tbody> 
    </tbody>
</table>
<div class="clear"></div>
</form>