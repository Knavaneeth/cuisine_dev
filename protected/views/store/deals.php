<div class="page-content contact-page">
	<div class="container">
		<div class="row row-sm">
			<div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
				<div class="deals-content">
	              <h1 class="deals-title">Deals</h1>
	            <?php 				
					if($deals_list = Yii::app()->functions->get_all_merchant_deals())
					{						
						foreach ($deals_list as $value) 
						{
							echo '<div class="deals-list panel">';
							?>
							<div class="panel-heading">
								<h2 class="m-b-0"><a href="<?php echo Yii::app()->getBaseUrl(true); ?>/store/menu/merchant/<?php echo $value['restaurant_slug']; ?>" target="_blank"> <?php echo stripslashes($value['merchant_name']); ?></a></h2>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-hover m-b-0">
										<thead>
											<tr>							        
												<th>Expires In</th>
												<th class="col-md-4">Title</th>
												<th class="col-md-4">Description</th>
											</tr>
										</thead>
										<tbody>			
											<?php foreach ($value['deals_list'] as $deals_details) 
											{
											date_default_timezone_set('Europe/Jersey'); 
											$current_date = strtotime(date("Y-m-d"));

											$now = time(); // or your date as well
											$your_date = strtotime($deals_details['to_date']);

											$datediff = $your_date-$current_date;

											$expires_in = floor($datediff / (60 * 60 * 24));

											if($expires_in==0)
											{
												$expires_in = " Today ";
											} 
											else if($expires_in==1)
											{
												$expires_in = " Tommorrow ";
											}
											else
											{
												$expires_in = $expires_in." Days ";
											}									 
											?>					       
											<tr>							         							      	
												<td><?php echo $expires_in; ?></td> 
												<td><?php echo $deals_details['title']; ?></td> 
												<td><?php echo $deals_details['description']; ?></td>
											</tr> 
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						<?php
							echo "</div>";
						}						
					}
				?>
				</div>
			</div> 
		</div>
	</div>
</div>