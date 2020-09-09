<?php

$submenu1 = [
    [
        'text' => '<i class="fas fa-atom"></i>  Usuários',
        'url' => config('app.url') . '/admin/users',
    ],
];

return [
    'title' => config('app.name'),
    'dashboard_url' => config('app.url') . '/home',
    'logout_method' => 'POST',
    'logout_url' => config('app.url') . '/logout',
    'login_url' => config('app.url') . '/login',
    'menu' => [
        [
            'text' => '<i class="fas fa-home"></i> Home',
            'url' => config('app.url') . '/home',
            'can' => 'authenticated',
        ],
        [
            'text' => 'Configurações',
            'submenu' => $submenu1,
            'can' => 'admin',
        ],
    ],
    'right_menu' => [
        [
            'text' => '<i class="fas fa-cog"></i>',
            'title' => 'Configurações',
            'target' => '_blank',
            'url' => config('app.url') . '/item1',
            'can' => 'authenticated',
        ],
    ],
];
