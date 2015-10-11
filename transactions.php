<?php

require_once "Table.php";
 
$db = new SQLite3("Expences.db");
if (!$db) exit("db creation failed!"); 

$result = $db->query('SELECT * FROM TRANSACTIONS_VIEW');

$table = new HTML_Table();

$row_num = 1;

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

$table->setHeaderContents(0, 0, 'N');
$table->setHeaderContents(0, 1, 'Счет');
$table->setHeaderContents(0, 2, 'Сумма');
$table->setHeaderContents(0, 3, 'Валюта');
$table->setHeaderContents(0, 4, 'Описание');
$table->setHeaderContents(0, 5, 'Дата');

$hrAttrs = array('bgcolor' => 'silver');
$table->setRowAttributes(0, $hrAttrs, true);
$table->setColAttributes(0, $hrAttrs);

$table->display();
$db->close(); 
  
?> 
