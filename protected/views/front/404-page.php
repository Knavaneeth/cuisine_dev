<div class="not-found">
	<div class="row">
		<div class="col-md-12  text-center">
			<h1><?php echo t("404")?></h1>
			<h3><?php echo t("Sorry but we cannot find what you are looking for")?></h3>
			<p>
				<?php echo t("Page doesn't exist or some other error occured. Go to our")?>
				<a class="bold" href="<?php echo Yii::app()->createUrl('/store')?>"><?php echo t("home")?></a> <?php echo t("or go back to")?> 
				<a href="javascript:window.history.back();" class="bold"> <?php echo t("previous page")?></a>
			</p>
		</div>
	</div>
</div>