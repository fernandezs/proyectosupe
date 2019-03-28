<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section
    | like so: @section('title', 'Dashboard | My Great Admin Panel')
    |
    */

    'title' => 'Gestion de proyectos universitarios',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>Proyectos</b>UPE',

    'logo_mini' => '<b>UPE</b>LT',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'purple',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | first two must respond to a GET request, the last two to a POST.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header.
    |
    */

    'menu' => [
        'NAVEGACION PRINCIPAL - ADMIN',
        
        [
            'text' => 'Dashboard',
            'url' => 'home',
            'icon' =>'tachometer'

        ],
        [
            'text' => 'Proyectos',
            'url' => 'projects',
            'icon' => 'folder-open',
            'submenu' => [
                [
                    'text' => 'Listar',
                    'url' => 'projects',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Nuevo',
                    'url'=> 'projects/create',
                    'icon' => 'folder'
                ]
            ]
        ],
        [
            'text' => 'Usuarios',
            'url' => 'users',
            'icon' => 'users',
            'submenu' => [
                [
                    'text' => 'Listar usuarios',
                    'url' => 'users',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Agregar usuario',
                    'url' => 'users/create',
                    'icon' => 'user-plus',
                ],
                [
                    'text' => 'Grupos',
                    'url' => '#',
                    'icon' => 'group',
                    'submenu' => [
                        [
                            'text' => 'Listar',
                            'url' => 'users/groups',
                            'icon' => 'list'
                        ],
                        [
                            'text' => 'Nuevo',
                            'url' => 'users/groups/create',
                            'icon' => 'plus'
                        ]
                    ]
                ]

            ],
        ],
        [
            'text' => 'Tareas',
            'url' => 'tasks',
            'icon' => 'tasks',
            'submenu' => [
                [
                    'text' => 'Listar',
                    'url' => 'tasks',
                    'icon' => 'list'
                ],
                [
                    'text' => 'Agregar tarea',
                    'url' => 'tasks/create',
                    'icon' => 'file-text'
                ],],
        ],
        'ACCOUNT SETTINGS',
        [
            'text' => 'Perfil de usuario',
            'url' => 'profile',
            'icon' => 'user'
        ],
        [
            'text' => 'Cambiar Password',
            'url' => 'perfil/change-password',
            'icon' => 'lock'
        ],

    ],

];
