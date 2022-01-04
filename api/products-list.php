<?php
  $dbhost = $_SERVER['MONOS_DB_HOSTNAME'];
  $dbport = $_SERVER['MONOS_DB_PORT'];
  $dbname = $_SERVER['MONOS_DB_NAME'];
  $charset = 'utf8' ;

  $username = $_SERVER['MONOS_DB_UID'];
  $password = $_SERVER['MONOS_DB_PWD'];

  $connection = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);

  $sql = "SELECT * from products";

  $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

  $emparray = array();
  while($row =mysqli_fetch_assoc($result))
  {
        $emparray[] = $row;
  }

  echo json_encode($emparray);

  //close the db connection
  mysqli_close($connection);
?>
