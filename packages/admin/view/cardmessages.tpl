<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">

			<!--section: card messages table-->
			<h1>Card messages</h1>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
                                            <th>Message</th>
                                            <th>Language</th>
                                            <th>Occasion</th>
                                            <th></th>
					</tr>
				</thead>
				<tbody>
					<?php if (is_array($cardmessages)) foreach($cardmessages as $key => $cm): ?>
					<tr>
						<td class="text-left">
						<?php echo $cm['TEXT']; ?>
						</td>
						<td><?php echo $languages[$cm['LANGUAGE']]['NAME']; ?></td>
						<td><?php echo $occasions[$cm['OCCASION']]['NAME']; ?></td>
						<td width="130">
							<a href="<?php echo framework::link_to("admin/edit_cardmessage"); ?>&id=<?php echo $cm['ID']; ?>" class="btn btn-default btn-mini">Edit</a>
							<a onclick = 'return confirm("Are you sure?");' href="<?php echo framework::link_to("admin/del_cardmessage"); ?>&id=<?php echo  $cm['ID']; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-trash"></span>Delete</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="text-center">
				<br/>
				<a href="<?php echo framework::link_to('admin/add_cardmessage'); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> New card message</a>
			</div>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>