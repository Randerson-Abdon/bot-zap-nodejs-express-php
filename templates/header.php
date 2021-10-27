<?php
include_once("../lang/default.php");
$version = "1.3.0";
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
    <link href="<?= $base_url; ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav  sidebar sidebar-success " id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="sidebar-brand-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?php echo _APP_NAME ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= $base_url; ?>pages/home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span><?php echo _DASHBOARD ?></span></a>
            </li>

            <?php if (file_exists("../waweb/index.php")) { ?>
            <li class="nav-item">
                <a class="nav-link" href="../waweb/index.php" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                    <span><?php echo _WHATSAPP_WEB ?></span></a>
            </li>
            <?php } ?>

            <li class="nav-item">
                <a class="nav-link" href="autoreply.php">
                    <i class="fas fa-reply-all"></i>
                    <span><?php echo _AUTOREPLY ?></span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="numbers.php">
                    <i class="fas fa-fw fa-phone-alt"></i>
                    <span><?php echo _PHONE_NUMBER ?></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contacts.php">
                    <i class="fas fa-fw fa-mobile-alt"></i>
                    <span><?php echo _DEVICE_CONTACT ?></span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="scheduled.php">
                    <i class="fas fa-fw fa-comments"></i>
                    <span><?php echo _SCHEDULED_MESSAGE ?></span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="message.php">
                    <i class="fas fa-fw fa-comment-alt"></i>
                    <span><?php echo _SEND_MESSAGE ?></span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="settings.php">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span><?php echo _SETTINGS ?></span></a>
            </li>

            <?php if ($_SESSION['level'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span><?php echo _USERS ?></span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="https://visimisi.net/my-account/downloads/" target="_blank" rel="noopener noreferrer">
                    <span>v<?php echo $version ?></span></a>
            </li>
            <?php } ?>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">

                <a class="sidebar-brand d-flex align-items-center justify-content-center">
                    <div class="navbar-brand-text text-primary">
                        <strong><?php echo _TOPBAR_BANNER ?></strong>
                    </div>
                </a>
                
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                        </li>


                        <!-- Nav Item - Messages -->

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['username'] ?></span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= $base_url; ?>auth/logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    <?php echo _LOGOUT ?>
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->