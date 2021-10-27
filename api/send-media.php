<?php

include_once("../helper/connection.php");
include_once("../helper/function.php");


// Takes raw data from the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = json_decode(file_get_contents('php://input'), true);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$data = $_GET;
}

$sender =$data['sender'];
$nomor = $data['number'];
$caption = $data['message'];
$filetype = $data['filetype'];
$key = $data['api_key'];
$url = $data['url'];
header('Content-Type: application/json');


if(!isset($nomor) ||  !isset($sender) || !isset($key) || !isset($filetype) || !isset($url)){
    $ret['status'] = false;
    $ret['msg'] = "Wrong Parameter!";
    $ret['order_id'] = read_file()['order_id'];
    echo json_encode($ret, true);
    exit;
}

$a = explode('/',$url);
$filename = $a[count($a)-1];
$a2 = explode('.',$filename);
$namefile = $a2[count($a2)-2];
$ext = $a2[count($a2)-1];

if($ext != 'jpg' && $ext != 'png' && $ext != 'gif' && $ext != 'pdf' && $ext != 'mp3' && $ext != 'mp4'){
    $ret['status'] = false;
    $ret['msg'] = "Only support file JPG PNG GIF PDF MP3 MP4";
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
$res = sendMedia($nomor, $caption,$sender,$filetype,$namefile,$url);
if($res['status'] == "true"){
    $ret['status'] = true;
    $ret['msg'] = "Message Sent Success!";
    $ret['order_id'] = read_file()['order_id'];
    echo json_encode($ret, true);
    exit;
}else{
    $ret['status'] = false;
    $ret['msg'] = "Send Message Failed!";
    $ret['order_id'] = read_file()['order_id'];
    echo json_encode($ret, true);
    exit;
}

