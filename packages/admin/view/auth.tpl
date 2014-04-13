<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>
<div id="section-body" class="container" style="padding-right: 20px;">
	<div class="row">

<?php if (isset($error)): ?>
<div class = "label-important" style = "padding: 5px; color: white;">
Access denied
</div>
<br/>
<?php endif; ?>
<form method="post" action="router.php?page=home">
	User:<br/><input type="text" name="edtUser"><br/>
	Password:<br/><input type="password" name="edtPass"><br/><br/>
	<input type="submit" name="btnLogin" value="Login">
</form>
</div>
</div>
<?php include framework::resolve("packages/admin/view/footer.tpl"); ?>
