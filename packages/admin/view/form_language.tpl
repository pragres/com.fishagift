<?php include framework::resolve("packages/admin/view/header.tpl"); ?>
<form action="router.php?page=<?php echo $_GET['page']; ?>" method="post">
	Code:<br/>
	<input type = "text" name="edtLanguageCode"><br/>
	Name:<br/>
	<input  type = "text" name="edtLanguageName">
	<br/>
	<input type="submit" value="Ok" name="btnOk">
	<a href="router.php?page=languages" class="button">Cancel</a>
</form>
<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>