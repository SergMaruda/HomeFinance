    <?php 
    include('auth.php');
    include 'header.php';

    include 'expenses_status.php';
    ?>

  <form action="expenses_status_table.php">
      <br>Account:<br>
      <input type="text" name="account">
      <br> Currency:<br>
      <select name="currency">
        <option value="uah">UAH</option>
        <option value="usd">USD</option>
        <option value="eur">EUR</option>
       </select>
    <br>
    <input type="submit" value="Submit">
    </form> 
  </body>
</html> 