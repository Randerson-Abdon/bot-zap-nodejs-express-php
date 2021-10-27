<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");

cekLogin();


if (get("act") == "hapus") {
    $id = get("id");

    $q = mysqli_query($conn, "DELETE FROM autoreply WHERE id='$id'");
    toastr_set("success", _AUTOREPLY_DELETE_SUCCESS);
    redirect("autoreply.php");
}

if(post("nomor")){
    $nomor = post("nomor");
    $keyword = strtolower(post("keyword"));
    $respon = urlencode(post("response"));
    $respon = str_replace("+", "%20", $respon);
    if (!empty($_FILES['media']) && $_FILES['media']['error'] == UPLOAD_ERR_OK) {
        // Be sure we're dealing with an upload
        if (is_uploaded_file($_FILES['media']['tmp_name']) === false) {
            throw new \Exception('Error on upload: Invalid file definition');
        }

        // Rename the uploaded file
        $uploadName = $_FILES['media']['name'];
        $ext = strtolower(substr($uploadName, strripos($uploadName, '.') + 1));

        $allow = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'mp3', 'mp4'];
        if (in_array($ext, $allow)) {
                $filename = $uploadName;
        } else {
            toastr_set("error", "Format jpg, png, gif, pdf, mp3, and mp4 only");
            redirect("autoreply.php");
            exit;
        }
        
        move_uploaded_file($_FILES['media']['tmp_name'], 'uploads/' . $filename);
        // Insert it into our tracking along with the original name
        $media = $base_url . "pages/uploads/" . $filename;
    } else {
        $media = null;
    }

$u = $_SESSION['username'];
    $cek = mysqli_query($conn,"SELECT * FROM autoreply WHERE nomor = '$nomor' AND keyword = '$keyword'");
    if(mysqli_num_rows($cek) > 0){
        toastr_set("error", "Number with that keyword existed");
    } else {
        $q = mysqli_query($conn, "INSERT INTO autoreply VALUES (null,'$keyword','$respon','$media','$nomor','$u')");
        toastr_set("success", _AUTOREPLY_ADD_SUCCESS);
    }
}
require_once('../templates/header.php');
?>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
        <?php echo _AUTOREPLY_ADD ?>
    </button>
    <br>
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo _AUTOREPLY_LIST ?></h6>
        </div>
        <style> table {
            border-spacing: 0px;
            table-layout: fixed;
            margin-left: auto;
            margin-right: auto;
        }
        </style>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo _SENDER ?></th>
                            <th><?php echo _KEYWORD ?></th>
                            <th><?php echo _RESPONSE ?></th>
                            <th><?php echo _RESPONSE_MEDIA ?></th>
                            <th><?php echo _ACTION ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $username = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM autoreply WHERE made_by = '$username'");

                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<tr>';
                            echo '<td>' . $row['nomor'] . '</td>';
                            echo '<td>' . $row['keyword'] . '</td>';
                            echo '<td>' . urldecode($row['response']) . '</td>';
                            echo '<td>' . $row['media'] . '</td>';
                            echo '<td><a class="btn btn-danger" href="autoreply.php?act=hapus&id=' . $row['id'] . '">' . _DELETE . '</a></td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
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
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                <a class="btn btn-primary" href="<?= $base_url;?>auth/logout.php"><?php echo _LOGOUT ?></a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _AUTOREPLY_ADD ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                <label for=""><?php echo _PHONE ?></label>
                <select class="form-control" name="nomor" style="width: 100%">
                    <?php
                        $u = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM device WHERE pemilik='$u'");
                    while ($row = mysqli_fetch_assoc($q)) {
                        echo '<option value="' . $row['nomor'] . '">' . $row['nomor'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <label> <?php echo _KEYWORD ?> </label>
                <input type="text" name="keyword" required class="form-control">
                <br>
                <label> <?php echo _RESPONSE ?> </label>
                <textarea name="response" class="form-control" required></textarea>
                <br>
                <label> <?php echo _MEDIA . ' (jpg/png/gif/pdf/mp3/mp4)' ?> </label>
                <input type="file" name="media" class="form-control">
                  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _CLOSE ?></button>
                <button type="submit" class="btn btn-primary"><?php echo _SAVE ?></button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                dropdownAutoWidth: true
            });
        });
    </script>
<!-- Page level custom scripts -->
<script src="<?= $base_url; ?>js/demo/datatables-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous"></script>
<script>
    <?php

    toastr_show();

    ?>
</script>
</body>

</html>