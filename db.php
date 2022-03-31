<?php

session_start();
$con =	mysqli_connect("192.168.1.226","","");
//$con =	mysqli_connect("192.168.1.220","root","St@rG@te");
//$con =	mysqli_connect("localhost","root","");

@mysqli_select_db($con,"bi") or die( "Unable to select database");;




$svc =	mysqli_connect("192.168.1.226","","");


@mysqli_select_db($svc,"service") or die( "Unable to select database");




$call =	mysqli_connect("192.168.1.227","","");


@mysqli_select_db($call,"pedrollo") or die( "Unable to select database");



$oms =	mysqli_connect("192.168.1.226","","");


@mysqli_select_db($oms,"dealer_order") or die( "Unable to select database");


?>
