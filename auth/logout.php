<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");

session_destroy();
redirect("login.php");