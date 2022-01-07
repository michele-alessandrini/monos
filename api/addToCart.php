<?php

  require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

  sleep($_SERVER['DELAY_AJAX_IN_SEC']);

  $dbhost = $_SERVER['MONOS_DB_HOSTNAME'];
  $dbport = $_SERVER['MONOS_DB_PORT'];
  $dbname = $_SERVER['MONOS_DB_NAME'];
  $charset = 'utf8' ;

  $username = $_SERVER['MONOS_DB_UID'];
  $password = $_SERVER['MONOS_DB_PWD'];

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
?>
