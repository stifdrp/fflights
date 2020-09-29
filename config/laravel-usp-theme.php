<?php

$adminMenu = [
    [
        'text' => '<i class="fas fa-atom"></i>  Usuários',
        'url' => config('app.url') . '/admin/users',
    ],
];
$financerMenu = [
    [
        'text' => 'Listar verbas',
        'url' => config('app.url') . '/financer/budgets',
    ],
    [
        'text' => 'Criar verba',
        'url' => config('app.url') . '/financer/budget/create',
    ],
    [
        'text' => 'Listar solicitações',
        'url' => config('app.url') . '/solicitations',
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
            'text' => '<i class="fas fa-home"></i> Solicitar Passagens',
            'url' => config('app.url') . '/solicitation/create',
            'can' => 'authenticated',
        ],
        [
            'text' => '<i class="fas fa-home"></i> Minhas Solicitações',
            'url' => config('app.url') . '/solicitations/my',
            'can' => 'authenticated',
        ],
        [
            'text' => 'Financeiro',
            'submenu' => $financerMenu,
            'can' => 'financer',
        ],
    ],
    'right_menu' => [
        [
            'text' => '<i class="fas fa-cog"></i>',
            'title' => 'Configurações',
            'url' => config('app.url') . '/admin/users',
            'can' => 'admin',
        ],
    ],
];
