<?php

include_once framework::resolve('packages/base/model/Security.php');

if (!Security::isSessionStartedByAdmin())
    framework::redirect("admin/home");

Security::delUser($_GET['email']);

framework::redirect("admin/users");