<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("store/home");

framework::session_unset("user");

framework::redirect("store/home");