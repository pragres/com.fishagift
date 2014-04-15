<?php
	// require other translation files
	include_once framework::resolve('packages/base/i18n/en/forms.php');
	include_once framework::resolve('packages/store/i18n/en/payment.php');

	// page description
	$i18n['title'] = 'Gifts fished';

	// items fished
	$i18n['fished-header'] = 'List of fished gifts';
	$i18n['fished-help'] = 'Below a list of the gifts you had fished with us. Is sorted from more recent to the oldest. Click the item\'s name for details, and click in the tracking number to check your gift\'s location while is still been delivered. If you need to contact us regarding any issue with a gift, please take note of the confirmation number first.';
	$i18n['fished-date'] = 'Date';
	$i18n['fished-item'] = 'Item';
	$i18n['fished-confirmation'] = 'Confirmation number';
	$i18n['fished-price'] = 'Amount';
	$i18n['fished-tracking'] = 'Tracking number';	

	// gift content
	$i18n['fished-inside'] = 'Your gift inside';
?>