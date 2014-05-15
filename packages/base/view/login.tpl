<?php include_once framework::resolve('packages/base/view/header.tpl'); ?>
<?php include_once framework::resolve('packages/base/view/menu.tpl'); ?>

<!--section: body-->
<div id="section-body" class="container">
	<div class="col-lg-12">
		<h1><?php echo $i18n['session-header']; ?></h1>
		<?php if($errorWrongCredentials) { ?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $i18n['wrong-pass']; ?>
			</div>
		<?php } ?>

		<?php if($errorEmailNoExist) { ?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $i18n['nonexisting-email']; ?>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					displayResetPassword();
				});
			</script>
		<?php } ?>
		
		<?php if($errorUserExist) { ?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $i18n['email-exists']; ?>
			</div>
		<?php } ?>
	</div>

	<div class="row">
		<!--section: register-->
		<div id="section-register" class="col-lg-6 col-md-6 col-sm-6">
			<h2 style="text-align: center;	margin-top:0px;"><?php echo $i18n['register']; ?></h2>
			<p><?php echo $i18n['register-msg']; ?></p>
	
			<form class="form-horizontal" role="form" action="/router.php" method="post">
				<input type="hidden" name="package" value="base">
				<input type="hidden" name="page" value="register_submit">
				<input type="hidden" name="returnTo" value="<?php echo $returnTo; ?>"/>
	
				<div class="form-group">
					<label for="register" class="col-lg-3 col-md-3 col-sm-3 control-label"><?php echo $i18n['email']; ?></label>
					<div class="col-lg-9 col-md-9 col-sm-9">
						<input id="register" name="register" type="email" class="form-control" placeholder="<?php echo $i18n['email']; ?>" tabindex="3" required/>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-9 col-md-8 col-sm-7 col-xs-12">
						<div class="checkbox">
							<label>
								<input name="subscribe" type="checkbox" checked="checked" />
								<?php echo $i18n['subscribe']; ?>
							</label>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-5 col-xs-12 text-right">
						<button type="submit" class="btn btn-primary btn-phone space-top-20-xs"><?php echo $i18n['register']; ?></button>
					</div>
				</div>
			</form>
		</div>

		<!--section: login-->
		<div id="section-login" class="col-lg-6 col-md-6 col-sm-6" style="border-left: 1px dashed gray;">
			<div id="loginBox">
				<h2 style="text-align: center;	margin-top:0px;"><?php echo $i18n['login']; ?></h2>
	
				<form class="form-horizontal" role="form" action="/router.php" method="post">
					<input type="hidden" name="package" value="base"/>
					<input type="hidden" name="page" value="login_submit"/>
					<input type="hidden" name="returnTo" value="<?php echo $returnTo; ?>"/>
	
					<div class="form-group">
						<label for="email" class="col-lg-3 col-md-3 col-sm-3 control-label"><?php echo $i18n['email']; ?></label>
						<div class="col-lg-9 col-md-9 col-sm-9">
							<input id="email" name="email" type="email" class="form-control" placeholder="<?php echo $i18n['email']; ?>" tabindex="1" autofocus required/>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-lg-3 col-md-3 col-sm-3 control-label"><?php echo $i18n['password']; ?></label>
						<div class="col-lg-9 col-md-9 col-sm-9">
							<input id="password" name="password" class="form-control" type="password" placeholder="<?php echo $i18n['password']; ?>" tabindex="2" required/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12 text-right text-center-xs">
							<a href="#" onclick="displayResetPassword(); return false;" style="margin-right:10px;"><?php echo $i18n['forgot-pass']; ?></a>
							<button type="submit" class="btn btn-primary btn-phone space-top-10-xs"><?php echo $i18n['login']; ?></button>
						</div>
					</div>
				</form>
			</div>

			<!--section: reset password-->
			<div id="resetPasswordBox" style="display:none;">
				<h2 style="text-align: center;	margin-top:0px;"><?php echo $i18n['reset-header']; ?></h2>
				<p><?php echo $i18n['reset-msg']; ?></p>
	
				<form class="form-horizontal" role="form" action="/router.php" method="post">
					<input type="hidden" name="package" value="base"/>
					<input type="hidden" name="page" value="resetPassword_submit"/>
					<input type="hidden" name="returnTo" value="base/login"/>
	
					<div class="form-group">
						<label for="emailReset" class="col-lg-2 col-md-2 col-sm-2 control-label"><?php echo $i18n['email']; ?></label>
						<div class="col-lg-10 col-md-10 col-sm-10">
							<input id="emailReset" name="emailReset" type="email" class="form-control" placeholder="<?php echo $i18n['reset-email']; ?>" required/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12 text-right">
							<a class="btn btn-default btn-phone" href="#" onclick="hideResetPassword(); return false;"><?php echo $i18n['cancel']; ?></a>
							<button type="submit" class="btn btn-primary btn-phone space-top-10-xs"><?php echo $i18n['reset-header']; ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="col-lg-12 hidden-xs" style="padding:30px 100px 0px 100px;">
		<p><?php echo $i18n['start-session']; ?></p>
	</div>
</div>

<script type="text/javascript">
	function displayResetPassword(){
		$('#loginBox').slideUp('fast', function(){
			$('#resetPasswordBox').show();
			$('#emailReset').focus();
		});
	}

	function hideResetPassword(){
		$('#resetPasswordBox').slideUp('fast', function(){
			$('#loginBox').show();
		});
	}
</script>

<?php include_once framework::resolve('packages/base/view/footer.tpl'); ?>