<?php
session_start();
date_default_timezone_set('GMT');

$DATABASE_HOST = 'un0jueuv2mam78uv.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
$DATABASE_USER = 'otxdpkpzouo802ap';
$DATABASE_PASS = 'gbdu59597dg8mjvk';
$DATABASE_NAME = 'ktck9dx8kcq949u8';

try 
{
    $pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
} 
catch (PDOexception $exception) 
{
    exit('Failed to connect to database!');
}
?>