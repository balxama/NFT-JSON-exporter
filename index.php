<?php


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'new_data');
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
$people_json = file_get_contents('http://localhost/new/s/s2.json');


$decoded_json = json_decode($people_json, false, JSON_PRETTY_PRINT);

foreach( $decoded_json as $keys=>$key) {
    $amount=$key->profitAmountUsd;
    $block_number=$key->blockNumber;
    $date_this=date("Y-m-d H:i:s");
    
    foreach( $key->swaps as $keys2=>$key2) {
        
        $id=$key2->transactionHash;
        $protocol=$key2->protocol;
      
      
       
     }
     if($amount>=7 && $amount <=15){
        isnert_db($id,$amount,$date_this,$protocol,$block_number);
     }


   }

function isnert_db($id,$amount,$date,$protocol,$block_number){
    $db=getDB();
    $statemenet=$db->prepare("INSERT INTO info2 (number,amount,protocol,date,block_number) values (:number,:amount,:protocol,:date,:block_number)");
    $statemenet->bindValue(":number",$id,PDO::PARAM_STR);
    $statemenet->bindValue(":amount",$amount,PDO::PARAM_STR);
    $statemenet->bindValue(":protocol",$protocol,PDO::PARAM_STR);
    $statemenet->bindValue(":block_number",$block_number,PDO::PARAM_STR);
    $statemenet->bindValue(":date",$date,PDO::PARAM_STR);
    $statemenet->execute();
}

