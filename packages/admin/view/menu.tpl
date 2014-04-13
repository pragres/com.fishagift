<!--including special styles for the admin-->
<link rel="stylesheet" href="<?php echo framework::resolve('static/css/admin.css'); ?>"/>

<!--section: menu-->
<div id="menu" class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<!--logo-->
		<a class="navbar-brand" href="#">
			<img src="<?php echo framework::resolve('static/graphs/logo.png'); ?>" alt="logo" style="width:22px;"/>
			<b class="number-one-color">Fish</b><i class="number-two-color">A</i><b class="number-three-color">Gift</b>
		</a>

		<!--links-->
		<ul class="nav navbar-nav">
			<li><a href="<?php echo framework::link_to("admin/dashboard");?>">Dashboard</a></li>
			<li><a href="<?php echo framework::link_to("admin/users");?>">Users</a></li>
			<li><a href="<?php echo framework::link_to("admin/orders");?>">Orders</a></li>
		</ul>

		<!--exit and logout-->
		<ul class="nav navbar-nav navbar-right pull-right">
			<li><a href="<?php echo framework::link_to('store/home'); ?>"><span class="glyphicon glyphicon-arrow-left"></span> Exit admin</a></li>
			<li><a href="<?php echo framework::link_to('base/logout_submit'); ?>"><span class="glyphicon glyphicon-remove-circle"></span> Logout</a></li>
		</ul>
	</div>
</div>