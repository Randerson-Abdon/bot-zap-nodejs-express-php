<?php

include_once("../helper/connection.php");
include_once("../helper/function.php");


// Takes raw data from the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = json_decode(file_get_contents('php://input'), true);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$data = $_GET;
}

$sender = $data['sender'];
$nomor = $data['number'];
$pesan = $data['message'];
$key = $data['api_key'];
header('Content-Type: application/json');



if(!isset($nomor) && !isset($pesan) && !isset($sender) && !isset($key)){
    $ret['status'] = false;
    $ret['msg'] = "Wrong Parameter!";
    $ret['order_id'] = read_file()['order_id'];
    echo json_encode($ret, true);
    exit;
}

$cek = mysqli_query($conn,"SELECT * FROM account WHERE api_key = '$key'");
if($cek->num_rows < 1){
    $ret['status'] = false;
    $ret['msg'] = "Invalid ApiKey (Token)!";
    $ret['order_id'] = read_file()['order_id'];
    echo json_encode($ret, true);
    exit;
}
$username = $cek->fetch_assoc()['username'];
$cek2 = mysqli_query($conn,"SELECT * FROM device WHERE nomor = '$sender' AND pemilik = '$username'");
if($cek2->num_rows < 1){
    $ret['status'] = false;
    $ret['msg'] = "Invalid ApiKey (Token)!";
    $ret['order_id'] = read_file()['order_id'];
    echo json_encode($ret, true);
    exit;
}
$res = sendMSG($nomor, $pesan, $sender);
if (!empty($res)) {
	if($res['status'] == "true"){
		$ret['status'] = true;
		$ret['msg'] = "Message Sent Success!";
		$ret['order_id'] = read_file()['order_id'];
		echo json_encode($ret, true);
		exit;
	} else {
		$ret['status'] = false;
		$ret['msg'] = "Send Message Failed!";
		$ret['order_id'] = read_file()['order_id'];
		echo json_encode($ret, true);
		exit;
	}
} else {
	$ret['status'] = false;
	$ret['msg'] = "No respons from server.";
	$ret['order_id'] = read_file()['order_id'];
	echo json_encode($ret, true);
	exit;
}
