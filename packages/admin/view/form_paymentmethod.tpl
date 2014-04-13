<?php include framework::resolve("packages/admin/view/header.tpl"); ?>
<form action="router.php?page=<?php echo $_GET['page']; ?>" method="post">
	Short name:<br/>
	<input  type = "text" name="edtShortName"><br/>
	Description:<br/>
	<textarea name="edtDesc" rows="10"></textarea>
	<br/>
	<input type="submit" value="Ok" name="btnOk">
	<a href="router.php?page=paymentmethods" class="button">Cancel</a>
</form>
<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>