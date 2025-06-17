<?php
$menu[1] = [
    [
        'p' => 100,
        'c' => 'AdminApproval/index/Setoran',
        'title' => 'Approval',
        'icon' => 'fas fa-tasks',
        'txt' => 'Approval'
    ],
    [
        'p' => 100,
        'c' => 'WA_Status',
        'title' => 'WA_Status',
        'icon' => 'fab fa-whatsapp',
        'txt' => 'Whatsapp Status'
    ],
    [
        'p' => 100,
        'c' => '',
        'title' => 'Karyawan',
        'icon' => 'fas fa-user-friends',
        'txt' => 'Karyawan',
        'submenu' =>
        [
            [
                'c' => 'Karyawan/index/1',
                'title' => 'Karyawan Aktif',
                'txt' => 'Aktif',
            ],
            [
                'c' => 'Karyawan/index/0',
                'title' => 'Karyawan Non Aktif',
                'txt' => 'Non Aktif',
            ],
        ]
    ],
];
