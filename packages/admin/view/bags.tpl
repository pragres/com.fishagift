<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<h1>List of paper bags</h1>
                        <div class="text-right">
                            <a href="<?php echo framework::link_to("admin/bags");?>">All bags</a> |
                            <?php $kk = 0; foreach($languages as $key => $langx): ?>
                                <?php if ($key > 0) echo "|"; $kk++;?>
                                <?php if ($i18n_lang_progress[$langx['CODE']]['PERCENT'] > 0): ?>
                                        <a href ="<?php echo framework::link_to("admin/bags")."&lang=".$langx['CODE'];?>"><?php echo $langx['NAME']; ?></a> (<?php echo $i18n_lang_progress[$langx['CODE']]['PERCENT']; ?>%)
                                <?php else: ?>
                                        <?php echo $langx['NAME']; ?> (0%)
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th title="Width, Height, Base">Size</th>
						<th>Occasion</th>
						<th>Status</th>
						<th>Stock</th>
						<th width="130"></th>
					</tr>
				</thead>
				<tbody>
					<?php if (is_array($bags)) foreach($bags as $key => $bag): ?>
					<tr>
						<td class="text-left">
                                                <?php for($i=1; $i<=3; $i++): ?>
                                                    <?php if ($bag['IMAGE'.$i]!=''):?>
                                                        <img width="32" height="32" src="<?php echo framework::resolve("static/images/bags/{$bag['IMAGE'.$i]}"); ?>" alt="">
                                                        <?php break; ?>
                                                    <?php else: ?>
                                                        <?php if ($i<3) continue; ?>
                                                        <div style="width:32px;height:32px;float:left;">&nbsp;</div>
                                                    <?php endif;?>
                                                <?php endfor; ?>
                                                <?php echo $bag['NAME'];?>
                                                </td>
						<td title="Width, Height, Base"><?php echo $bag['WIDTH']."x".$bag['HEIGHT']."x".$bag['BASE']; ?></td>
						<td><?php echo $bag['OCCASION']; ?></td>
						<td><?php echo $bag['STATUS']; ?></td>
						<td><?php echo $bag['STOCK']; ?></td>
						<td>
                                                    <a href="<?php echo framework::link_to('admin/edit_bag'); ?>&id=<?php echo $bag['ID']; ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                                                    <a href="<?php echo framework::link_to("admin/del_bag"); ?>&id=<?php echo  $bag['ID']; ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" onclick = 'return confirm("Delete the item *<?php echo $bag['NAME']; ?>*?");' class="btn btn-default btn-mini"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                                                </td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="text-center">
				<br/>
				<a href="<?php echo framework::link_to('admin/add_bag'); ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> New bag</a>
			</div>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>