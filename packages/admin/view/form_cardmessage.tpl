<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<form class="form-horizontal" role="form" action="<?php echo framework::link_to("admin/{$action}_cardmessage_submit"); if (isset($id)) echo '&id='.$id; ?>" method = "post">
			<div class="col-lg-12">
				<h1><?php echo $title; ?></h1>

				<!--message-->
				<div class="form-group">
					<label for="message" class="col-lg-2 control-label">Message</label>
					<div class="col-lg-10">
						<textarea id="text" class="form-control" rows="10" name="text"><?php echo $text; ?></textarea>
					</div>
				</div>

				<!--Occasion-->
				<div class="form-group">
					<label for="occasion" class="col-lg-2 control-label">Occasion</label>
					<div class="col-lg-10">
						<select id="occasion" name="occasion" class="form-control" >
							<?php foreach($occasions as $oca){ ?>
								<option value="<?php echo $oca['ID']; ?>" <?php if ($occasion == $oca['ID']) echo "selected"; ?>>
									<?php echo $oca['NAME']; ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>

				<!--Language-->
				<div class="form-group">
					<label for="language" class="col-lg-2 control-label">Language</label>
					<div class="col-lg-10">
						<select id="language" name="language" class="form-control">
							<?php foreach($languages as $l): ?>
							<option value="<?php echo $l['CODE']; ?>" <?php if($language==$l['CODE']){ ?> drlrvyrf <?php } ?>><?php echo $l['NAME']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<!--buttons-->
				<div class="form-group text-center">
					<br/>
					<button rel="button" class="btn btn-primary btn-lg">Ok</button>
					<a href="<?php echo framework::link_to('admin/cardmessages'); ?>" class="btn btn-default btn-lg">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>