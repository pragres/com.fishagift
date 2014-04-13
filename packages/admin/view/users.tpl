<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">
		<div class="col-lg-12">
			<h1>List of users</h1>
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="text-center">Registered</th>
						<th class="text-center">Email</th>
						<th class="text-center">Full name</th>
						<th class="text-center">Language</th>
						<th class="text-center">Administrator/User</th>
						<th class="text-center"></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($users as $key => $u): ?>
						<tr>
							<td><?php echo date("m/d/Y h:i:s A", strtotime($u['DATEREGISTERED'])); ?></td>
							<td><?php echo $u['EMAIL']; ?></td>
							<td><?php echo $u['FULLNAME']; ?></td>
							<td><?php echo $u['LANGUAGE']; ?></td>
							<td>
							<?php if ($user['EMAIL'] != $u['EMAIL']) { ?>
								<?php if ($u['ADMINISTRATOR'] * 1 === 0) { ?>
									<a href="<?php echo framework::link_to('admin/set_as_admin'); ?>&email=<?php echo $u['EMAIL']; ?>" class="btn btn-default btn-mini btn-success">Promote to admin</a>
								<?php }else{ ?>
									<a href="<?php echo framework::link_to('admin/set_as_user'); ?>&email=<?php echo $u['EMAIL']; ?>" class="btn btn-default btn-mini btn-danger">Degrade to user</a>
								<?php } ?>
							<?php } ?>
							</td>
                                                        <td><a href="<?php echo framework::link_to('admin/edit_user'); ?>&email=<?php echo $u['EMAIL']; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
							<td>
								<?php if ($user['EMAIL'] != $u['EMAIL']) { ?>
									<form name = "delete<?php echo $key; ?>" action="<?php echo framework::link_to("admin/del_user"); ?>&email=<?php echo  $u['EMAIL']; ?>" method="post"> 
										<a onclick = 'if (confirm("Are you sure?")) document.delete<?php echo $key; ?>.submit();' class="btn btn-default btn-mini"><span class="glyphicon glyphicon-trash"></span>Delete</a>
									</form>
								<?php } ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="text-center">
				<br/>
				<a href="<?php echo framework::link_to('admin/add_user'); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-user"></span> New user</a>
			</div>
		</div>
	</div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>