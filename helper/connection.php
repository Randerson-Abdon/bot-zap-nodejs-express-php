<?php
$config = json_decode(file_get_contents(__DIR__ . "/../configs.json"), true);

$conn = mysqli_connect(
    $config['dbhost'],
    $config['dbuser'],
    $config['dbpass'],
    $config['dbname']
) or die('Database connection failed. Please check configs.json file!');

$base_url = $config['base_url'];
date_default_timezone_set($config['timezone']);
$registration = $config['registration'];
