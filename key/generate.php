<?php 
$k = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

file_put_contents("./fag.key", $k);