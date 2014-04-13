<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<form  action="<?php echo framework::link_to("admin/{$action}_submit"); if(isset($id)) echo "&id=$id"; if (!empty($current_lang)) echo '&lang='.$current_lang;?>" method="post" enctype="multipart/form-data" class="form-horizontal">

			<div class="col-lg-12">
				<h1><?php echo $form_title;?></h1>

				<ul class="nav nav-tabs">
                                    <?php foreach($languages as $key => $langx): ?>
                                    <li <?php if ($langx['CODE'] == $current_lang || ("{$current_lang}"=='' && $key == 0))  echo 'class="active"'; ?>><a href="#texts_<?php echo $langx['CODE'];?>"  data-toggle="tab"><?php echo $langx['NAME']; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tab-content" style="padding: 20px 0px;">
                                    <?php foreach($languages as $key => $langx): ?>
                                        <div class = "tab-pane <?php if ($langx['CODE'] == $current_lang || ("{$current_lang}"=='' && $key == 0)) echo 'active';?>" id ="texts_<?php echo $langx['CODE']; ?>">
                                            <!--name-->
                                            <div class="form-group">
                                                    <label for="name" class="col-lg-2 control-label">Name</label>
                                                    <div class="col-lg-10">
                                                            <input type="name" name="name[<?php echo $langx['CODE']?>]" class="form-control" value="<?php echo $name[$langx['CODE']]; ?>"/>
                                                    </div>
                                            </div>

                                            <div class="form-group">
                                                    <label for="description" class="col-lg-2 control-label">Description</label>
                                                    <div class="col-lg-10">
                                                        <textarea rows="10" id="description" name="description[<?php echo $langx['CODE']?>]" style="width:100%;"><?php echo $description[$langx['CODE']]; ?></textarea><br/>
                                                    </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>

				<div class="form-group">
				<label for="description" class="col-lg-2 control-label">Image</label>
				<div class="col-lg-10">
                                        <table border="0">
                                                <tr>
                                                        <?php for($i=1;$i<=1;$i++) { ?>
                                                                <td valign="bottom">
                                                                        <?php $imagename = 'image'.$i; ?>
                                                                        <?php if (isset($$imagename)) if ($$imagename !='') { ?>
                                                                                <img class="admin-product-image" alt="Image not available" width="100" src="<?php echo framework::resolve("static/images/ornaments/".$$imagename); ?>"><br/>
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

				<!--buttons-->
				<div class="form-group text-center">
					<br/>
					<button rel="button" class="btn btn-primary btn-lg">Ok</button>
					<a href="<?php echo framework::link_to('admin/ornaments'); ?>" class="btn btn-default btn-lg">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>