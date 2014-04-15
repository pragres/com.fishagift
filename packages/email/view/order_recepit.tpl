<p><b><?php echo $i18n['thanks']; ?></b></p> 
<p><?php echo $i18n['service1']; ?> <b><?php echo $order['CONFIRMATIONNUMBER']; ?></b> <?php echo $i18n['service2']; ?></p>
<br/>

<table width="100%" cellspacing="0" cellpadding="5" style="width:100%">
	<tr bgcolor="#F8F8F8">
		<td width="45"><img width="40" height="40" style="width:40px; height:40px;" src="http://static.fishagift.com/images/items/<?php echo $order['PRODUCT']['ITEMIMAGE']; ?>" alt="item"/></td>
		<td valign="middle" ><b><?php echo $order['PRODUCT']['ITEMNAMELONG']; ?></b></td>
		<td align="right">$<?php echo number_format($order['PRODUCT']['ITEMPRICE'],2); ?></td>
	</tr>
    <tr>
    	<td width="45"><img width="40" height="40" style="width:40px; height:40px;" src="http://static.fishagift.com/images/papers/<?php echo $order['PRODUCT']['PAPERIMAGE']; ?>" alt="item"/></td>
		<td valign="middle"><?php echo $order['PRODUCT']['PAPERNAME']; ?></td>
		<td align="right">$<?php echo number_format($order['PRODUCT']['PAPERPRICE'],2); ?></td>
	</tr>
 	<tr bgcolor="#F8F8F8">
    	<td colspan="2"><?php echo $i18n['shipping']; ?></td>
		<td align="right">$<?php echo number_format($order['PRODUCT']['SHIPPINGPRICE'],2); ?></td>
	</tr>
	<tr>
    	<td colspan="2"><?php echo $i18n['tax']; ?></td>
		<td align="right">$<?php echo number_format($order['PRODUCT']['TAX'],2); ?></td>
	</tr>
    <tr bgcolor="#F8F8F8">
    	<td colspan="2"><b><?php echo $i18n['total']; ?></b></td>
		<td align="right"><b>$<?php echo number_format($total,2);?></b></td>
	</tr>
</table>

<br/><br/>

<center>
	<p style="color:#3C6DA5;"><?php echo $i18n['thanks-again']; ?><br/><b> :-)</b></p>
</center>
