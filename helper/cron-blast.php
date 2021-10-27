<?php
include_once("connection.php");
include_once("function.php");

$now = date("Y-m-d H:i:s");
//$username = $_SESSION['username'];
//$chunk = getSingleValDB("account", "username", "$username", "chunk");
$chunk = 100;
$q = mysqli_query($conn, "SELECT * FROM pesan WHERE UNIX_TIMESTAMP(jadwal) < UNIX_TIMESTAMP('$now') AND status='PENDING' ORDER BY id ASC LIMIT 100 ");
//var_dump($q->fetch_assoc()); die;
$i = 0;
while ($data = $q->fetch_assoc()) {
    $sender = $data['sender'];
    $nomor = $data['nomor'];
    $pesan = utf8_decode($data['pesan']);
    $media = $data['media'];
    if ($data['media'] == null) {
        $send = sendMSG($nomor, $pesan, $sender);
        //usleep(100000);
    } else {
        $a = explode('/', $media);
        $filename = $a[count($a) - 1];
        $a2 = explode('.', $filename);
        $namefile = $a2[count($a2) - 2];
        $filetype = $a2[count($a2) - 1];
        $send = sendMedia($nomor, $pesan, $sender, $filetype, $namefile, $media);
        sleep(1);
    }
    if (!empty($send['status'])) {
        if ($send['status'] == "true") {
            $i++;
            $this_id = $data['id'];
            $q3 = mysqli_query($conn, "UPDATE pesan SET status = 'SENT' WHERE id='$this_id'");
        } else {
            $s = false;
        }
    }
}
echo 'succes sent to ' . $i . ' numbers';
