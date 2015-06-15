<?php
header('Content-Type: application/json');
$db = new SQLite3("Expences.db");
if (!$db) exit("db creation failed!"); 

$result = $db->query('SELECT * FROM TRANSACTIONS_VIEW');
$array = array();
while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
  $array[] = $row;
  } 
  
echo json_encode($array);
$db->close(); 
?>
