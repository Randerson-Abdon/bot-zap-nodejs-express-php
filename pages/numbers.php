<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");

cekLogin();

if (post("nama")) {
    $nama = post("nama");
    $nomor = post("nomor");
    $pesan = utf8_encode(post("pesan"));
    $u = $_SESSION['username'];


    $count = countDB("nomor", "nomor", $nomor);

    if ($count == 0) {
        $q = mysqli_query($conn, "INSERT INTO nomor(`nama`, `nomor`,`pesan`, `made_by`)
            VALUES('$nama', '$nomor','$pesan', '$u')");
        toastr_set("success", _PHONE_ADD_SUCCESS);
    } else {
        toastr_set("error", _PHONE_EXISTED);
    }
}

if (get("act") == "hapus") {
    $id = get("id");

    $q = mysqli_query($conn, "DELETE FROM nomor WHERE id='$id'");
    toastr_set("success", _PHONE_DELETE_SUCCESS);
    redirect("numbers.php");
}

if (get("act") == "delete_all") {
    $q = mysqli_query($conn, "DELETE FROM nomor");
    toastr_set("success", _PHONE_DELETE_SUCCESS);
    redirect("numbers.php");
}
require_once('../templates/header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
        <?php echo _PHONE_ADD ?>
    </button>
    <br>
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="display: contents"><?php echo _PHONE ?></h6>
            <a class="btn btn-danger float-right" href="numbers.php?act=delete_all" style="margin:5px"><?php echo _DELETE_ALL ?></a>
            <a class="btn btn-info float-right" href="<?= $base_url; ?>lib/export_excel.php" style="margin:5px"><?php echo _EXPORT_ALL ?></a>
            <button type="button" class="btn btn-success float-right" data-toggle="modal" style="margin:5px" data-target="#import">
                <?php echo _PHONE_IMPORT ?>
            </button>
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
                            <!--<th><?php echo _ID ?></th>-->
                            <th><?php echo _NAME ?></th>
                            <th><?php echo _PHONE ?></th>
                            <!--<th><?php echo _MESSAGES ?></th>-->
                            <th><?php echo _ACTION ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $u = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM nomor WHERE made_by='$u'");

                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<tr>';
                            //echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['nama'] . '</td>';
                            echo '<td>' . $row['nomor'] . '</td>';
                            //echo '<td>' . utf8_decode($row['pesan']) . '</td>';
                            echo '<td><a class="btn btn-danger" href="numbers.php?act=hapus&id=' . $row['id'] . '">' . _DELETE . '</a></td>';
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _PHONE_ADD ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <label> <?php echo _NAME ?> </label>
                    <input type="text" name="nama" required class="form-control"></input>
                    <br>
                    <label> <?php echo _PHONE ?> </label>
                    <input type="text" name="nomor" required class="form-control" placeholder="<?php echo _PHONE_INCLUDE_COUNTRY ?>"></input>
                    <!--<br>
                    <label> <?php echo _MESSAGES ?> </label>
                    <textarea type="text" name="pesan" required class="form-control" placeholder="<?php echo _MESSAGES ?>"></textarea>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _CLOSE ?></button>
                <button type="submit" class="btn btn-primary"><?php echo _SAVE ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="import" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _PHONE_IMPORT ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../lib/import_excel.php" method="POST" enctype="multipart/form-data">
                    <label> <?php echo _FILE_XLSX ?> </label>
                    <input type="file" name="file" required class="form-control">
                    <br>
                    <label> <?php echo _IMPORT_START_ROW ?> </label>
                    <input type="text" name="a" required class="form-control" value="2">
                    <br>
                    <label> <?php echo _IMPORT_NAME_COLUMN ?> </label>
                    <input type="text" name="b" required class="form-control" value="1">
                    <br>
                    <label> <?php echo _IMPORT_PHONE_COLUMN ?> </label>
                    <input type="text" name="c" required class="form-control" value="2">
                    <br>
                    <!--<label> <?php echo _IMPORT_MSG_COLUMN ?> </label>
                    <input type="text" name="d" required class="form-control" value="3">
                    <br>-->
                    <p> <?php echo _DOWNLOAD_SAMPLE_FILE ?> <a href="<?= $base_url; ?>excel/import_phone.xlsx" target="_blank"><?php echo _HERE ?></a> </p>
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

<!-- Page level custom scripts -->
<script src="<?= $base_url; ?>js/demo/datatables-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script>
    <?php

    toastr_show();

    ?>
</script>
</body>

</html>