<?php

// require other translation files
include_once framework::resolve('packages/base/i18n/en/forms.php');
include_once framework::resolve('packages/store/i18n/en/payment.php');

// page description
$i18n['title'] = 'Send gift';

// from
$i18n['from-header'] = 'from (your address)';
$i18n['from-help'] = 'This will be the sender address that the mail will use to return the package in case they cannot find the destination address, usually your home address. For anonymous gifts, you can just leave these fields in blank or partially filled. If you completed the address part in your profile, this section will be prepopulated and you won’t need to do anything else. Sorry, but only addresses among the United States are allowed.';

// to
$i18n['to-header'] = 'to (receiver\'s address)';
$i18n['to-help'] = 'Insert the name and address of the person who will receive the gift. This is the most important part of information on this section, please be extra careful. We will print the name and address exactly as is typed by you, assuming no misspellings. Please insert the full address, including zip code and add any other detail the mail may use to find the place easily.';

// shipping method
$i18n['shipping-header'] = 'shipping method';
$i18n['shipping-receivedate'] = 'Receive it by';
$i18n['shipping-help'] = 'Select from a shipping speed. Your selection will automatically update the payments breakdown shown below, modifying the total amount to pay. Shipping and Handling is calculated based on your present’s size and weight, so it may change depending of the item you selected.';

// shipping codes
$i18n['1D'] = 'Next day shipping';
$i18n['2D'] = 'Two to Three days';

// breakdown
$i18n['payment-header'] = 'payments breakdown';

// payment method
$i18n['paymentmethod-header'] = 'payment method';
$i18n['paymentmethod-tab-creditcard'] = 'Credit Card';
$i18n['paymentmethod-tab-paypal'] = 'PayPal';
$i18n['creditcard-help'] = 'The total price shown in the table above will be deducted from the payment method selected. If you inserted the credit card information in your profile, this section will be prepopulated and you won’t need to do anything else. By default credit cards are saved in the profile when an order is placed. You can prevent from saving your credit card by unchecking the proper checkbox. Please double check your input. If there is any problem charging your credit card, your order will be cancelled and we will send you a notification by email.';
$i18n['creditcard-saveprofile'] = 'Save this credit card in my profile';
$i18n['paypal-help'] = 'PayPal stores your credit card information and when you buy online, it deducts the money from the credit card and pay the store without disclosing your private data. Paypal is secure, convenient to use and faster than typing your credit card information in a form. Do you have an account already?';

// buttons
$i18n['btn-placeorder'] = 'Place Order';
$i18n['btn-placeorder-msg1'] = 'We will deduct';
$i18n['btn-placeorder-msg2'] = 'from your credit card';

$i18n['address-state'] = 'State';
$i18n['address-zipcode'] = 'Zip Code';
$i18n['address-city'] = 'City';
$i18n['cc-yyyy'] = 'YYYY';
