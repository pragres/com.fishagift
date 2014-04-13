<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title><?php echo $subject; ?></title>
	</head>
	<body style="font-family:Helvetica,Arial,sans-serif; text-align:justify; padding:0px;">
		<table border="0" width="600" style="margin:auto;" cellpadding="9" cellspacing="0">
			<!--logo-->
			<tr>
				<td bgcolor="#3C6DA5" width="50" style="padding-right:0px;">
					<img src="http://static.fishagift.com/graphs/logo.png" alt="logo" style="width:50px;"/>
				</td>
				<td bgcolor="#3C6DA5" style="padding-left:0px; padding-top:17px;">
					<div style="font-size:2em;">
						<b style="color:#f0ad4e;"><?php echo $i18n['logo-fish']; ?></b><i style="color:#5bc0de;"><?php echo $i18n['logo-a']; ?></i><b style="color:#5cb85c;"><?php echo $i18n['logo-gift']; ?></b>
					</div>
				</td>
			</tr>
			<!--header-->
			<tr>
				<td height="10" bgcolor="#478ECB" colspan="2">
					<font color="white"><b><?php echo $subject; ?></b></font>
				</td>
			</tr>
			<!--body-->
			<tr>
				<td colspan="2">
					<p><?php echo $body; ?></p>
					<br/><br/>
				</td>
			</tr>
			<!--waves image-->
			<tr>
				<td colspan="2" style="background:transparent url('http://static.fishagift.com/graphs/waves.png') repeat-x bottom center;"></td>
			</tr>
			<!--footer-->
			<tr>
				<td bgcolor="#050505" style="color:#aeaeae; text-align:center;" colspan="2">
					<small>Fish a Gift &copy; <?php echo date("Y"); ?> Pragres Corporation - All rights reserved <?php /*| <a style="color:#aeaeae;" href="#">Unsuscribe</a> */ ?></font></small>
				</td>
			</tr>
		</table>
	</body>
</html>
