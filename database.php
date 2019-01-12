<?php

function dbConnect($dbserver,$dbuser,$dbpass, $dbname) {

// print_r('sdfsa');
// print_r($dbuser);
// print_r('asdfas');
// die();

  @ $db = new mysqli($dbserver, $dbuser, $dbpass, $dbname);
  # Check if able to connect or not
  if($db->connect_error){
    echo "Connection failed, because " . $db->connect_error;
    exit();
  }
  return $db;
}
