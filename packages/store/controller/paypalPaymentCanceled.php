<?php

// unset session variables if the user cancel the payment
framework::session_unset('paypal_execute_url');
framework::session_unset('paypal_authorization');

// back to the send page
header("Location: " . framework::link_to('store/send'));
