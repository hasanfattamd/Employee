<?php
$mysqli = new mysqli('localhost', 'root', 'mysql', 'empdb');
if($mysqli->connect_errno){
    //MySQLi connection error if fails to connect
    error_log('Can\'t connect' . $mysqli->connect_errno);
}
