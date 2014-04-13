<?php
// remove the user information from the sessionframework::session_unset('user');// remove the shopping cart from the sessionframework::session_unset('shopping_cart');
// remove temporal session structures
framework::session_unset('order_address_to');
framework::session_unset('paypal_execute_url');
framework::session_unset('paypal_authorization');

// redirect to the login pageheader("Location: " . framework::link_to('store/home'));