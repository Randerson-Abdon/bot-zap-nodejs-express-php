<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");


$id = get("id");

$q = mysqli_query($conn, "DELETE FROM pesan WHERE id='$id'");
redirect("scheduled.php");
?>
