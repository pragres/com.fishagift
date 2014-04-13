<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<h1>List of ornaments</h1>
                        <div class="text-right">
                            <a href = "<?php echo framework::link_to("admin/ornaments"); ?>">All ornaments</a> |
                            <?php $kk = 0; foreach($languages as $key => $langx): ?>
                                <?php if ($kk > 0) echo "|"; $kk++; ?>
                                <?php if ($i18n_lang_progress[$langx['CODE']]['PERCENT'] > 0): ?>
                                    <a href ="<?php echo framework::link_to("admin/ornaments")."&lang=".$langx['CODE'];?>"><?php echo $langx['NAME']; ?></a> (<?php echo $i18n_lang_progress[$langx['CODE']]['PERCENT']; ?>%)
                                <?php else: ?>
                                    <?php echo $langx['NAME']; ?> (0%)
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
			<table class="table table-striped table-hover">
				<thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Ocassion</th>
                                        <th>Status</th>
                                        <th>Stock</th>
                                        <th></th>
                                    </tr>
				</thead>
				<tbody>
                                <?php if (is_array($ornaments)) foreach($ornaments as $key => $ornament): ?>
                                    <tr>
                                        <td class="text-left">
                                         <?php if ($ornament['IMAGE']!=''):?>
                                                <img width="32" height="32" src="<?php echo framework::resolve("static/images/ornaments/{$ornament['IMAGE']}"); ?>">
                                            <?php else: ?>
                                                <div style="width:32px;height:32px;float:left;">&nbsp;</div>
                                            <?php endif;?>    
                                        <?php echo $ornament['NAME']; ?>
                                        </td>
                                        <td><?php echo $ornament['OCCASIONNAME']; ?></td>
                                        <td><?php echo $ornament['STATUS']; ?></td>
                                        <td><?php echo $ornament['STOCK']; ?></td>
                                        <td width="130">
                                            <a href="<?php echo framework::link_to('admin/edit_ornament'); ?>&id=<?php echo $ornament['ID']; ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-edit"></span>Edit</a>
                                            <a onclick = 'return confirm("Delete the ornament *<?php echo $ornament['NAME']; ?>*?");' href="<?php echo framework::link_to("admin/del_ornament"); ?>&id=<?php echo  $ornament['ID']; ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
				</tbody>
			</table>

			<div class="text-center">
				<br/>
				<a href="<?php echo framework::link_to('admin/add_ornament'); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> New ornament</a>
			</div>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>