<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");


$login = cekSession();
if ($login == 1) {
    redirect("../pages/home.php");
}

if (post("username")) {
    $username = post("username");
    $nomor = preg_replace('/[^\d]/','',post("nomor"));
    $otp = rand(123,789);
    $password = sha1($otp);
    $api_key = rand(100000, 999999);
    $cek = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");
    $cek2 = mysqli_query($conn, "SELECT * FROM device WHERE nomor = '$nomor'");
    if ($cek->num_rows > 0) {
        toastr_set("error", _USERNAME_NOT_AVAILABLE);
    } else if ($cek2->num_rows > 0) {
        toastr_set("error", _PHONE_NOT_AVAILABLE);
    } else {
        $pesan = 
            '*' . _APP_NAME . ' Automated system*' . "\r\n" .
            '*Registration request*' . "\r\n" .
            _USERNAME . ': ' . $username . "\r\n" . 
            //_PASSWORD_TEMP . ': ' . $otp . "\r\n" . 
            _PHONE . ': ' . $nomor . "\r\n" .
            '*PLEASE WAIT FOR ADMIN APPROVAL!*';
        $admin_phone = getSingleValDB("device", "pemilik", "admin", "nomor");
        $res = sendMSG($nomor, $pesan, $admin_phone);
        if ($res['status'] == "true") {
            $q = mysqli_query($conn, "INSERT INTO account (username, password, api_key, chunk)
            VALUES ('$username','$password','$api_key','60')");
            //var_dump($q);
            $q2 = mysqli_query($conn, "INSERT INTO device VALUES (null,'$username','$nomor','')");
            //var_dump($q2); die;
            toastr_set("success", _INVITE_REQUEST_SUCCESS);
            redirect("login.php");
        } else {
            toastr_set("error", _INVITE_REQUEST_FAILED);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo _APP_NAME ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= $base_url; ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= $base_url; ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" />
</head>

<body class="">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-4 col-lg-4 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><?php echo _INVITE_ONLY ?></h1>
                                    </div>
                                    <form class="user" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="<?php echo _USERNAME ?>" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="tel" class="form-control form-control-user" id="exampleInputPassword" placeholder="<?php echo _PHONE_INCLUDE_COUNTRY ?>" name="nomor" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block" onclick="return confirm('<?php echo _INVITE_CONFIRM ?>')">
                                            <?php echo _INVITE_BUTTON ?>
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php"><?php echo _LOGIN_BACK_TO ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= $base_url; ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= $base_url; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= $base_url; ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
    <script>
        <?php

        toastr_show();

        ?>
    </script>
</body>

</html>