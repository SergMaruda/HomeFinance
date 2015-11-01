<?php

require_once "Table.php";

$db = new SQLite3("Expences.db");
if (!$db) exit("db creation failed!"); 

$account_id = $_GET["account_id"];

$appendix = "";
if($account_id != NULL)
{
$appendix = " WHERE ACC_ID==".$account_id;
}

$result = $db->query('SELECT * FROM TRANSACTIONS_VIEW'.$appendix);

$table = new HTML_Table();

$row_num = 1;

while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
  $cnt = count($row);

  for($cols = 0; $cols < $cnt - 1; $cols++)
    {
	  $curr_row = $row[$cols];
    
    if($cols == $cnt - 2)
      {
      $time = strtotime($curr_row.' UTC');
      $curr_row = date('Y-m-d H:i:s', $time);
      }
    
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
