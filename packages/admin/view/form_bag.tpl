<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<form class="form-horizontal" role="form" action="<?php echo framework::link_to("admin/{$action}_bag_submit"); if (isset($id)) echo '&id='.$id; if (!empty($current_lang)) echo '&lang='.$current_lang;?>" method="post" enctype="multipart/form-data">
			<div class="col-lg-12">
				<h1><?php echo $title; ?></h1>

				<!--name-->
				<ul class="nav nav-tabs">
				<?php foreach($languages as $key => $langx): ?>
				    <li <?php if ($langx['CODE'] == $current_lang || ("{$current_lang}"=='' && $key == 0))  echo 'class="active"'; ?>><a href="#texts_<?php echo $langx['CODE'];?>"  data-toggle="tab"><?php echo $langx['NAME']; ?></a></li>
				<?php endforeach; ?>
				</ul>
					
				<div class="tab-content" style="padding: 20px 0px;">
				<?php foreach($languages as $key => $langx) { ?>
			    	<div class = "tab-pane <?php if ($langx['CODE'] == $current_lang || ("{$current_lang}"=='' && $key == 0)) echo 'active';?>" id ="texts_<?php echo $langx['CODE']; ?>">
                           	<div class="form-group">
                               	<label for="name" class="col-lg-2 control-label">Name</label>
								<div class="col-lg-10">
									<input type="text" name="name[<?php echo $langx['CODE']; ?>]" class="form-control" value="<?php echo $name[$langx['CODE']]; ?>"/>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>

				<!--Colors-->
				<div class="form-group">
					<label for="color1" class="col-lg-2 control-label">Colors</label>
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

				<!--Stock-->
				<div class="form-group">
					<label for="stock" class="col-lg-2 control-label">Stock</label>
					<div class="col-lg-3">
						<input class="form-control" type="number" id="stock" name="stock" value="<?php echo $stock; ?>" required/>
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

				<!--Dimensions-->
				<div class="form-group">
					<label for="dimensions" class="col-lg-2 control-label">Dimensions</label>
					<div class="col-lg-2">
						<input id="dimensions" class="form-control" type="number" min="0" step="any" name="width" placeholder="Width" value="<?php echo $width; ?>" required/>
					</div>
					<div class="col-lg-2">
						<input class="form-control" type="number" min="0" step="any" name="height" placeholder="Height" value="<?php echo $height; ?>" required/>
					</div>
					<div class="col-lg-2">
						<input class="form-control" type = "number" min="0" step="any" name="base" placeholder="Base" value="<?php echo $base; ?>" required/>
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
											<img class="admin-product-image" alt="Image not available" src="<?php echo framework::resolve("static/images/bags/".$$imagename); ?>"><br/>
											<select name="cboImage<?php echo $i; ?>">
												<option value="1">Keep this image</option>
												<option value="2">Remove this image</option>
												<option value="3">Change this image with:</option>
											</select><br/>
										<?php } ?>
										<input type="file" name="image<?php echo $i; ?>"><br/>
									</td>
									<?php if ($i%3 == 0){ ?></tr><tr><?php } ?>
								<?php } ?>
							</tr>
						</table>
					</div>
				</div>

				<!--buttons-->
				<div class="form-group text-center">
					<br/>
					<button rel="button" class="btn btn-primary btn-lg">Ok</button>
					<a href="<?php echo framework::link_to('admin/bags'); ?>" class="btn btn-default btn-lg">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>