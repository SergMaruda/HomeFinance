<?php
require_once "Table.php";

include('auth.php');

$db = new SQLite3("Expences.db");
if (!$db) exit("db creation failed!"); 

$result = $db->query('SELECT * FROM STATE_BY_CURRENCIES');

$table = new HTML_Table();

$table->SetCaption("Accounts state by currency");

$row_num = 0;

while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
  $cnt = count($row);

  for($cols = 0; $cols < $cnt; $cols++)
    {
	$curr_row = $row[$cols];
    $table->setCellContents($row_num, $cols, $curr_row);
    }
    
  if($row_num % 2 == 0)
    $table->setRowAttributes($row_num, array('class' => 'alt'));    
  $row_num++;
  } 

$table->display();
$db->close(); 
?> 

