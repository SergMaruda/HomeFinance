<?php

include 'header.php';


$db = new SQLite3("Expences.db");
if (!$db) exit("db creation failed!");


function GetAccountsByType($db, $type)
  {
  $result = $db->query('SELECT ACCOUNTS.NAME, CURRENCIES.NAME, ACCOUNTS.ID FROM ACCOUNTS, CURRENCIES WHERE ACCOUNTS.CURRENCY_ID == CURRENCIES.ID AND TYPE==\''.$type.'\'');
            
  $result_array = array();
  while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
    $result_array[] = $row;
  }
            
  $str = json_encode($result_array);
  return $str;
  }

?>

<script type="text/javascript">

//-------------------------------------------------------------------------------

var transfer_accounts_str = <?php echo '\''.GetAccountsByType($db, 'B').'\''; ?>;
var income_accounts_str =   <?php echo '\''.GetAccountsByType($db, 'I').'\''; ?>;
var outcome_accounts_str =  <?php echo '\''.GetAccountsByType($db, 'O').'\''; ?>;

var transfer_accounts = JSON.parse(transfer_accounts_str);
var income_accounts = JSON.parse(income_accounts_str);
var outcome_accounts = JSON.parse(outcome_accounts_str);

//-------------------------------------------------------------------------------------
function fiilIn(drop_id, accounts)
  {
  var drop = $(drop_id);
  drop.empty();

  for(var i = 0; i < accounts.length; ++i)
    {
    drop.append($('<option></option>').val(accounts[i][2]).html(accounts[i][0] +" "+ accounts[i][1]));
    } 
  }

//-------------------------------------------------------------------------------------
function myFunction() {

  var selected = $("#transaction_type-0 option:selected").val();
  if(selected == "income")
    fiilIn("#account_to-0", transfer_accounts);
  else if(selected == "outcome")
    fiilIn("#account_to-0", outcome_accounts);
  else
    fiilIn("#account_to-0", transfer_accounts);

    var acc_to = $("#account_to-0");
    var acc_from = $("#account_from-0");

    var selected = $("#account_from-0 option:selected").text();

    var is_usd = selected.indexOf("USD") != -1;
    var is_uah = selected.indexOf("UAH") != -1;
    var is_eur = selected.indexOf("EUR") != -1;

    var currency = selected.substr(selected.length - 3);

    var input = [];

    $("#account_to-0 option").each(function (e) {
        var text = $(this).text();
        var has_curr = text.indexOf(currency) != -1;

        if (has_curr) {
           input.push([$(this).val(), text]);
        }
    });

   acc_to.empty();
  for(var i = 0; i < input.length; ++i)
            acc_to.append($('<option></option>').val(input[i][0]).html(input[i][1]));


}

function TransactionTypeChnaged() 
  {
  var selected = $("#transaction_type-0 option:selected").val();
  if(selected == "income")
    fiilIn("#account_from-0", income_accounts);
  else if(selected == "outcome")
    fiilIn("#account_from-0", transfer_accounts);
  else
    fiilIn("#account_from-0", transfer_accounts);
myFunction();
  }

    $(document).ready(function () {

TransactionTypeChnaged();

        $("#account_from-0").change(function (e) {
            myFunction();
        });

        $("#transaction_type-0").change(function (e) {
            TransactionTypeChnaged();
        });

    });

</script>


<?php
// Load the main class
require_once 'HTML/QuickForm2.php';
require_once 'HTML/QuickForm2/Element/Select.php';
require_once "Table.php";

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}


$input_props = array('class' => 'layer1', 'size' => 50, 'maxlength' => 200);
$input_number = array('autocomplete'=> 'off', 'step'=>'0.01');

$form_transfer = new HTML_QuickForm2('transfer');

$fieldset_transfer = $form_transfer->addElement('fieldset')->setLabel('Transfer');

$transaction_type = $fieldset_transfer->addElement('select', 'transaction_type', array('class' => 'flt_left'))->setLabel('Type:');

$transaction_type->addOption("Расход",  'outcome');
$transaction_type->addOption("Перевод", 'transfer');
$transaction_type->addOption("Доход",   'income');

$transfer_account1 = $fieldset_transfer->addElement('select', 'account_from', array('class' => 'flt_left'))->setLabel('From:');
$transfer_account2 = $fieldset_transfer->addElement('select', 'account_to', array('class' => 'flt_left'))->setLabel('To:');

$transfer_comment = $fieldset_transfer->addElement('text', 'comment', array_merge($input_number,$input_props))->setLabel('Comment:');
$amount_transfer = $fieldset_transfer->addElement('number', 'amount', array_merge($input_number,$input_props))->setLabel('Amount:');
$fieldset_transfer->addElement('submit', null, array('value' => 'Transfer'));

$result = $db->query('SELECT ACCOUNTS.NAME, CURRENCIES.NAME, ACCOUNTS.ID FROM ACCOUNTS, CURRENCIES WHERE ACCOUNTS.CURRENCY_ID == CURRENCIES.ID');

while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
  //$transfer_account1->addOption($row[0].' '.$row[1], $row[2]);
  //$transfer_account2->addOption($row[0].' '.$row[1], $row[2]);
  } 

$form_delete = new HTML_QuickForm2('form_delete_transaction');
$fieldset_form_delete = $form_delete->addElement('fieldset')->setLabel('Enter transaction ID to delete');
$tr_id = $fieldset_form_delete->addElement('text', 'tr_id', array('class' => 'layer1', 'size' => 50, 'maxlength' => 200));
$fieldset_form_delete->addElement('submit', null, array('value' => 'Delete'));

	$form_run_wget = new HTML_QuickForm2('run_wget');
	{
	$fieldset_form_wget = $form_run_wget->addElement('fieldset')->setLabel('Enter download link');
	$down_link = $fieldset_form_wget->addElement('text', 'down_link', array('class' => 'layer1', 'size' => 50, 'maxlength' => 200));
	$fieldset_form_wget->addElement('submit', null, array('value' => 'DownLoad'));
	
	{
    echo "<br>"."<a href=downloaded/downloaded".">DownLoadedFiles</a>";
	}
	
	if ($form_run_wget->validate()) 
	  {
	  $down_link_text = $_POST["down_link"];
	  $fn_name = getGUID().".txt";
	  $down_cmd = "wget -P /mnt/sda1/Videos/downloaded ".$down_link_text.">/dev/null 2>/mnt/sda1/www/HomeFinance/downloaded/progress/".$fn_name." &";
	  echo "<br>".$down_cmd."<br>";
      exec($down_cmd);
	  }
	}
  
  // Try to validate a form
if ($form_delete->validate()) 
  {
  $tr_id = $_POST["tr_id"];
  $ids = explode("-", $tr_id);

  if(count($ids) == 1)
    $ids[] = $ids[0]; 

  $sql_str = 'DELETE FROM TRANSACTIONS WHERE ID>='.$ids[0].' AND ID<='.$ids[1];
  $db->query($sql_str);
  }
  
// Try to validate a form
if ($form_transfer->validate()) 
  {
  $acc_id1 = $_POST["account_from"];
  $acc_id2 = $_POST["account_to"];
  
  $amount =  $_POST["amount"];
  $comment = $_POST["comment"];
  $sql_str = 'INSERT INTO TRANSACTIONS(ACCOUNT_ID, ACCOUNT_ID_TO, AMOUNT, REASON) VALUES('.$acc_id1.','.$acc_id2.','.((-1)*$amount).', "'.$comment.'");';
  $db->query($sql_str);
  }  

echo $form_transfer.$form.$form_delete.$form_run_wget;
echo '</body></html>';

?>
