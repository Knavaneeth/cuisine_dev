<form class="profile-forms forms has-validation-callback" id="forms" onsubmit="return false;">
<?php echo CHtml::hiddenField('action','updateClientProfile')?>
<?php echo CHtml::hiddenField('currentController','store')?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo t("First Name")?></label>
                <?php 
				  echo CHtml::textField('first_name',$data['first_name'],
				  array(
					'class'=>'form-control',
					'data-validation'=>"required",
                    'data-validation'=>"length alphanumeric",
                    'data-validation-length'=>"min4"
				  ));
				?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo t("Last Name")?></label>
                <?php 
				echo CHtml::textField('last_name',$data['last_name'],
				array(
				'class'=>'form-control',
				'data-validation'=>"required",
                'data-validation'=>"length alphanumeric",
                    'data-validation-length'=>"min4"
				));
				?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo t("Email address")?></label>
                <?php 
				  echo CHtml::textField('email',$data['email_address'],
				  array(
					'class'=>'form-control',
					'data-validation'=>"required",
					'disabled'=>true
				  ));
				  ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo t("Contact phone")?></label>
                <?php 
				  echo CHtml::textField('contact_phone',$data['contact_phone'],
				  array(
					'class'=>'form-control mobile_inputs',
					'data-validation'=>"required"
				  ));
				  ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo t("Password")?></label>
                <?php 
				  echo CHtml::passwordField('password','',
				  array(
					'class'=>'form-control',                    
                    'data-validation'=>"length",
                    'data-validation-length'=>"min8"
				  ));
				  ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo t("Confirm Password")?></label>
                <?php 
				  echo CHtml::passwordField('cpassword','',
				  array(
					'class'=>'form-control',
                    'data-validation'=>"confirmation",
                    'data-validation-confirm'=>"password"
				  ));
				  ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary btn-block">Save</button>
        </div>
    </div>
</form>