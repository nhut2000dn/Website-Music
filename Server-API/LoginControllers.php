<?php
  include("config/connection.php");
  $query    = 'SELECT * FROM account WHERE username="' . $_POST['UsernameLogin'] . '" AND password="' . $_POST['passwordLogin'] . '"';
  $result   = mysqli_query($connection,$query);
  $number   = mysqli_num_rows($result);
  $row      = mysqli_fetch_array($result,MYSQLI_ASSOC);
  if ($row["user_types_id"] == 1) {
    $resp['idAccount'] = $row["id"];
    $resp['username'] = $row["username"];
    $resp['typeAccount'] = "admin";
    $resp['status'] = true;
    echo json_encode($resp);
    exit;
  } else if ($row["user_types_id"] == 2) {
    $resp['idAccount'] = $row["id"];
    $resp['username'] = $row["username"];
    $resp['typeAccount'] = "user";
    $resp['status'] = true;
    echo json_encode($resp);
    exit;
  }
  $resp['status'] = false;
  echo json_encode($resp);
?>