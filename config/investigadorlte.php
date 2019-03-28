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

    'skin' => 'blue',

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
        'INICIO - INVESTIGADOR',
        [
            'text' => 'Dashboard',
            'url' => 'home',
            'icon' =>'tachometer'

        ],
        [
            'text'    => 'Proyectos',
            'url'     => 'projects',
            'icon'    => 'folder-open',
            'submenu' => [
                [
                    'text' => 'Participando',
                    'url'  => 'projects',
                    'icon' => 'folder'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'projects/create',
                    'icon' => 'plus'
                ]
            ]
        ],
        [
            'text' => 'Grupos',
            'url' => '#',
            'icon' => 'group',
            'submenu' => [
                [
                'text' => 'Participando',
                'url'  => 'users/groups',
                'icon' => 'group'
                ],
                [
                    'text' => 'Crear',
                    'url'  => 'users/groups/create',
                    'icon' => 'plus'
                ]
            ]
        ],
        [
            'text' => 'Tareas',
            'url'  => '#',
            'icon' => 'tasks',
            'submenu' => [
                [
                    'text' => 'Listar',
                    'url'  => 'tasks',
                    'icon' => 'list',
                ],
                [
                    'text' => 'Agregar una tarea',
                    'url'  => 'tasks/create',
                    'icon' => 'plus'
                ]
            ]
        ],

        'AJUSTES DE CUENTA',
        [
            'text' => 'Perfil de Usuario',
            'url' => 'profile',
            'icon' => 'user'
        ],
        [
            'text' => 'Cambiar Contraseña',
            'url' => 'profile/change-password',
            'icon' => 'lock'
        ],

    ],

];
