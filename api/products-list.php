<?php

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

      //Fetch 3 rows from actor table
      $result = $dblink->query("SELECT * FROM products");

      //Initialize array variable
      $dbdata = array();

      //Fetch into associative array
      while ($row = $result->fetch_assoc()) {
         $dbdata[] = $row;
      }

      //Print array in JSON format
      echo json_encode($dbdata);

  } catch (mysqli_sql_exception $e) { // Failed to connect? Lets see the exception details..
      echo "MySQLi Error Code: " . $e->getCode() . "<br />";
      echo "Exception Msg: " . $e->getMessage();
      exit(); // exit and close connection.
  }

  $mysqli->close(); // finally, close the connection

?>
