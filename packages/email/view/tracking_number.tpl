<p><?php echo $i18n['tracking-dear']; ?> <?php echo $sender; ?>,</p>
<p>
	<?php echo $i18n['tracking-msg1'];?> <?php echo $receiver; ?> <?php echo $i18n['tracking-msg2'];?> 
	<a target="_blank" href="https://tools.usps.com/go/TrackConfirmAction.action?tLabels=<?php echo $trackingNumber; ?>"><?php echo $trackingNumber; ?></a> 
	<?php echo $i18n['tracking-msg3'];?>
</p>