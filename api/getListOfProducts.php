<?php
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

      //Check filters

      $isVegan = $_GET["vegan"] ?? "false";
      $isGluten = $_GET["gluten"] ?? "false";
      $isLactose = $_GET["lactose"] ?? "false";

      $sqlString = "SELECT DISTINCT p.id,
                                    p.productName,
                                    p.productDescription,
                                    p.productImage,
                                    IFNULL(GROUP_CONCAT(DISTINCT top.type
                                          ORDER BY top.type SEPARATOR ', '), '-') as TypeOfProduct
                       FROM `monos-db`.products p
	                     LEFT OUTER JOIN `monos-db`.product_type pt ON  p.id = pt.idProduct
                       LEFT OUTER JOIN `monos-db`.types_of_products top ON pt.idType = top.id
                       WHERE 1 = 1";

      if ($isVegan == "true" || $isGluten == "true" || $isLactose == "true")
      {
        $sqlString .= " AND (1 = 2";
      }

      if($isVegan == "true")
      {
        $sqlString .= " OR top.id = 1";
      }
      if($isGluten == "true")
      {
        $sqlString .= " OR top.id = 2";
      }
      if($isLactose == "true")
      {
        $sqlString .= " OR top.id = 3";
      }

      if ($isVegan == "true" || $isGluten == "true" || $isLactose == "true")
      {
        $sqlString .= ")";
      }

      $sqlString .= " GROUP BY p.id, p.productName, p.productDescription, p.productImage";
      $sqlString .= " ORDER BY p.productName DESC";



      $result = $dblink->query($sqlString);

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

  $dblink->close(); // finally, close the connection

?>
