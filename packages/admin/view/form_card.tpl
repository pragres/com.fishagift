<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<form class="form-horizontal" role="form" action="<?php echo framework::link_to("admin/{$action}_submit"); if(isset($id)) echo "&id=$id"; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

			<div class="col-lg-12">
				<h1><?php echo $form_title; ?></h1>

				<!--title-->
				<div class="form-group">
					<label for="title" class="col-lg-2 control-label">Title</label>
					<div class="col-lg-10">
						<input type="title" name="title" class="form-control" value="<?php echo $title; ?>" required/>
					</div>
				</div>
                                <br/>
				<!--Colors-->
				<div class="form-group">
					<label for="color1" class="col-lg-2 control-label">Colors</label>
					<div class="col-lg-2">
                                            <input type="color" name="color1" class="form-control" value="<?php echo $color1; ?>" maxlength="6"/>
                                            <input type="color" name="color2" class="form-control" value="<?php echo $color2; ?>" maxlength="6"/>
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
											<img width="100" class="admin-product-image" alt="Image not available" src="<?php echo framework::resolve("static/images/cards/".$$imagename); ?>"><br/>
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

				<!--Ocassion-->
				<div class="form-group">
					<label for="occasion" class="col-lg-2 control-label">Occasion</label>
					<div class="col-lg-10">
						<select id="category" name="occasion" class="form-control" >
							<?php foreach($occasions as $o){ ?>
								<option value="<?php echo $o['ID']; ?>" <?php if ($occasion == $o['ID']) echo "selected"; ?>>
									<?php echo $o['NAME']; ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>

				<!--Default text-->
				<div class="form-group">
					<label for="text" class="col-lg-2 control-label">Default text</label>
					<div class="col-lg-10">
						<textarea id="text" class="form-control" rows="5" name="defaulttext"><?php echo $defaulttext; ?></textarea>
					</div>
				</div>

				<!--Stock-->
				<div class="form-group">
					<label for="stock" class="col-lg-2 control-label">Stock</label>
					<div class="col-lg-3">
						<input class="form-control" type="number" id="stock" name="stock" value="<?php echo $stock; ?>" required/>
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

				<!--buttons-->
				<div class="form-group text-center">
					<br/>
					<button rel="button" class="btn btn-primary btn-lg">Ok</button>
					<a href="<?php echo framework::link_to('admin/cards'); ?>" class="btn btn-default btn-lg">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>