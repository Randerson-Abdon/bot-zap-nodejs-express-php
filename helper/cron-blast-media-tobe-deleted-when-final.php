<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");

$count = 0;
$now = date("Y-m-d H:i:s");
$chunk = 100;
$q = mysqli_query($conn, "SELECT * FROM pesan WHERE UNIX_TIMESTAMP(jadwal) < UNIX_TIMESTAMP('$now') AND status='PENDING' ORDER BY id ASC LIMIT 100 ");
//var_dump($q->fetch_assoc()); die;
$i = 0;
while ($data = $q->fetch_assoc()) {
    $sender = $data['sender'];
    $nomor = $data['nomor'];
    $pesan = $data['pesan'];
    $media = $data['media'];
    if ($data['media'] != null) {

        $a = explode('/', $media);
        $filename = $a[count($a) - 1];
        $a2 = explode('.', $filename);
        $namefile = $a2[count($a2) - 2];
        $filetype = $a2[count($a2) - 1];
        $send = sendMedia($nomor, $pesan, $sender, $filetype, $namefile, $media);
        $this_id = $data['id'];
        if ($send['status'] == "true") {
            $i++;
            $q3 = mysqli_query($conn, "UPDATE pesan SET status = 'SENT' WHERE id='$this_id'");
        } else {
            $q3 = mysqli_query($conn, "UPDATE pesan SET status = 'FAILED' WHERE id='$this_id'");
            $s = false;
        }
        usleep(100000);
    }
}
echo 'succes sent to ' . $i . ' numbers';
