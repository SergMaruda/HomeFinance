<?php
$db = new SQLite3("Expences.db");
if (!$db) 
  exit("db creation failed!"); 

$account = $_GET['type'];

if($account != NULL)
{
  $delete = 'SELECT * FROM ACCOUNTS WHERE TYPE=='.$account;
  $result = $db->query($delete);
}

$result_array = array();

while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
  $result_array[] = $row;
  } 
 
echo json_encode($result_array);  
?> 

