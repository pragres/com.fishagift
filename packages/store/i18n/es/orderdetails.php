<?php
// require other translation files
include_once framework::resolve('packages/base/i18n/es/forms.php');
include_once framework::resolve('packages/store/i18n/es/payment.php');

// page description
$i18n['title'] = 'Su orden';

// receipt
$i18n['receipt-header'] = 'Detalles de su compra';
$i18n['receipt-help1'] = 'Este es su recibo con informaci&oacute;n adicional sobre su compra. Una copia de este recibo le fue enviada por correo electr&oacute;nico. Su n&uacute;mero de confirmaci&oacute;n es';
$i18n['receipt-help2'] = 'Usted va a necesitar este n&uacute;mero si tiene que contactarnos con respecto a su compra. Tambi&eacute;n puede encontrar este n&uacute;mero en el correo electr&oacute;nico que le enviamos o en la <a href="'.framework::link_to("store/fished").'">lista de regalos pescados</a>.';

// address
$i18n['receipt-addressfrom-header'] = 'Su direcci&oacute;n';
$i18n['receipt-addressto-header'] = 'Enviado a';

// payment
$i18n['receipt-details-header'] = 'M&aacute;s detalles';
$i18n['receipt-details-payby'] = 'Pagado usando';
$i18n['receipt-details-sendby'] = 'Enviado usando';
$i18n['receipt-details-receiveby'] = 'recibir&aacute; su regalo el';

// breakdown
$i18n['receipt-breakdown-header'] = 'Su orden';


$i18n['back'] = 'Atr&aacute;s';