<?php
$menu[0] = [
    [
        'p' => 0,
        'c' => 'Penjualan',
        'title' => 'Buka Order',
        'icon' => 'fas fa-cash-register',
        'txt' => 'Buka Order [ <b>' . $_SESSION['resto_cabangs'][$_SESSION['resto_user']['id_cabang']]['kode_cabang'] . '</b> ]'
    ],
    [
        'p' => 30,
        'c' => 'Riwayat',
        'title' => 'Riwayat Pesanan',
        'icon' => 'far fa-clock',
        'txt' => 'Riwayat Pesanan',
    ],
    [
        'p' => 30,
        'c' => 'Kas',
        'title' => 'Kas',
        'icon' => 'fas fa-wallet',
        'txt' => 'Kas',
    ],
    [
        'p' => 0,
        'c' => 'Absen',
        'title' => 'Absen',
        'icon' => 'fas fa-calendar-check',
        'txt' => 'Absen'
    ],
    [
        'p' => 30,
        'c' => 'Pelanggan',
        'title' => 'Pelanggan',
        'icon' => 'fas fa-address-book',
        'txt' => 'Pelanggan'
    ],
    // [
    //     'c' => '#',
    //     'title' => 'Piutang',
    //     'icon' => 'fas fa-receipt',
    //     'txt' => 'Piutang',
    // ],
];
