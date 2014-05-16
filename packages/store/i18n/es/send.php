<?php

// require other translation files
include_once framework::resolve('packages/base/i18n/es/forms.php');
include_once framework::resolve('packages/store/i18n/es/payment.php');

// page description
$i18n['title'] = 'Enviar regalo';

// from
$i18n['from-header'] = 'Desde (su direcci&oacute;n)';
$i18n['from-help'] = 'Escriba aqu&iacute; la direcci&oacute;n del remitente, la cual usar&aacute; el correo en caso para devolver el paquete en caso de no encontrar la direcci&oacute;n de destino. Usualmente es su direcci&oacute;n. Para regalos an&oacute;nimos puede dejar este formulario en blanco o parcialmente escrito. Si usted insert&oacute; su direcci&oacute;n en su perfil, esta secci&oacute;n se llenar&aacute; autom&aacute;ticamente la pr&oacute;xima vez. Lo sentimos pero por ahora solo poder enviar dentro de los Estados Unidos.';

// to
$i18n['to-header'] = 'Para (direcci&oacute;n de destino)';
$i18n['to-help'] = 'Escriba el nombre completo y la direcci&oacute;n de la persona que recibir&aacute; su regalo. Esta es la informaci&oacute;n m&aacute;s importante en esta secci&oacute;n, por favor tenga doble cuidado. Inserte la direcci&oacute;n completa, incluyendo el zipcode de manera que el cartero podr&iacute;a entenderla. Nosotros imprimimos el nombre y la direcci&oacute;n exacto como usted la escriba, asumiendo que no hay errores.';

// shipping method
$i18n['shipping-header'] = 'Forma de env&iacute;o';
$i18n['shipping-receivedate'] = 'Recibe sobre el';
$i18n['shipping-help'] = 'Seleccione la velocidad del env&iacute;o. Su selecci&oacute;n autom&aacute;ticamente modificar&aacute; el total a pagar en el desglose de pagos mostrado a continuaci&oacute;n. El precio del env&iacute;o es calculado basado en el tamaño y peso del art&iacute;culo, por lo cual puede cambiar dependiendo de su regalo.';

// shipping codes
$i18n['1D'] = 'Recibir el pr&oacute;ximo d&iacute;a';
$i18n['2D'] = 'De dos a tres d&iacute;as';

// breakdown
$i18n['payment-header'] = 'Desglose de pagos';

// credit card
$i18n['paymentmethod-header'] = 'M&eacute;todo de pago';
$i18n['paymentmethod-tab-creditcard'] = 'Tarjeta de cr&eacute;dito';
$i18n['paymentmethod-tab-paypal'] = 'PayPal';
$i18n['creditcard-help'] = 'El precio total ser&aacute; deducido del m&eacute;todo de pago seleccionado. Si usted insert&oacute; su tarjeta de cr&eacute;dito en su perfil, esta secci&oacute;n se llenar&aacute; autom&aacute;ticamente y usted no tendr&iacute;a que hacer nada m&aacute;s. Por defecto, las tarjeta de cr&eacute;dito son salvadas en su perfil. Usted puede escoger no salvar la tarjeta de cr&eacute;dito desmarcando el checkbox correspondiente. Por favor compruebe lo que escriba. Si hubiera alg&uacute;n error con su tarjeta de cr&eacute;dito, su orden ser&aacute; cancelada y le mandaremos un correo notific&aacute;ndole.';
$i18n['creditcard-saveprofile'] = 'Guarda esta tarjeta de cr&eacute;dito en mi perfil';
$i18n['paypal-help'] = 'PayPal guarda la informaci&oacute;n su tarjeta de cr&eacute;dito. Cuando usted compra en Internet PayPal le cobra el monto y paga a la tienda, de manera que su informaci&oacute;n privada nunca es mostrada. PayPal es seguro, conveniente y m&aacute;s r&aacute;pido de usar que escribir los datos de su tarjeta de cr&eacute;dito en un formulario. Ya tiene una cuenta en PayPal?';

// buttons
$i18n['btn-placeorder'] = 'Pagar';
$i18n['btn-placeorder-msg1'] = 'Se le descontar&aacute;';
$i18n['btn-placeorder-msg2'] = 'de su tarjeta de cr&eacute;dito';

$i18n['address-state'] = 'Estado';
$i18n['address-zipcode'] = 'C&oacute;digo postal';
$i18n['address-city'] = 'Ciudad';
$i18n['cc-yyyy'] = 'AAAA';
