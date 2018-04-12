
<div class="uk-width-1">
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/tablebooking_exception/Do/Add" class="uk-button"><i class="fa fa-plus"></i> <?php echo Yii::t("default","Add New")?></a>
<a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/tablebooking_exception" class="uk-button"><i class="fa fa-list"></i> <?php echo Yii::t("default","List")?></a>
<!-- <a href="<?php echo Yii::app()->request->baseUrl; ?>/merchant/subCategoryList/Do/Sort" class="uk-button"><i class="fa fa-sort-alpha-asc"></i> <?php echo Yii::t("default","Sort")?></a>  -->
</div>

<form id="frm_table_list" method="POST" >
<input type="hidden" name="action" id="action" value="tablebookingexceptionList">
<input type="hidden" name="tbl" id="tbl" value="table_booking_exception">
<input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
<input type="hidden" name="whereid"  id="whereid" value="id">
<input type="hidden" name="slug" id="slug" value="tablebooking_exception/Do/Add">
<table id="table_list" class="uk-table uk-table-hover uk-table-striped uk-table-condensed">
  <caption>Merchant List</caption>
   <thead>
        <tr>             
            <th><?php echo Yii::t('default',"Customer Name")?></th>
            <th><?php echo Yii::t('default',"Mobile Number")?></th>            
            <th><?php echo Yii::t('default',"Occasion")?></th>
            <th><?php echo Yii::t('default',"No of seats")?></th>
            <th><?php echo Yii::t('default',"Booked Date")?></th>               
        </tr>
    </thead>
    <tbody> 
    </tbody>
</table>
<div class="clear"></div>
</form>