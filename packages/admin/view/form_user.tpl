<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<form class="form-horizontal" role="form" action="<?php echo framework::link_to("admin/{$action}_submit");?>&email=<?php echo $email; ?>" method="post">
			<div class="col-lg-12">
				<?php if (isset($error)) { ?>
					<div class = "btn-danger " style = "padding: 5px;"><?php echo $error; ?></div>
				<?php } ?>

				<h1><?php echo $form_title;?></h1>

				<div class="form-group">
					<label for="email" class="col-lg-2 control-label">Email</label>
					<div class="col-lg-10">
						<input id="email" name="email" type="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>" required/>
					</div>
				</div>

				<div class="form-group">
					<label for="fullName" class="col-lg-2 control-label">Full name</label>
					<div class="col-lg-5">
						<input id="fullName" name="fullname" type="text" class="form-control" placeholder="Full name" value="<?php echo $fullName; ?>"/>
					</div>
				</div>
				
				<div class="form-group">
					<label for="sex" class="col-lg-2 control-label">Sex</label>
					<div class="col-lg-10">
						<select id="sex" name="sex" class="form-control">
							<option value="U" <?php if($sex=="U"){ ?> selected <?php } ?>>Unespecified</option>
							<option value="M" <?php if($sex=="M"){ ?> selected <?php } ?>>Male</option>
							<option value="F" <?php if($sex=="F"){ ?> selected <?php } ?>>Female</option>
							<option value="O" <?php if($sex=="O"){ ?> selected <?php } ?>>Other</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="birthdate" class="col-lg-2 control-label">Date of birth</label>
					<div class="col-lg-10">
						<input id="birthdate" name="birthdate" type="date" class="form-control" placeholder="Date of birth" value="<?php echo $birthdate; ?>"/>
					</div>
				</div>

				<div class="form-group">
					<label for="language" class="col-lg-2 control-label">Language</label>
					<div class="col-lg-10">
						<select id="language" name="language" class="form-control">
						`	<?php foreach($languages as $lang): ?>
							<option value="<?php echo $lang['CODE'];?>" <?php if($lang['CODE'] == $language) { ?> checked="checked" selected<?php } ?>><?php echo $lang['NAME']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-2"></div>
					<div class="col-lg-5">
						<h2>Account settings</h2>
					</div>
				</div>
				
				<div class="form-group">
					<div class="form-group">
						<label for="password" class="col-lg-2 control-label">Password</label>
						<div class="col-lg-5">
							<input id="password" name="password" type="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="password2" class="col-lg-2 control-label">Confirm password</label>
						<div class="col-lg-5">
							<input id="password2" name="password2" type="password" class="form-control" placeholder="Confirm password" value="<?php echo $password2; ?>"/>
						</div>
					</div>
				</div>

				<div class="form-group text-center">
					<br/>
					<button rel="button" class="btn btn-primary btn-lg">Ok</button>
					<a href="<?php echo framework::link_to('admin/users'); ?>" class="btn btn-default btn-lg">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>