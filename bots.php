<?php

session_start();
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
$people_json = file_get_contents('http://localhost/new/bots.js');
 
$decoded_json = json_decode($people_json);

function isnert_db($id,$amount,$count){
    $db=getDB();
    $statemenet=$db->prepare("INSERT INTO bots (number,amount,count) values (:number,:amount,:count)");
    $statemenet->bindValue(":number",$id,PDO::PARAM_STR);
    $statemenet->bindValue(":amount",$amount,PDO::PARAM_STR);
    $statemenet->bindValue(":count",$count,PDO::PARAM_STR);

    $statemenet->execute();
}

 foreach( $decoded_json as $key) {

   $id=$key->id;
   $amount=$key->profitUsdTotal;
   $sandwichesCount=$key->sandwichesCount;

isnert_db($id,$amount,$sandwichesCount); 

}