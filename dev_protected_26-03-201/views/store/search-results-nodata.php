<?php 
$search_address=isset($_GET['s'])?$_GET['s']:'';
if (isset($_GET['st'])){
	$search_address=$_GET['st'];
}
$this->renderPartial('/front/search-header',array(
   'search_address'=>$search_address,
   'total'=>0
));?>

<?php 
/*$this->renderPartial('/front/order-progress-bar',array(
   'step'=>2,
   'show_bar'=>true
));*/

echo CHtml::hiddenField('current_page_url',isset($current_page_url)?$current_page_url:'');
?>
 
<div class="page-content">
    <div class="container">
        <div class="row">
        	<div class="col-md-12 result-count">
                <br />
                <br />
                <br />
				<h2> No Data Available </h2>
                <br />
                <br />
                <br />
			</div>
        </div>
    </div>
</div>