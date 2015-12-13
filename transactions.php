<?php

require_once "Table.php";

$db = new SQLite3("Expences.db");
if (!$db) exit("db creation failed!"); 

$account_id = $_GET["account_id"];

$tr_id_str = "transaction_id_to_delete";

$tr_id = $_GET[$tr_id_str];

if($tr_id != NULL)
  {
  $sql_str = 'DELETE FROM TRANSACTIONS WHERE ID=='.$tr_id;
  $db->query($sql_str);
  }

$appendix = "";
if($account_id != NULL)
  {
  $appendix = " WHERE ACC_ID_FROM==".$account_id.' OR ACC_ID_TO=='.$account_id;
  }

$result = $db->query('SELECT * FROM TRANSACTIONS_VIEW'.$appendix);

$table = new HTML_Table();

$row_num = 1;


while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
  $cnt = count($row);

  for($cols = 0; $cols < $cnt - 1; $cols++)
    {
	  $curr_cell = $row[$cols];
    
    if($cols == $cnt - 2)
      {
      $time = strtotime($curr_cell.' UTC');
      $curr_cell = date('Y-m-d H:i:s', $time);
      }
    
    $table->setCellContents($row_num, $cols, $curr_cell);
    }

  $curr_cell = '<a href="?'.$tr_id_str.'='.$row[0].'">X</a>';

  $table->setCellContents($row_num, $cols, $curr_cell);

    
  if($row_num % 2 == 0)
    $table->setRowAttributes($row_num, array('class' => 'alt'));    
  $row_num++;
  } 

$table->setHeaderContents(0, 0, 'N');
$table->setHeaderContents(0, 1, 'Счет1');
$table->setHeaderContents(0, 2, 'Валюта');
$table->setHeaderContents(0, 3, 'Счет2');
$table->setHeaderContents(0, 4, 'Валюта');
$table->setHeaderContents(0, 5, 'Сумма');
$table->setHeaderContents(0, 6, 'Описание');
$table->setHeaderContents(0, 7, 'Дата');

$hrAttrs = array('bgcolor' => 'silver');
$table->setRowAttributes(0, $hrAttrs, true);
$table->setColAttributes(0, $hrAttrs);

$table->display();
$db->close(); 
  
?> 
