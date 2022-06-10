<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'data');
function getDB() 
{
$dbhost=DB_SERVER;
$dbuser=DB_USERNAME;
$dbpass=DB_PASSWORD;
$dbname=DB_DATABASE;
try {
$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
$dbConnection->exec("set names utf8");
$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $dbConnection;
}
catch (PDOException $e) {
echo 'Connection failed #: ' . $e->getMessage();
}
}
ini_set('max_execution_time', 0);
set_time_limit(0);
$db=getDB();
$array=array();
$statement=$db->prepare("SELECT * from info ORDER BY amount DESC");
$statement->execute();
$result=$statement->fetchAll(PDO::FETCH_NAMED);

//$result["amount"];
echo "<pre>";
print_r($result);

echo "</pre>";