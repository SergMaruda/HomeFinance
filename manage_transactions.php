<?php

include 'header.php';
?>

<script type="text/javascript">

    function myFunction() {
        var acc_to = $("#account_to-0");
        acc_to.empty();

        var acc_from = $("#account_from-0");

        var selected = $("#account_from-0 option:selected").text();

        console.log(selected);
        var is_usd = selected.indexOf("USD") != -1;
        var is_uah = selected.indexOf("UAH") != -1;
        var is_eur = selected.indexOf("EUR") != -1;

        var currency = selected.substr(selected.length - 3);


        $("#account_from-0 option").each(function (e) {
            var text = $(this).text();
            var has_curr = text.indexOf(currency) != -1;

            if (has_curr) {
                acc_to.append($('<option></option>').val($(this).val()).html($(this).text()));
            }
        });

    }

    $(document).ready(function () {

        myFunction();
        $("#account_from-0").change(function (e) {
            myFunction();
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



// Instantiate the HTML_QuickForm2 object
$form = new HTML_QuickForm2('tutorial');

// Add some elements to the form
$fieldset = $form->addElement('fieldset')->setLabel('Add new transaction');
                 
$select_account = $fieldset->addElement('select', 'account', array('class' => 'layer1'))->setLabel('Select account:');

$input_props = array('class' => 'layer1', 'size' => 50, 'maxlength' => 200);
$input_number = array( 'step'=>'0.01');
$form_transfer = new HTML_QuickForm2('transfer');
 
$fieldset_transfer = $form_transfer->addElement('fieldset')->setLabel('Transfer');
$transfer_account1 = $fieldset_transfer->addElement('select', 'account_from', array('class' => 'flt_left'))->setLabel('From:');
$transfer_account2 = $fieldset_transfer->addElement('select', 'account_to', array('class' => 'flt_left'))->setLabel('To:');
$amount_transfer = $fieldset_transfer->addElement('number', 'amount', array_merge($input_number,$input_props))->setLabel('Transfer amount:');
$fieldset_transfer->addElement('submit', null, array('value' => 'Transfer'));

$db = new SQLite3("Expences.db");
if (!$db) exit("db creation failed!"); 
$result = $db->query('SELECT ACCOUNTS.NAME, CURRENCIES.NAME, ACCOUNTS.ID FROM ACCOUNTS, CURRENCIES WHERE ACCOUNTS.CURRENCY_ID == CURRENCIES.ID');

while ($row = $result->fetchArray(SQLITE3_NUM)) 
  {
  $select_account->   addOption($row[0].' '.$row[1], $row[2]);
  $transfer_account1->addOption($row[0].' '.$row[1], $row[2]);
  $transfer_account2->addOption($row[0].' '.$row[1], $row[2]);
  } 

$reason = $fieldset->addElement('text', 'reason', $input_props)->setLabel('Reason:');
$amount = $fieldset->addElement('number', 'amount', array_merge($input_number,$input_props))->setLabel('Expense amount:');

$fieldset->addElement('submit', null, array('value' => 'Add'));

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
if ($form->validate()) 
  {
  $acc_id = $_POST["account"];
  $reason = "\"".$_POST["reason"]."\"";
  $amount = "\"".$_POST["amount"]."\"";
  $sql_str = 'INSERT INTO TRANSACTIONS(ACCOUNT_ID, AMOUNT, REASON) VALUES('.$acc_id.','.$amount.', '.$reason.')';
  $db->query($sql_str);
  }
  
  // Try to validate a form
if ($form_delete->validate()) 
  {
  $tr_id = $_POST["tr_id"];
  $sql_str = 'DELETE FROM TRANSACTIONS WHERE ID=='.$tr_id;
  $db->query($sql_str);
  }
  
// Try to validate a form
if ($form_transfer->validate()) 
  {
  $acc_id1 = $_POST["account_from"];
  $acc_id2 = $_POST["account_to"];
  
  $amount = $_POST["amount"];
  $sql_str = 'INSERT INTO TRANSACTIONS(ACCOUNT_ID, AMOUNT, REASON) VALUES('.$acc_id1.',"-'.$amount.'", "перевод");';
  $sql_str = $sql_str.'INSERT INTO TRANSACTIONS(ACCOUNT_ID, AMOUNT, REASON) VALUES('.$acc_id2.',"'.$amount.'", "перевод");';  
  $db->query($sql_str);
  }  

echo $form.$form_delete.$form_transfer.$form_run_wget;
echo '</body></html>';

?>
