<?php

require('auth.php');


echo 
'<html>
<head> 
<meta charset="utf-8">
<title>Управление транзакциями</title> 

 <head>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<script src="jquery-2.1.4.min.js"></script>
</head>

</style>
</head>
<body>

<style>
  .layer1, select
  {
  background: #EAF2D3;
  border: 1px solid black;
  padding: 5px;
  }

  .leftbar 
  {
  float: left;
  padding: 5px;
  }
  
  .noleft 
  {
  clear: left;
  }

  .leftbar 
  {
  float: left;
  padding: 5px;
  }
  
  .noleft 
  {
  clear: left;
  }

  .label
  {
  float: left;
  width: 70px;
  }
  
  
  .btn
  {
  clear: left;
  width: 20px;
  height: 20px;
  }
  
  .row
  {
  clear:left;
  }
  
  .element
  {
  width: 500px;
  }

   td.alt 
   {
        background-color: #C0FFC0;
    }
  
input[type=text] 
{
	padding:5px; border:2px solid #ccc;
webkit-border-radius: 5px;
	border-radius: 5px;
}

input[type=text]:focus 
	{
	border-color:#333; 
	}

input[type=submit] 
{
float: left;
}

  .flt_left
  {
  float: left;
  }

	
  </style>

</head>
<body>

  <div >
    <a class="layer1" href="manage_transactions.php">Manage transaction</a>
    <a class="layer1" href="/HomeFinance">View transaction</a>
    <a class="layer1" href="accounts_status_by_currency_table.php">Accounts state by currency</a>
    <a class="layer1" href="accounts_status_table.php">Accounts status</a>
    <a class="layer1" href="expenses_status_table.php">Expenses status</a>
    <a class="layer1" href="progress.php">Progress</a>
    <a class="layer1" href="upload.html">Upload File</a>
  </div>
  <br>';
?>
