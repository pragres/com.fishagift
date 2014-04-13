<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<form class="form-horizontal" role="form" action="<?php echo framework::link_to("admin/{$action}_wrap_submit"); if (isset($id)) echo '&id='.$id; ?>" method="post" enctype="multipart/form-data">
			<div class="col-lg-12">
				<h1><?php echo $title; ?></h1>

				<!--name-->
				<div class="form-group">
					<label for="name" class="col-lg-2 control-label">Name</label>
					<div class="col-lg-10">
						<input type="name" name="name" class="form-control" value="<?php echo $name; ?>" required/>
					</div>
				</div>

				<div class="form-group">
					<label for="desc" class="col-lg-2 control-label">Description</label>
					<div class="col-lg-10">
						<textarea rows="10" style="width:100%;" id="desc" name="description"><?php echo $description; ?></textarea><br/>
					</div>
				</div>
				
				<!--Colors-->
				<div class="form-group">
					<label for="color1" class="col-lg-2 control-label">Color</label>
					<div class="col-lg-2">
						<input type="color" name="color1" class="form-control" value="<?php echo $color1; ?>"/>
					</div>					
					<div class="col-lg-2">
						<input type="color" name="color2" class="form-control" value="<?php echo $color2; ?>"/>
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

				<!--Status-->
				<div class="form-group">
					<label for="status" class="col-lg-2 control-label">Status</label>
					<div class="col-lg-10">
						<select id="status" name="status" class="form-control" >
							<option value="Active" <?php if (isset($status)) if ($status == "Active") echo "selected"; ?>>Active</option>
							<option value="Inactive" <?php if (isset($status)) if ($status == "Inactive") echo "selected"; ?>>Inactive</option>
						</select>
					</div>
				</div>

				<!--images-->
				<div class="form-group">
					<label for="color1" class="col-lg-2 control-label">Images</label>
					<div class="col-lg-10">
						<table>
							<tr>
								<?php for($i=1;$i<=3;$i++) { ?>
									<td valign="bottom">  
										<?php $imagename = 'image'.$i; ?>
										<?php if (isset($$imagename)) if ($$imagename !='') { ?>
											<img class="admin-product-image" width="100" alt="Image not available" src="<?php echo framework::resolve("static/images/wraps/".$$imagename); ?>"><br/>
											<select name="cboImage<?php echo $i; ?>">
												<option value="1">Keep this image</option>
												<option value="2">Remove this image</option>
												<option value="3">Change this image with:</option>
											</select><br/>
										<?php } ?>
										<input type="file" name="image<?php echo $i; ?>"><br/>
									</td>
									<?php if ($i%3 == 0){ ?>
										</tr>
										<tr>
									<?php } ?>
								<?php } ?>
							</tr>
						</table>
					</div>
				</div>

				<!--buttons-->
				<div class="form-group text-center">
					<br/>
					<button rel="button" class="btn btn-primary btn-lg">Ok</button>
					<a href="<?php echo framework::link_to('admin/wraps'); ?>" class="btn btn-default btn-lg">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>