<?php
$this->renderPartial('/front/default-header',array(
   'h1'=>t("Browse Restaurant"),
   'sub_text'=>t("choose from your favorite restaurant")
));
?>
<div class="actions-bar tsticky restaurant-bar">
    <div class="container">
		<div class="custom-tab">
			<ul id="tabs" class="nav nav-tabs">
				<li class="<?php echo $tabs==1?"active":''?> noclick"  >
					<a href="<?php echo Yii::app()->createUrl('/store/browse')?>">
						<span><?php echo t("Restaurant List")?></span>
					</a>
				</li>
				<li class="<?php echo $tabs==3?"active":''?> noclick" >
					<a href="<?php echo Yii::app()->createUrl('/store/browse/?tab=3')?>">
						<span><?php echo t("Featured Restaurant")?></span>
					</a>
				</li>
				<li class="full-maps nounderline">				  
					<a href="javascript:;" >
						<span><?php echo t("View Restaurant by map")?></span>	 
					</a>   
				</li>
			</ul>	
		</div>
    </div>
</div>
<div class="page-content">
	<div class="container">
		<div class="tabs-wrapper">
			<ul id="tab" class="tab-content">
				<li class="tab-pane <?php echo $tabs==1?"active":''?>" >            
					<?php
					if ( $tabs==1):
						if (is_array($list['list']) && count($list['list'])>=1){
							$this->renderPartial('/front/browse-list',array(
							   'list'=>$list,
							   'tabs'=>$tabs
							));
						} else echo '<p class="text-danger">'.t("No restaurant found").'</p>';
					endif;
					?>
				</li>
				<li class="tab-pane <?php echo $tabs==3?"active":''?>" >
					<?php          
					if ( $tabs==3):
						if (is_array($list['list']) && count($list['list'])>=1){
							$this->renderPartial('/front/browse-list',array(
							   'list'=>$list,
							   'tabs'=>$tabs
							));
						} else echo '<p class="text-danger">'.t("No restaurant found").'</p>';
					endif;
					?>
				</li>
				<li class="tab-pane">
					<div class="full-map-wrapper" >
						<div id="full-map"></div>
						<a href="javascript:;" class="view-full-map btn btn-primary"><?php echo t("View in fullscreen")?></a>
					</div>
				</li>          
			</ul>     
		</div>
	</div>
</div>