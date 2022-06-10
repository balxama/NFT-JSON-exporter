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


$db=getDB();

function curl_etherium($block){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.etherscan.io/api?module=block&action=getblockreward&blockno=$block&apikey=BDP5EE5FQZ3K6MRTIXW99PF8XGW41DC2N4");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    $result = curl_exec($ch);
    curl_close ($ch);
    return $result;   
}
function update_totable($id,$date){
    $db=getDB();
    $statemenet=$db->prepare("UPDATE info2 set date=:this_datedate where id=:id");
    $statemenet->bindValue(":id",$id,PDO::PARAM_INT);
    $statemenet->bindValue(":this_datedate",$date,PDO::PARAM_STR);
    $statemenet->execute();
}
$i=0;
$statement=$db->prepare("SELECT id,block_number from info2");
$statement->execute();
while($result=$statement->fetch()){
$item_id=$result["id"];
 $block_to_api=curl_etherium($result["block_number"]);
$item_decode=json_decode($block_to_api);
$block_to_date=date("Y-m-d H:i:s", $item_decode->result->timeStamp);
 // $block_to_date=date("Y-m-d H:i:s", $block_to_api);
update_totable($item_id,$block_to_date);
$i++;
if($i % 5 == 5){
   sleep(1);
}
}