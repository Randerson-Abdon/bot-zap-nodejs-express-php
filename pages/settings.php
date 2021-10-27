<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");

cekLogin();

if (post("username")) {
    $u = post("username");
    $password = post('newpassword');

    if (strlen($password) < 6) {
        toastr_set("error", _PASSWORD_MINIMAL);
    } else if (post("newpassword") != post("newpassword2")) {
        toastr_set("error", _PASSWORD_NOT_MATCH);
        //exit;
    } else {
        $p = sha1(post("newpassword"));
        $u = $_SESSION['username'];
        $q = mysqli_query($conn, "UPDATE account SET password = '$p' WHERE username = '$u' ");
        if ($q) {

            toastr_set("success", _PASSWORD_CHANGE_SUCCESS);
        }
    }
}

if (get("act") == "hapus") {
    $nomor = get("nomor");
    $file = '../whatsapp-session-' . $nomor . '.json';
    $cekfile = file_exists($file);

    if ($cekfile == true) {
        toastr_set("error", _SENDER_PLEASE_DISCONNECT);
    } else {
        $q = mysqli_query($conn, "DELETE FROM device WHERE nomor='$nomor'");
        toastr_set("success", _SENDER_DELETE_SUCCESS);
    }
}

if (post("nomorwhatsapp")) {
    $nomor = post("nomorwhatsapp");
    $cek = mysqli_query($conn, "SELECT * FROM device WHERE nomor = '$nomor' ");
    if (mysqli_num_rows($cek) > 0) {
        toastr_set("error", _PHONE_EXISTED);
    } else {
        $username = $_SESSION['username'];
        $q = mysqli_query($conn, "INSERT INTO device VALUES (null,'$username','$nomor','')");
        toastr_set("success", _SENDER_ADD_SUCCESS);
    }
}

if (post("idnomor")) {
    $id = post("idnomor");
    $url = post("urlwebhook");
    $update = mysqli_query($conn, "UPDATE device SET link_webhook = '$url' WHERE id = '$id'");
    toastr_set("success", _WEBHOOK_SET_SUCCESS);
}

if (post("chunk")) {
    $username = $_SESSION['username'];
    $chunk = post("chunk");
    if ($chunk > 100) {
        toastr_set("error", _BULK_SENDING_LIMIT);
    } else {
        mysqli_query($conn, "UPDATE account SET chunk = '$chunk' WHERE username='$username'");
        toastr_set("success", _SETTINGS_EDIT_SUCCESS);
    }
}

if (post("apikey")) {
    $username = $_SESSION['username'];
    $api_key = rand(100000, 999999);
    mysqli_query($conn, "UPDATE account SET api_key='$api_key' WHERE username='$username'");
    toastr_set("success", _APIKEY_CHANGE_SUCCESS);
}

if (post("dbhost")) {
    $filename = __DIR__ . '/../configs.json';
    if (file_exists($filename)) {
        $str = file_get_contents($filename);
        $data = json_decode($str, true);
        $data['dbhost'] = post('dbhost');
        $data['dbuser'] = post('dbuser');
        $data['dbpass'] = post('dbpass');
        $data['dbname'] = post('dbname');
        $data['port']   = post('port');
        $data['timezone'] = post('timezone');
        $data['base_url'] = post('base_url');
        $data['callback_url'] = post('callback_url');
        $data['registration'] = post('registration');
        $json = str_replace('\\','',json_encode($data));
        require_once("../helper/json_indent.php");
        $json_indent = json_indent($json);
        file_put_contents($filename, $json_indent);
    } else {
        die('Unable to open file for write!');
    }
    toastr_set("success", "Configuration is updated");
    redirect("settings.php");
}

require_once('../templates/header.php');
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#tambahSenderModal"><?php echo _SENDER_ADD ?></button>    
                    <?php if ($_SESSION['level'] == 1) { ?>
                    <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#editConfigs" style="float: right;">Edit Configs</button>
                    <?php } ?>
                    <div class="table table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?php echo _PHONE ?></th>
                                    <th><?php echo _WEBHOOK_URL ?></th>
                                    <th><?php echo _ACTION ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $username = $_SESSION['username'];
                                $q = mysqli_query($conn, "SELECT * FROM device WHERE pemilik = '$username'");
                                while ($row = mysqli_fetch_assoc($q)) { ?>
                                    <tr>
                                        <td><?= $row['nomor']; ?></td>

                                        <td><?= $row['link_webhook']; ?></td>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary scanbutton" onclick="scanqr('<?= $row['nomor']; ?>')"><?php echo _SCAN ?></button>
                                            <a class="btn btn-danger" href="settings.php?act=hapus&nomor=<?= $row['nomor']; ?>"><?php echo _DELETE ?></a>
                                            <button class="btn btn-success" onclick="sethook('<?= $row['id']; ?>')"><?php echo _WEBHOOK_SET ?></button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="" method="post">
                        <label> <?php echo _USERNAME ?> </label>
                        <input type="text" class="form-control" name="username" readonly value="<?= getSingleValDB("account", "username", "$username", "username") ?>">
                        <br>
                        <label> <?php echo _PASSWORD_NEW ?> </label>
                        <input type="password" class="form-control" name="newpassword">
                        <br>
                        <label> <?php echo _PASSWORD_REPEAT ?> </label>
                        <input type="password" class="form-control" name="newpassword2">
                        <br>
                        <button class="btn btn-primary"> <?php echo _PASSWORD_CHANGE ?> </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="" method="post">
                        <label> <?php echo _APIKEY ?> </label>
                        <?php $username = $_SESSION['username']; ?>
                        <input type="text" class="form-control" name="apikey" readonly value="<?= getSingleValDB("account", "username", "$username", "api_key") ?>">
                        <br>
                        <button class="btn btn-primary" onclick="return confirm('<?php echo _APIKEY_CHANGE_CONFIRM ?>')"> <?php echo _APIKEY_CHANGE ?> </button>
                        <a class="btn btn-primary" href="restapi.php">Rest-Api CODE</a>
                        <br>
                        <br>
                    </form>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="" method="post">
                        <label> <?php echo _BULK_SENDING_LIMIT ?> </label>
                        <input type="text" class="form-control" name="chunk" value="<?= getSingleValDB("account", "username", "$username", "chunk") ?>">
                        <br>
                        <button class="btn btn-primary"> <?php echo _SAVE ?> </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

<?php require_once('../templates/footer.php'); ?>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _LOGOUT_TITLE ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?php echo _LOGOUT_BODY ?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php echo _CANCEL ?></button>
                <a class="btn btn-primary" href="<?= $base_url; ?>auth/logout.php"><?php echo _LOGOUT ?></a>
            </div>
        </div>
    </div>
</div>

<!-- Add Sender Modal -->
<div class="modal fade" id="tambahSenderModal" tabindex="-1" role="dialog" aria-labelledby="tambahSenderModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <?php echo _SENDER_ADD ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <label> <?php echo _PHONE ?> </label>
                    <input type="number" name="nomorwhatsapp" placeholder="<?php echo _PHONE_INCLUDE_COUNTRY ?>" required class="form-control">
                    <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _CLOSE ?></button>
                <button type="submit" name="tambahnomor" class="btn btn-primary"><?php echo _SAVE ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- set hook modal -->
<div class="modal fade" id="setHookModal" tabindex="-1" role="dialog" aria-labelledby="setHookModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _WEBHOOK_SET ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bodysetwebhook">
                <form action="" method="POST">
                    <input type="hidden" name="idnomor" class="idnomor" readonly required class="form-control">
                    <br>
                    <label><?php echo _WEBHOOK_URL ?></label>
                    <input type="text" name="urlwebhook" class="form-control urlwebhook">
                    <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _CLOSE ?></button>
                <button type="submit" name="sethookmodal" class="btn btn-primary"><?php echo _SAVE ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- scan Modal-->
<div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _SCAN ?></h5>
            </div>
            <div class="card shadow m-3 areascanqr">


            </div>
        </div>
    </div>
</div>

<!-- Add Sender Modal -->
<div class="modal fade" id="editConfigs" tabindex="-1" role="dialog" aria-labelledby="editConfigs" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Edit Configs </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <label> Database Hostname </label>
                    <input type="text" class="form-control" name="dbhost" value="<?php echo $config['dbhost'] ?>">
                    <label> Database Username </label>
                    <input type="text" class="form-control" name="dbuser" value="<?php echo $config['dbuser'] ?>">
                    <label> Database Password </label>
                    <input type="password" class="form-control" name="dbpass" value="<?php echo $config['dbpass'] ?>">
                    <label> Database Name </label>
                    <input type="text" class="form-control" name="dbname" value="<?php echo $config['dbname'] ?>">
                    <label> Nodejs Server port </label>
                    <input type="text" class="form-control" name="port" value="<?php echo $config['port'] ?>">
                    <label> Timezone </label>
                    <input type="text" class="form-control" name="timezone" value="<?php echo $config['timezone'] ?>">
                    <label> Base URL </label>
                    <input type="text" class="form-control" name="base_url" value="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/' ?>">
                    <label> Callback URL </label>
                    <input type="text" class="form-control" name="callback_url" value="<?php echo 'https://' . $_SERVER['SERVER_NAME'] . '/helper/callback.php' ?>">
                    <label> Allow Registration</label>
                    <select class="form-control" name="registration">
                        <option value="0" <?php echo ($config['registration'] == "0") ? "selected" : ''; ?> > NO </option>
                        <option value="1" <?php echo ($config['registration'] == "1") ? "selected" : ''; ?> > YES </option>
                    </select>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _CLOSE ?></button>
                        <button type="submit" name="editconfigs" class="btn btn-primary"><?php echo _SAVE ?></button>
                    </div>
                </form>
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
<script src="<?= $base_url; ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= $base_url; ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $base_url; ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= $base_url; ?>js/demo/datatables-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script>

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.0/socket.io.js" integrity="sha512-+l9L4lMTFNy3dEglQpprf7jQBhQsQ3/WvOnjaN/+/L4i0jOstgScV0q2TjfvRF4V+ZePMDuZYIQtg5T4MKr+MQ==" crossorigin="anonymous"></script>
<script>
<?php

toastr_show();
global $base_url;
if (stripos($base_url, 'localhost')) {
?>
    var socket = io('http://localhost:3000', {
        transports: ['websocket', 'polling', 'flashsocket']
    });
<?php } else { ?>
    var socket = io()
<?php } ?>
    
function scanqr(nomor) {
    $('.areascanqr').html(`
        <div class="card-body">
            <div id="cardimg-${nomor}" class="text-center ">
            </div>
            <p id="info-${nomor}" class="info-${nomor}"></p>
            <div class="div arealogout"></div>
            <button class="btn btn-danger scanbutton" onclick="logoutqr(${nomor})"><?php echo _DISCONNECT ?></button>
        </div>

    `)
    $(`#cardimg-${nomor}`).html(`<img src="../loading.gif" class="card-img-top center" alt="cardimg" id="qrcode"
        style="height:250px; width:250px;"><br><p><?php echo _CONNECTING ?></p>`);
    $('#scanModal').modal('show');
    socket.emit('create-session', {
        id: nomor
    });
}

// sethook
function sethook(id) {
    $('.idnomor').val(id);
    var hook = $('.urlwebhook').val();
    $('#setHookModal').modal('show');
}

// function ini untuk logout
function logoutqr(nomor) {
    socket.emit('logout', {
        id: nomor
    });
}

socket.on('message', function(msg) {
    $('.log').html(`<li>` + msg.text + `</li>`);
})
socket.on('qr', function(src) {
    console.log(src)
    $(`#cardimg-${src.id}`).html(`<img src="` + src.src + `" class="card-img-top" alt="cardimg" id="qrcode"
    style="height:250px; width:250px;">`);
    var count = 10;
    var interval = setInterval(function() {
        count--
        $(`.info-${src.id}`).html(`<p><?php echo _SCAN_TIME ?>: <span class="text-danger">${count}</span></p>`);
        if (count == 0) {
            $(`#cardimg-${src.id}`).html(`<h2 class="text-center text-warning mt-4"><?php echo _PLEASE_REFRESH_TO_RESCAN ?><h2>`);

            clearInterval(interval)
        }
    }, 1000);
});
// socket.on('authenticated', function(src) {
//     $(`#info-${src.id}`).attr('class', 'changed');
//     $('.changed').html('')
//     $(`#cardimg-${src.id}`).html(`<h2 class="text-center text-success mt-4">` + src.text + `<h2>`);

// });
// ketika terhubung
socket.on('authenticated', function(src) {
    const nomors = src.data.jid;
    //  const nomor = src.id
    const nomor = nomors.replace(/\D/g, '');
    //$(`#cardimg-${src.id}`).html(` <img src="` + src.data.imgUrl + `" class="card-img-top" alt="Profile Pic" id="qrcode" style="height:250px; width:250px;"><br><br>
    $(`#cardimg-${src.id}`).html(`<h2 class="text-center text-success mt-4">Whatsapp Connected<br></h2>
        <ul>
            <li> Name : ${src.data.name}</li>
            <li> WA Number : ${src.data.jid}</li>
            <li> Device Name : ${src.data.phone.device_model}</li>
            <li> WA Version : ${src.data.phone.wa_version}</li>
        </ul>
            
    `);
    //  $('#cardimg').html(`<h2 class="text-center text-success mt-4">Whatsapp Connected.<br>` + src + `<h2>`);

});
socket.on('isdelete', function(src) {
    //  $(`.info-${src.id}`).html(`<p><span class="text-danger">disconnect</span></p>`);
    $(`#cardimg-${src.id}`).html(src.text);
});
socket.on('close', function(src) {
    console.log(src);
    $(`#cardimg-${src.id}`).html(`<h2 class="text-center text-danger mt-4">` + src.text + `<h2>`);
})
</script>
</body>

</html>