<?php 
require 'OneNetApi.php';
$apikey = 'JqYd8omIgFqNWCIHwKDXtCUwSZ4=';
$apiurl = 'http://api.heclouds.com';
$device_id = 518696301;
//创建api对象
$sm = new OneNetApi($apikey, $apiurl);
$device = $sm->device_delete($device_id);
var_dump($device);
 ?>