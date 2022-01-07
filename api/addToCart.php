<?php

  require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

  sleep($_SERVER['DELAY_AJAX_IN_SEC']);

  $dbhost = $_SERVER['MONOS_DB_HOSTNAME'];
  $dbport = $_SERVER['MONOS_DB_PORT'];
  $dbname = $_SERVER['MONOS_DB_NAME'];
  $charset = 'utf8' ;

  $username = $_SERVER['MONOS_DB_UID'];
  $password = $_SERVER['MONOS_DB_PWD'];

  try {
      // Try Connect to the DB with new MySqli object - Params {hostname, userid, password, dbname}
      $dblink = new mysqli($dbhost, $username, $password, $dbname, $dbport);

      //Check connection was successful
      if ($dblink->connect_errno) {
         printf("Failed to connect to database");
         exit();
      }

      $qta = $_REQUEST['qtytoAdd'];
      $idP = $_REQUEST['idToAdd'];

      $sqlString = "INSERT INTO shopping_cart (idProduct, qtyProduct) VALUES(" . $idP . ", " . $qta . ") ON DUPLICATE KEY UPDATE idProduct= " . $idP . ", qtyProduct=" . $qta;

      $res = $dblink->query($sqlString);

        $options = array(
          'cluster' => 'eu',
          'useTLS' => true
        );

        $pusher = new Pusher\Pusher(
          '630cbbbb35f56d8c042d',
          '0908f6e4c160170defe2',
          '1327975',
          $options
        );

        $data = rand(1, 10);
        $pusher->trigger('monos', 'my-shopping', $data);

  } catch (mysqli_sql_exception $e) { // Failed to connect? Lets see the exception details..
        echo "MySQLi Error Code: " . $e->getCode() . "<br />";
        echo "Exception Msg: " . $e->getMessage();
        exit(); // exit and close connection.
  }

  $dblink->close(); // finally, close the connection
?>
