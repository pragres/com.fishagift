<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<!--section: body-->
<div id="section-body" class="container">
	<form class="form-horizontal" role="form" action="<?php echo framework::link_to("store/profile_submit"); ?>" method="post" oninput="return validatePasswordMatch();">

		<!--subsection: personal information-->
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo $i18n['info-header']; ?></h1>
			</div>
		
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 ">
				<div class="form-group">
					<label for="firstName" class="col-lg-3 col-md-3 col-sm-4 control-label"><?php echo $i18n['info-name']; ?></label>
					<div class="col-lg-9 col-md-9 col-sm-8">
						<input id="fullName" name="fullName" type="text" class="form-control" placeholder="<?php echo $i18n['info-full-name']; ?>" value="<?php echo $fullName; ?>"/>
					</div>
				</div>
	
				<div class="form-group">
					<label for="sex" class="col-lg-3 col-md-3 col-sm-4 control-label"><?php echo $i18n['sex']; ?></label>
						<div class="col-lg-9 col-md-9 col-sm-8">
							<select id="sex" name="sex" class="form-control">
							<option value="U" <?php if($sex=="U"){ ?> selected <?php } ?>><?php echo $i18n['sex-unspecified']; ?></option>
							<option value="M" <?php if($sex=="M"){ ?> selected <?php } ?>><?php echo $i18n['sex-male']; ?></option>
							<option value="F" <?php if($sex=="F"){ ?> selected <?php } ?>><?php echo $i18n['sex-female']; ?></option>
							<option value="O" <?php if($sex=="O"){ ?> selected <?php } ?>><?php echo $i18n['sex-other']; ?></option>
						</select>
					</div>
				</div>
	
				<div class="form-group">
					<label for="dateOfBirth" class="col-lg-3 col-md-3 col-sm-4 control-label"><?php echo $i18n['info-dob']; ?></label>
					<div class="col-lg-9 col-md-9 col-sm-8">
						<input id="dateOfBirth" name="dateOfBirth" type="date" class="form-control" placeholder="<?php echo $i18n['info-dob']; ?>" value="<?php echo $dateOfBirth; ?>"/>
					</div>
				</div>
	
				<div class="form-group">
					<div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-9 col-sm-offset-4">
						<div class="checkbox">
							<label>
								<input name="subscribe" type="checkbox" <?php if($subscribe != 0 && $subscribe !== false) { ?> checked="checked" <?php } ?>/>
								<?php echo $i18n['subscribe']; ?>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 hidden-xs">
				<p><?php echo $i18n['info-help']; ?></p>
			</div>
		</div>


		<!--subsection: address-->
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo $i18n['address-header']; ?></h1>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<div class="form-group">
					<label for="address1" class="col-lg-3 col-md-3 col-sm-3 control-label"><nobr><?php echo $i18n['address-address']; ?> 1</nobr></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="address1" name="address1" class="form-control" type="text" placeholder="<?php echo $i18n['address-address']; ?> 1" value="<?php echo $address1; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="address2" class="col-lg-3 col-md-3 col-sm-3 control-label"><nobr><?php echo $i18n['address-address']; ?> 2</nobr></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="address2" name="address2" class="form-control" type="text" placeholder="<?php echo $i18n['address-address']; ?> 2" value="<?php echo $address2; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-3 col-lg-offset-3 col-md-3 col-md-offset-3 col-sm-5">
						<label for="state" class="control-label visible-xs">State</label>
						<select id="state" name="state" class="form-control">
							<option value=""><?php echo $i18n['address-state']; ?></option>
							<?php foreach ($statesUSA as $state) { ?>
								<option value="<?php echo $state['code']; ?>"><?php echo $state['name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-4">
						<label for="city" class="control-label visible-xs space-top-20-xs">City</label>
						<input name="city" type="text" class="form-control" placeholder="<?php echo $i18n['address-city']; ?>" value="<?php echo $city; ?>"/>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<label for="zipcode" class="control-label visible-xs space-top-20-xs">Zip Code</label>
						<input name="zipcode" type="text" class="form-control" placeholder="<?php echo $i18n['address-zipcode']; ?>" value="<?php echo $zipcode; ?>" pattern="[0-9]{5}" title="<?php echo $i18n['address-zipcode-title']; ?>"/>
					</div>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 hidden-xs">
				<p><?php echo $i18n['address-help']; ?></p>
			</div>
		</div>

		<!--subsection: security-->
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo $i18n['chnpass-header']; ?></h1>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
				<div class="form-group">
					<label for="oldPassword" class="col-lg-3 col-md-4 col-sm-4 control-label"><?php echo $i18n['chnpass-oldpass']; ?></label>
					<div class="col-lg-9 col-md-8 col-sm-8">
						<input id="oldPassword" name="oldPassword" type="password" class="form-control" placeholder="<?php echo $i18n['chnpass-oldpass']; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="newPassword" class="col-lg-3 col-md-4 col-sm-4 control-label"><?php echo $i18n['chnpass-newpass']; ?></label>
					<div class="col-lg-9 col-md-8 col-sm-8">
						<input id="newPassword" name="newPassword" type="password" class="form-control" placeholder="<?php echo $i18n['chnpass-newpass']; ?>" pattern="^.{6,}$" title="<?php echo $i18n['chnpass-newpass-title']; ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="repeatNewPassword" class="col-lg-3 col-md-4 col-sm-4 control-label"><?php echo $i18n['chnpass-repeatpass']; ?></label>
					<div class="col-lg-9 col-md-8 col-sm-8">
						<input id="repeatNewPassword" name="repeatNewPassword" type="password" class="form-control" placeholder="<?php echo $i18n['chnpass-repeatpass']; ?>"/>
					</div>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 hidden-xs">
				<p><?php echo $i18n['chnpass-help']; ?></p>
			</div>
		</div>

		<!--subsection: buttons-->
		<div class="col-lg-12 text-center" style="margin-top: 50px;">
			<button type="submit" class="btn btn-primary btn-lg btn-phone"><span class="glyphicon glyphicon-ok"></span> <?php echo $i18n['btn-saveprofile']; ?></button>				
		</div>
	</form>
</div>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>