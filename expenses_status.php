<script type="text/javascript">
    $(document).ready(function () {
        console.log("sss");

        $('a').click(function () {
            console.log("sdsdsdsd");

            if ($(this).text() == "X") {
                if (confirm('Are you sure you want to delete account?')) {
                    return true;
                } else {
                    return false;
                }
            }
            return true;
        });

    });

</script>


<?php
require_once "Table.php";

include('auth.php');

$db = new SQLite3("Expences.db");
if (!$db) 
  exit("db creation failed!"); 

$account = $_GET['account'];
$currency = $_GET['currency'];
$delete_account = $_GET['delete_account'];

if($delete_account != NULL)
{
  $delete = 'DELETE FROM ACCOUNTS WHERE ID=='.$delete_account;
  $result = $db->query($delete);
}

if($account != NULL && $currency != NULL)
  {
  $currency_id = array('usd'=> 0, 'eur'=> 1, 'uah'=> 2);
  echo $currency;
  echo $currency_id[$currency];
  $insert = 'INSERT INTO ACCOUNTS (CURRENCY_ID, NAME, TYPE) VALUES ('.$currency_id[$currency].', \''.$account.'\', \'O\')';
  $result = $db->query($insert);
  }

$result = $db->query('SELECT * FROM EXPENSES_STATE');

$table = new HTML_Table();
$table->SetCaption("Expenses state");

$row_num = 0;

while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
  $cnt = count($row);

  for($cols = 0; $cols < $cnt; $cols++)
    {
	  $curr_row = $row[$cols];
    $table->setCellContents($row_num, $cols, $curr_row);
    }

  $table->setCellContents($row_num, $cols, '<a href="expenses_status_table.php?delete_account='.$row[0].'">X</a>');
    
  if($row_num % 2 == 0)
    $table->setRowAttributes($row_num, array('class' => 'alt'));    
  $row_num++;
  } 

$table->display();
$db->close(); 
?> 

