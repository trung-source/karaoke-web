<?php

require 'function.php';
// $userid = $_SESSION['id'];
// mysqli_query($conn, "DELETE FROM `room_product` WHERE user_id = '$userid' ") or die('query failed');
     
session_start();
session_unset();
session_destroy();

header('location:index.php');

?>