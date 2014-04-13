<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">

			<!--section: items table-->
			<h1>List of post cards</h1>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Title</th>
						<th>Language</th>
						<th>Ocassion</th>
						<th>Status</th>
						<th>Stock</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
                                        <?php if (is_array($cards)) foreach($cards as $key => $card): ?>
					<tr>
						<td class="text-left">
                                                    <?php for($i=1; $i<=3; $i++): ?>
                                                        <?php if ($card['IMAGE'.$i]!=''):?>
                                                            <img width="32" height="32" src="<?php echo framework::resolve("static/images/cards/{$card['IMAGE'.$i]}"); ?>" alt="">
                                                            <?php break; ?>
                                                        <?php else: ?>
                                                            <?php if ($i<3) continue; ?>
                                                            <div style="width:32px;height:32px;float:left;">&nbsp;</div>
                                                        <?php endif;?>
                                                    <?php endfor; ?>
                                                    <?php echo $card['TITLE']; ?>
                                                </td>
						<td><?php echo $card['LANGUAGENAME']; ?></td>
						<td><?php echo $card['OCCASIONNAME']; ?></td>
						<td><?php echo $card['STATUS']; ?></td>
						<td><?php echo $card['STOCK']; ?></td>
                                                <td width="130">
                                                    <a href="<?php echo framework::link_to('admin/edit_card'); ?>&id=<?php echo $card['ID']; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                                                    <a onclick = 'return confirm("Delete the card *<?php echo $card['TITLE']; ?>*?");' href="<?php echo framework::link_to("admin/del_card"); ?>&id=<?php echo  $card['ID']; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                                                </td>
					</tr>
                                        <?php endforeach; ?>
				</tbody>
			</table>

			<div class="text-center">
				<br/>
				<a href="<?php echo framework::link_to('admin/add_card'); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> New card</a>
			</div>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>