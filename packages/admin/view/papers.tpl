<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<h1>List of papers</h1>
                        <div class="text-right">
                            <a href="<?php echo framework::link_to("admin/papers");?>">All papers</a> |
                            <?php $kk = 0; foreach($languages as $key => $langx): ?>
                                <?php if ($key > 0) echo "|"; $kk++;?>
                                <?php if ($i18n_lang_progress[$langx['CODE']]['PERCENT'] > 0): ?>
                                        <a href ="<?php echo framework::link_to("admin/papers")."&lang=".$langx['CODE'];?>"><?php echo $langx['NAME']; ?></a> (<?php echo $i18n_lang_progress[$langx['CODE']]['PERCENT']; ?>%)
                                <?php else: ?>
                                        <?php echo $langx['NAME']; ?> (0%)
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
			<table class="table table-striped table-hover">
				<thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Occasion</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
				</thead>
				<tbody>
					<?php if (is_array($papers)) foreach($papers as $key => $paper): ?>
					<tr>
						<td class="text-left">
                                                    <?php if ($paper['IMAGE']!=''):?>
                                                        <img width="32" height="32" src="<?php echo framework::resolve("static/images/papers/{$paper['IMAGE']}"); ?>" alt="">
                                                    <?php else: ?>
                                                        <div style="width:32px;height:32px;float:left;">&nbsp;</div>
                                                    <?php endif;?>
                                                <?php echo $paper['NAME'];?>
                                                </td>
						<td><?php echo $paper['OCCASIONNAME']; ?></td>
						<td><?php echo $paper['STATUS']; ?></td>
						<td width="130">
                                                    <a href="<?php echo framework::link_to('admin/edit_paper'); ?>&id=<?php echo $paper['ID']; ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                                                    <a onclick = 'return confirm("Delete the item *<?php echo $paper['NAME']; ?>*?")' href="<?php echo framework::link_to("admin/del_paper"); ?>&id=<?php echo  $paper['ID']; ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                                                </td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="text-center">
				<br/>
				<a href="<?php echo framework::link_to('admin/add_paper'); ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> New paper</a>
			</div>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>