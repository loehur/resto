<?php
if (isset($data)) {
    $title = $data['title'];
} else {
    $title = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="<?= $this->ASSETS_URL ?>icon/logo.png">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=400, user-scalable=no">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/ionicons.min.css">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-5.15.4-web/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/adminLTE-3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/select2/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/selectize.bootstrap3.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/jquery-ui.css" rel="stylesheet" />

    <style>
        @font-face {
            font-family: "fontku";
            src: url("<?= $this->ASSETS_URL ?>font/Titillium-Regular.otf");
        }

        html .table {
            font-family: 'fontku', sans-serif;
        }

        html .content {
            font-family: 'fontku', sans-serif;
        }

        html body {
            font-family: 'fontku', sans-serif;
        }

        @media print {
            p div {
                font-family: 'fontku', sans-serif;
                font-size: 14px;
            }
        }

        .modal-backdrop {
            opacity: 0.1 !important;
        }

        input:focus,
        .form-select:focus,
        .btn:focus,
        select:focus,
        textarea,
        input.form-control:focus {
            outline: none !important;
            outline-width: 0 !important;
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            display: none;
        }
    </style>
</head>

<?php

require_once('menu_kasir.php');
require_once('menu_admin.php');

$hideAdmin = "";
$hideKasir = "";
$classAdmin = "btn-danger";
$classKasir = "btn-success";

if ($_SESSION['user']['id_privilege'] == 100) {
    $hideAdmin = "d-none";
} else {
    $hideAdmin = "";
}

if (isset($_SESSION['log_mode'])) {
    $log_mode = $_SESSION['log_mode'];
} else {
    $log_mode = 0;
}
if ($log_mode == 1) {
    $hideAdmin = "";
    $hideKasir = "d-none";
    $classKasir = "btn-secondary";
} else {
    $hideAdmin = "d-none";
    $hideKasir = "";
    $classAdmin = "btn-secondary";
}

?>

<body class="hold-transition sidebar-mini small">
    <div class="loaderDiv" style="display: none;">
        <div class="loader"></div>
    </div>
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-light sticky-top pb-0 pt-2">
            <div class="row w-100 mx-0 px-0">
                <div class="col-auto ps-0 pe-1 text-nowrap">
                    <a class="nav-link p-0 ps-2" data-widget="pushmenu" href="#" role="button"> <span class="btn btn-sm"><i class="fas fa-bars"></i> Menu</span></a>
                </div>

                <?php if ($this->id_privilege == 100 or $this->id_privilege == 12) { ?>
                    <div class="col-auto ps-0 pe-1">
                        <select id="selectCabang" class="form-control form-control-sm bg-primary">
                            <?php foreach ($_SESSION['cabangs'] as $lcb) { ?>
                                <option class="font-weight-bold" value="<?= $lcb['id_cabang'] ?>" <?= ($this->id_cabang == $lcb['id_cabang']) ? "selected" : '' ?>><?= $lcb['kode_cabang'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-auto ps-0 pe-1">
                        <?php if ($this->id_privilege == 100) { ?>
                            <select id="userLog" class="form-control form-control-sm bg-success">
                                <option>------</option>
                                <?php foreach ($this->user as $a) {
                                    if ($a['id_user'] <> $_SESSION['user']['id_user']) { ?>
                                        <option value="<?= $a['id_user'] ?>"><?= strtoupper($a['nama_user']) ?></option>
                                <?php }
                                } ?>
                            </select>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div class="col-auto ps-0 me-auto pe-1">
                    <select id="selectBook" class="form-control form-control-sm bg-info">
                        <?php for ($y = URL::Y_START; $y <= date('Y'); $y++) { ?>
                            <option class="font-weight-bold" value="<?= $y ?>" <?= ($_SESSION['user']['book'] == $y) ? "selected" : '' ?>><?= $y ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-auto ps-0 pe-1">
                    <a class="refresh" href="#">
                        <span class="btn btn-sm btn-outline-success"><i class="fas fa-sync"></i></span>
                    </a>
                </div>
                <div class="col-auto ps-0 pe-1">
                    <a class="" href="<?= URL::BASE_URL ?>Login/logout" role="button">
                        <span class="btn btn-sm btn-outline-dark"><i class="fas fa-sign-out-alt"></i></span>
                    </a>
                </div>
            </div>
        </nav>

        <aside class="main-sidebar sidebar-light-green border-end">
            <div class="sidebar">
                <div class="user-panel mt-2 pb-2 mb-2 d-flex">
                    <div class="info">
                        <table class="text-secondary">
                            <tr>
                                <td><i class="fas fa-user-circle"></i></td>
                                <td><?= $this->nama_user . " #" . $this->id_cabang ?>#<span><?= date('d/m') ?> &nbsp;&nbsp;<b class="text-light"><i class="far fa-clock"></i> <span id="jam"><?= date('H') ?></span>:<span id="menit"><?= date('i') ?></span></span></b>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-wifi"></i></td>
                                <td><?= $_SESSION['cabangs'][$_SESSION['user']['id_cabang']]['wifi_pass']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <?php if ($this->id_privilege == 100) { ?>
                    <div class="row mx-0 user-panel mb-2 pb-2 pt-1">
                        <div class="col text-end mb-1">
                            <span id="btnKasir" style="width: 42px;" class="btn btn-sm <?= $classKasir ?> px-2"><i class="fas fa-cash-register"></i></span>
                        </div>
                        <div class="col text-start">
                            <span id="btnAdmin" style="width: 42px;" class="btn btn-sm <?= $classAdmin ?> px-2"><i class="fas fa-user-shield"></i></span>
                        </div>
                    </div>
                <?php } ?>

                <!-- MENU KASIR --------------------------------->
                <nav>
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php foreach ($menu as $key => $m) { ?>
                            <ul id="nav_<?= $key ?>" class="nav nav-pills nav-sidebar flex-column <?= $key == 0 ? $hideKasir : $hideAdmin ?>">
                                <?php foreach ($m as $mk) { ?>
                                    <?php if (!isset($mk['submenu'])) { ?>
                                        <li class="nav-item ">
                                            <a href="<?= URL::BASE_URL . $mk['c'] ?>" class="nav-link <?= (strpos($title, $mk['title']) !== FALSE) ? 'active' : '' ?>">
                                                <i class="nav-icon <?= $mk['icon'] ?>"></i>
                                                <p>
                                                    <?= $mk['txt'] ?>
                                                </p>
                                            </a>
                                        </li>
                                    <?php } else { ?>
                                        <li class="nav-item <?= (strpos($title, $mk['title']) !== FALSE) ? 'menu-is-opening menu-open' : '' ?>">
                                            <a href="#" class="nav-link <?= (strpos($title, $mk['title']) !== FALSE) ? 'active' : '' ?>">
                                                <i class="nav-icon <?= $mk['icon'] ?>"></i>
                                                <p>
                                                    <?= $mk['txt'] ?>
                                                    <i class="fas fa-angle-left right"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview" style="display: <?= (strpos($title, $mk['title']) !== FALSE) ? 'block' : 'none;'; ?>;">
                                                <?php foreach ($mk['submenu'] as $ms) { ?>
                                                    <li class="nav-item">
                                                        <a href="<?= URL::BASE_URL . $mk['c'] . $ms['c'] ?>" class="nav-link <?= ($title == $ms['title']) ? 'active' : '' ?>">
                                                            <i class="far fa-circle nav-icon"></i>
                                                            <p>
                                                                <b> <?= $ms['txt'] ?></b>
                                                            </p>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        <?php } ?>

                        <!-- INI MENU ADMIN ----------------------------------------->
                        <?php if ($this->id_privilege == 100) { ?>
                            <ul id="nav_3" class="nav nav-pills nav-sidebar flex-column <?= $hideAdmin ?>">
                                <?php if ($this->id_cabang > 0) { ?>
                                    <li class="nav-item <?php if (strpos($title, 'Rekap') !== FALSE) {
                                                            echo 'menu-is-opening menu-open';
                                                        } ?>">
                                        <a href="#" class="nav-link 
                <?php if (strpos($title, 'Rekap') !== FALSE) {
                                        echo 'active';
                                    } ?>">
                                            <i class="nav-icon fas fa-chart-line"></i>
                                            <p>
                                                Rekap
                                                <i class="fas fa-angle-left right"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview" style="display: 
                <?php if (strpos($title, 'Rekap') !== FALSE) {
                                        echo 'block;';
                                    } else {
                                        echo 'none;';
                                    } ?>;">
                                            <li class="nav-item">
                                                <a href="<?= URL::BASE_URL ?>Rekap/i/1" class="nav-link 
                    <?php if ($title == 'Harian Cabang - Rekap') {
                                        echo 'active';
                                    } ?>">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        Laba/Rugi Cabang Harian
                                                    </p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= URL::BASE_URL ?>Rekap/i/2" class="nav-link 
                    <?php if ($title == 'Bulanan Cabang - Rekap') {
                                        echo 'active';
                                    } ?>">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        Laba/Rugi Cabang Bulanan
                                                    </p>
                                                </a>
                                            </li>


                                            <li class="nav-item">
                                                <a href="<?= URL::BASE_URL ?>Rekap/i/4" class="nav-link 
                    <?php if ($title == 'Harian Laundry - Rekap') {
                                        echo 'active';
                                    } ?>">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        Laba/Rugi Laundry Harian
                                                    </p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="<?= URL::BASE_URL ?>Rekap/i/3" class="nav-link 
                    <?php if ($title == 'Bulanan Laundry - Rekap') {
                                        echo 'active';
                                    } ?>">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        Laba/Rugi Laundry Bulanan
                                                    </p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="<?= URL::BASE_URL ?>Export" class="nav-link 
                    <?php if ($title == 'Data Export - Rekap') {
                                        echo 'active';
                                    } ?>">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        Data Export
                                                    </p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="<?= URL::BASE_URL ?>Gaji" class="nav-link 
                    <?php if ($title == 'Gaji Bulanan - Rekap') {
                                        echo 'active';
                                    } ?>">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>
                                                        Gaji Bulanan
                                                    </p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>


                                <li class="nav-item ">
                                    <a href="<?= URL::BASE_URL ?>Cabang_List" class="nav-link 
                  <?php if ($title == 'Data Cabang') : echo 'active';
                            endif ?>">
                                        <i class="nav-icon fas fa-store"></i>
                                        <p>
                                            Cabang
                                        </p>
                                    </a>
                                </li>

                                <li class="nav-item 
                <?php if (strpos($title, 'Item') !== FALSE) {
                                echo 'menu-is-opening menu-open';
                            } ?>">
                                    <a href="#" class="nav-link 
                <?php if (strpos($title, 'Item') !== FALSE) {
                                echo 'active';
                            } ?>">
                                        <i class="nav-icon fas fa-list"></i>
                                        <p>
                                            Item List
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" style="display: 
                <?php if (strpos($title, 'Item') !== FALSE) {
                                echo 'block;';
                            } else {
                                echo 'none;';
                            } ?>;">
                                        <li class="nav-item">
                                            <a href="<?= URL::BASE_URL ?>Data_List/i/item" class="nav-link 
              <?php if ($title == 'Item Laundry') {
                                echo 'active';
                            } ?>">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Item Laundry
                                                </p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="<?= URL::BASE_URL ?>Data_List/i/item_pengeluaran" class="nav-link 
              <?php if ($title == 'Item Pengeluaran') {
                                echo 'active';
                            } ?>">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Pengeluaran
                                                </p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="<?= URL::BASE_URL ?>Data_List/i/surcas" class="nav-link 
              <?php if ($title == 'Surcharge') {
                                echo 'active';
                            } ?>">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>
                                                    Surcharge
                                                </p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>


                                <?php
                                // JIKA SUDAH PUNYA CABANG
                                if ($this->id_cabang > 0) { ?>
                                    <li class="nav-item ">
                                        <a href="<?= URL::BASE_URL ?>Setting" class="nav-link 
                  <?php if ($title == 'Setting') : echo 'active';
                                    endif ?>">
                                            <i class="nav-icon fas fa-wrench"></i>
                                            <p>
                                                Setting
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="<?= URL::BASE_URL ?>Troubleshoot" class="nav-link 
                  <?php if ($title == 'Troubleshoot') : echo 'active';
                                    endif ?>">
                                            <i class="nav-icon fas fa-hammer"></i>
                                            <p>
                                                Troubleshoot
                                            </p>
                                        </a>
                                    </li>
                            </ul>
                    <?php
                                }
                            } ?>
                    </ul>
                </nav>
            </div>
        </aside>

        <style>
            .content-wrapper {
                max-height: 100px;
                overflow: auto;
                display: inline-block;
            }
        </style>

        <div class="content-wrapper pt-2 px-2 bg-white" id="content" style="min-width: 390px;">
            <script src="<?= $this->ASSETS_URL ?>plugins/adminLTE-3.1.0/jquery/jquery.min.js"></script>
            <script src="<?= $this->ASSETS_URL ?>plugins/adminLTE-3.1.0/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
            <script src="<?= $this->ASSETS_URL ?>plugins/adminLTE-3.1.0/js/adminlte.js"></script>

            <script>
                $(document).ready(function() {

                });

                $("a.refresh").on('click', function() {
                    $.ajax('<?= URL::BASE_URL ?>Data_List/synchrone', {
                        beforeSend: function() {
                            $(".loaderDiv").fadeIn("fast");
                        },
                        success: function(data, status, xhr) {
                            location.reload(true);
                        }
                    });
                });

                $("span#btnKasir").click(function() {
                    $.ajax({
                        url: "<?= URL::BASE_URL ?>Login/log_mode",
                        data: {
                            mode: 0
                        },
                        type: "POST",
                        dataType: 'html',
                        success: function(res) {
                            $("#nav_0").removeClass('d-none');
                            $("#nav_2").removeClass('d-none');
                            $("#nav_1").addClass('d-none');
                            $("#nav_3").addClass('d-none');

                            $("span#btnKasir").removeClass("btn-secondary").addClass("btn-success");
                            $("span#btnAdmin").removeClass("btn-danger").addClass("btn-secondary");
                        },
                    });
                });

                $("span#btnAdmin").click(function() {
                    $.ajax({
                        url: '<?= URL::BASE_URL ?>Login/log_mode',
                        data: {
                            mode: 1
                        },
                        type: "POST",
                        dataType: 'html',
                        success: function(response) {
                            $("#nav_0").addClass('d-none');
                            $("#nav_2").addClass('d-none');
                            $("#nav_1").removeClass('d-none');
                            $("#nav_3").removeClass('d-none');

                            $("span#btnKasir").removeClass("btn-success").addClass("btn-secondary");
                            $("span#btnAdmin").removeClass("btn-secondary").addClass("btn-danger");
                        },
                    });
                })

                $("select#selectCabang").on("change", function() {
                    var idCabang = $(this).val();
                    $.ajax({
                        url: '<?= URL::BASE_URL ?>Cabang_List/selectCabang',
                        data: {
                            id: idCabang
                        },
                        beforeSend: function() {
                            $(".loaderDiv").fadeIn("fast");
                        },
                        type: "POST",
                        success: function(response) {
                            location.reload(true);
                        },
                    });
                });

                $("select#selectBook").on("change", function() {
                    var id = $(this).val();
                    $.ajax({
                        url: '<?= URL::BASE_URL ?>Cabang_List/selectBook',
                        data: {
                            book: id
                        },
                        beforeSend: function() {
                            $(".loaderDiv").fadeIn("fast");
                        },
                        type: "POST",
                        success: function(res) {
                            if (res == 0) {
                                location.reload(true);
                            } else {
                                console.log(res);
                            }
                        },
                    });
                });

                $("select#userLog").on("change", function() {
                    var id_user = $(this).val();
                    $.ajax({
                        url: '<?= URL::BASE_URL ?>Login/switchUser',
                        data: {
                            id: id_user
                        },
                        beforeSend: function() {
                            $(".loaderDiv").fadeIn("fast");
                        },
                        type: "POST",
                        success: function(res) {
                            location.reload(true);
                        },
                    });
                });

                window.setTimeout("waktu()", 60000);

                function waktu() {
                    setTimeout("waktu()", 60000);
                    $("#jam").load('<?= URL::BASE_URL . 'Time/get/H' ?>');
                    $("#menit").load('<?= URL::BASE_URL . 'Time/get/i' ?>');
                    $("#detik").load('<?= URL::BASE_URL . 'Time/get/s' ?>');
                }
            </script>