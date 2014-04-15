<?php
// require other translation files
include_once framework::resolve('packages/base/i18n/en/forms.php');
include_once framework::resolve('packages/store/i18n/en/payment.php');

// page description
$i18n['title'] = 'Your receipt';

// receipt
$i18n['receipt-header'] = 'Thanks for your purchase';
$i18n['receipt-help1'] = 'Here is your receipt and further information about your purchase. A copy of this receipt was sent to your by email. Your confirmation number is';
$i18n['receipt-help2'] = 'You will need this number if you need to contact us regarding your order. You can also find this number in the receipt we emailed you, as well as in your list of fished gifts. We will process your order right away; soon you will receive the tracking number in your email.';

// address
$i18n['receipt-addressfrom-header'] = 'Your address';
$i18n['receipt-addressto-header'] = 'Who will receive it';

// payment
$i18n['receipt-details-header'] = 'More details';
$i18n['receipt-details-payby'] = 'Paid by';
$i18n['receipt-details-sendby'] = 'Sent by';
$i18n['receipt-details-receiveby'] = 'will receive your gift by';

// breakdown
$i18n['receipt-breakdown-header'] = 'Your order';

