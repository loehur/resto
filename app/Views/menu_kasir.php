<?php
$menu[0] = [
    [
        'c' => 'Penjualan',
        'title' => 'Buka Order',
        'icon' => 'fas fa-cash-register',
        'txt' => 'Buka Order [ <b>' . $_SESSION['cabangs'][$_SESSION['user']['id_cabang']]['kode_cabang'] . '</b> ]'
    ],
    [
        'c' => 'Riwayat',
        'title' => 'Riwayat Pesanan',
        'icon' => 'far fa-clock',
        'txt' => 'Riwayat Pesanan',
    ],
    [
        'c' => 'Kas',
        'title' => 'Kas',
        'icon' => 'fas fa-wallet',
        'txt' => 'Kas',
    ],
    [
        'c' => '#',
        'title' => 'Piutang',
        'icon' => 'fas fa-receipt',
        'txt' => 'Piutang',
    ],
    [
        'c' => 'Pelanggan',
        'title' => 'Pelanggan',
        'icon' => 'fas fa-address-book',
        'txt' => 'Pelanggan'
    ],
    [
        'c' => '',
        'title' => 'Karyawan',
        'icon' => 'fas fa-users-cog',
        'txt' => 'Karyawan',
        'submenu' =>
        [
            [
                'c' => 'Absen',
                'title' => 'Karyawan Absen',
                'txt' => 'Absen Harian',
            ],
            [
                'c' => 'Pindah_Outlet',
                'title' => 'Karyawan Pindah Outlet',
                'txt' => 'Pindah Outlet',
            ],
        ]
    ],
];
