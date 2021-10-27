<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");

cekLogin();

require_once('../templates/header.php');
$username = $_SESSION['username'];
$q1 = mysqli_query($conn, "SELECT * FROM `pesan` WHERE `made_by`='$username' and `status`='SENT'");
$sent = mysqli_num_rows($q1);
$q2 = mysqli_query($conn, "SELECT * FROM `pesan` WHERE `made_by`='$username' and `status`='FAILED'");
$failed = mysqli_num_rows($q2);
$q3 = mysqli_query($conn, "SELECT * FROM `pesan` WHERE `made_by`='$username' and `status`='PENDING'");
$pending = mysqli_num_rows($q3);
$total_msg = $sent + $failed + $pending;
if ($total_msg === 0) {
    $percentage = 0;
} else {
    $percentage = round($sent/$total_msg * 100);
}
$autoreplies = countDB("autoreply", "made_by", $username);
$imported = countDB("nomor", "made_by", $username);
$device_contacts = countDB("contacts", "made_by", $username);

?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo _DASHBOARD ?></h1>
    </div>

    <div class="row">
        <!-- Sent Messages Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                <?php echo _SCHEDULED_SENT ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $sent; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Failed Messages Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                <?php echo _SCHEDULED_FAILED ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $failed ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                <?php echo _SCHEDULED_WAITING ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $pending ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pause fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sent Percentage Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <?php echo _SCHEDULED_PERCENTAGE ?>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        <?= $percentage ?>%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $percentage ?>%" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-double fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Autoreplies Phone Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo _AUTOREPLIES ?> </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $autoreplies ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-reply-all fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imported Phone Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo _PHONE_NUMBERS ?> </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $imported ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-phone fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Phone Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?php echo _DEVICE_CONTACTS ?> </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $device_contacts ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-mobile-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

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

<!-- Bootstrap core JavaScript-->
<script src="<?= $base_url; ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= $base_url; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= $base_url; ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= $base_url; ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= $base_url; ?>vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= $base_url; ?>js/demo/chart-area-demo.js"></script>
<script src="<?= $base_url; ?>js/demo/chart-pie-demo.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.0/socket.io.js" integrity="sha512-+l9L4lMTFNy3dEglQpprf7jQBhQsQ3/WvOnjaN/+/L4i0jOstgScV0q2TjfvRF4V+ZePMDuZYIQtg5T4MKr+MQ==" crossorigin="anonymous"></script>-->
<script src="../node_modules/socket.io/client-dist/socket.io.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
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