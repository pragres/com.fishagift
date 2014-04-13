<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<form class="form-horizontal" role="form" action="<?php echo framework::link_to("admin/{$action}_submit"); if(isset($id)) echo "&id=$id"; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

			<div class="col-lg-12">
				<h1><?php echo $form_title; ?></h1>

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

				
				<!--buttons-->
				<div class="form-group text-center">
					<br/>
					<button rel="button" class="btn btn-primary btn-lg">Ok</button>
					<a href="<?php echo framework::link_to('admin/categories'); ?>" class="btn btn-default btn-lg">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>
