<?php

$hostname = "eccoTTAdb.db.11794333.hostedresource.com";
$username = "eccoTTAdb";
$dbname   = "eccoTTAdb";
$password = "Osaka2477!!!!";

@mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
@mysql_select_db($dbname);
