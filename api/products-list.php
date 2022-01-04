<?php
  $dbhost = $_SERVER['MONOS_DB_HOSTNAME'];
  $dbport = $_SERVER['MONOS_DB_PORT'];
  $dbname = $_SERVER['MONOS_DB_NAME'];
  $charset = 'utf8' ;

  $username = $_SERVER['MONOS_DB_UID'];
  $password = $_SERVER['MONOS_DB_PWD'];

  try {
      // Try Connect to the DB with new MySqli object - Params {hostname, userid, password, dbname}
      $mysqli = new mysqli($dbhost, $username, $password, $dbname, $dbport);


      $statement = $mysqli->prepare("SELECT * from products");


      $statement->execute(); // Execute the statement.
      $result = $statement->get_result(); // Binds the last executed statement as a result.

      echo json_encode(($result->fetch_assoc())); // Parse to JSON and print.

  } catch (mysqli_sql_exception $e) { // Failed to connect? Lets see the exception details..
      echo "MySQLi Error Code: " . $e->getCode() . "<br />";
      echo "Exception Msg: " . $e->getMessage();
      exit(); // exit and close connection.
  }

  $mysqli->close(); // finally, close the connection


?>
