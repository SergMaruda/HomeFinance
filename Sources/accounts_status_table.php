<html>
  <head> 
    <meta charset="utf-8">
    <title>Состояние счетов</title> 
    <link rel="stylesheet" type="text/css" href="mystyle.css">
  
    <style>
     .layer1 
       {
       background: #EAF2D3;
       border: 1px solid black;
       padding: 5px;
      }
    </style>
  </head>

  <body>
    <div >
      <a class="layer1" href="manage_transactions.php">Manage transaction</a>
      <a class="layer1" href="transactions_view.php">View transaction</a>
      <a class="layer1" href="accounts_status_by_currency_table.php">Accounts state by currency</a>
      <a class="layer1" href="accounts_status_table.php">Accounts status</a>
    </div>

    <br>

    <?php include 'accounts_status.php';?>
  </body>
</html> 