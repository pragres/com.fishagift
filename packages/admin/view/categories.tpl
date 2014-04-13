<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">

			<!--section: items table-->
			<h1>Categories</h1>

                         <div class="text-right">
                            <a href = "<?php echo framework::link_to("admin/categories"); ?>">All items</a> |
                            <?php $kk = 0; foreach($languages as $key => $langx): ?>
                                <?php if ($kk > 0) echo "|"; $kk++; ?>
                                <?php if ($i18n_lang_progress[$langx['CODE']]['PERCENT'] > 0): ?>
                                    <a href ="<?php echo framework::link_to("admin/categories")."&lang=".$langx['CODE'];?>"><?php echo $langx['NAME']; ?></a> (<?php echo $i18n_lang_progress[$langx['CODE']]['PERCENT']; ?>%)
                                <?php else: ?>
                                    <?php echo $langx['NAME']; ?> (0%)
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

			<table class="table table-striped table-hover">
				<thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Long name</th>
                                        <th></th>
                                    </tr>
				</thead>
				<tbody>
                                    <?php if (is_array($categories)) foreach($categories as $key => $cat): ?>
                                    <tr>
                                            <td class="text-center">
                                                <?php echo $cat['ID']; ?>
                                            </td>
                                            <td class="text-left">
                                                <?php echo $cat['NAMESHORT']; ?>
                                            </td>
                                            <td><?php echo $cat['NAMELONG']; ?></td>
                                            <td width="130">
                                                <a href="<?php echo framework::link_to('admin/edit_category'); ?>&id=<?php echo $cat['ID']; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                                                <a onclick = 'return confirm("Delete the category *<?php echo $cat['NAMESHORT']; ?>*?")' href="<?php echo framework::link_to("admin/del_category"); ?>&id=<?php echo  $cat['ID']; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                                            </td>
                                    </tr>
                                    <?php endforeach; ?>
				</tbody>
			</table>

			<div class="text-center">
				<br/>
				<a href="<?php echo framework::link_to('admin/add_category'); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span>New category</a>
			</div>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>