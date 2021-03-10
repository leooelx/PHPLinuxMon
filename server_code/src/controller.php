<?php
  $servername = "127.0.0.1";
  $database = "linuxmon";
  $username = "root";
  $password = "root";  
  global $machines;

  $conn = mysqli_connect($servername, $username, $password, $database);
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }
  
  $query = sprintf("SELECT * FROM machines");
  
  $result = mysqli_query($conn, $query);
  
  $machines['name'] = array();
  $machines['ip'] = array();
  $machines['description'] = array();
  $machines['monitor'] = array();
  $machines['status'] = array();
  
  while ($row = mysqli_fetch_assoc($result)) {
    array_push($machines['name'], $row['name']);
    array_push($machines['ip'], $row['ip']);
    array_push($machines['description'], $row['descriptions']);
    array_push($machines['monitor'], $row['mon']);
    $ping=exec("ping -q -c1 ".$row['ip']);
    array_push($machines['status'], $ping);
  }
  mysqli_close($conn);
  

  $machine_count=count($machines['name']);
?>