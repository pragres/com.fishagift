<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<?php if (!isset($action)) $action = "add_item"; ?>
<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
	<form action="<?php echo framework::link_to("admin/{$action}_submit"); if(isset($id)) echo "&id=$id"; if (!is_null($current_lang)) echo '&lang='.$current_lang; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
		<div class="col-lg-12">
			<h1><?php echo $form_title;?></h1>
			<?php if (isset($error)): ?>
				<div class = "btn-danger" style ="padding: 5px;"><?php echo $error; ?></div>
			<?php endif; ?>

                        <ul class="nav nav-tabs">
                            <?php foreach($languages as $key => $lang): ?>
                            <li <?php if ($lang['CODE'] == $current_lang || ("{$current_lang}"=='' && $key == 0)) echo 'class="active"'; ?>><a href="#texts_<?php echo $lang['CODE'];?>"  data-toggle="tab"><?php echo $lang['NAME']; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tab-content" style="padding: 20px 0px;">
                            <?php foreach($languages as $key => $lang): ?>
                                <div class = "tab-pane <?php if ($lang['CODE'] == $current_lang || ("{$current_lang}"=='' && $key == 0)) echo 'active';?>" id ="texts_<?php echo $lang['CODE']; ?>">
                                    <div class="form-group">
                                            <label for="nameshort" class="col-lg-2 control-label">Short name</label>
                                            <div class="col-lg-10">
                                                    <input id="nameshort" name="nameshort[<?php echo $lang['CODE'];?>]" type="text" class="form-control" placeholder="Short name" value="<?php echo $nameshort[$lang['CODE']]; ?>"/>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="namelong" class="col-lg-2 control-label">Long name</label>
                                            <div class="col-lg-10">
                                                    <input id="namelong" name="namelong[<?php echo $lang['CODE'];?>]" type="text" class="form-control" placeholder="Long name" value="<?php echo $namelong[$lang['CODE']]; ?>"/>
						</div>
                                    </div>
                                    <div class="form-group">
                                            <label for="description" class="col-lg-2 control-label">Description</label>
                                            <div class="col-lg-10">
                                                    <textarea rows="10" id="description" name="description[<?php echo $lang['CODE'];?>]" style="width:100%;"><?php echo $description[$lang['CODE']]; ?></textarea><br/>
                                            </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>


			<div class="form-group">
				<label for="price" class="col-lg-2 control-label">Price</label>
				<div class="col-lg-10">
					<input id="price" name="price" type="number" min="0" step="any" class="form-control" placeholder="Price" value="<?php echo $price; ?>" required/>
				</div>
			</div>

			<div class="form-group">
				<label for="stock" class="col-lg-2 control-label">Stock</label>
				<div class="col-lg-10">
					<input id="stock" name="stock" type="number" class="form-control" placeholder="Stock" value="<?php echo $stock; ?>" required/>
				</div>
			</div>	
			
			<div class="form-group">
				<label for="category" class="col-lg-2 control-label">Category</label>
				<div class="col-lg-10">
					<select id="category" name="category" class="form-control">
						<?php foreach($categories as $cat) { ?>
						<option value="<?php echo $cat['ID'];?>" <?php if(intval($cat['ID']) === intval($category)) echo"selected"; ?>><?php echo $cat['NAMESHORT']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="status" class="col-lg-2 control-label">Status</label>
				<div class="col-lg-10">
					<select id="status" name="status" class="form-control">
						<option value="Active" <?php if (isset($status)) if ($status == "Active") echo "selected"; ?>>Active</option>
						<option value="Inactive" <?php if (isset($status)) if ($status == "Inactive") echo "selected"; ?>>Inactive</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label for="dimensions" class="col-lg-2 control-label">Dimensions</label>
				<div class="col-lg-2">
					<input id="dimensions" class="form-control" type="number" min="0" step="any" name="width" placeholder="Width" value="<?php echo $width; ?>" required/>
				</div>
				<div class="col-lg-2">
					<input class="form-control" type="number" min="0" step="any" name="height" placeholder="Height" value="<?php echo $height; ?>" required/>
				</div>
				<div class="col-lg-2">
					<input class="form-control" type="number" min="0" step="any" name="base" placeholder="Base" value="<?php echo $base; ?>" required/>
				</div>
				<div class="col-lg-2">
					<input class="form-control" type="number" min="0" step="any" name="weight" placeholder="Weight" value="<?php echo $weight; ?>" required/>
				</div>
			</div>

			<div class="form-group">
				<!--<h2>Images</h2> -->
				<label for="description" class="col-lg-2 control-label">Images</label>
				<div class="col-lg-10">
				<table>
					<tr>
						<?php for($i=1;$i<=5;$i++) { ?>
							<td valign="bottom">  
								<?php $imagename = 'image'.$i; ?>
								<?php if (isset($$imagename)) if ($$imagename !='') { ?>
									<img class="admin-product-image" alt="Image not available" src="<?php echo framework::resolve("static/images/items/".$$imagename); ?>"><br/>
									<select name="cboImage<?php echo $i; ?>">
										<option value="1">Keep this image</option>
										<option value="2">Remove this image</option>
										<option value="3">Change this image with:</option>
									</select><br/>
								<?php } ?>
								<input type="file" name="image<?php echo $i; ?>"><br/>
							</td>
							<?php if ($i%3 == 0): ?></tr><tr><?php endif; ?>
						<?php } ?>
                                                </tr>
				</table>
				</div>
			</div>
		</div>
		
		<div class="col-lg-12">
			<div class="form-group text-center">
				<br/>
				<button rel="button" class="btn btn-primary btn-lg">Ok</button>
				<a href="<?php echo framework::link_to('admin/items'); ?>" class="btn btn-default btn-lg">Cancel</a>
			</div>	
		</div>
	</form>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>
	
