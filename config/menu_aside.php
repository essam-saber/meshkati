<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Dashboard',
            'root' => true,
            'icon' => 'media/svg/icons/Design/Layers.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/',
            'new-tab' => false,
        ],
        [
            'section' => 'sales'
        ],
        [
            'title' => 'Sales Analysis',
            'icon' => 'media/svg/icons/Media/Equalizer.svg',
            'root' => true,
            'bullet' => 'dot',
            'submenu' => [
                [
                    'title' => 'Browse Actual Sales',
                    'page' => 'sales'
                ],
                [
                    'title' => 'Browse Sales Budget',
                    'page' => 'budget'
                ],

            ]
        ],
        [
            'section' => 'inventory'
        ],
        [
            'title' => 'Inventory ',
            'icon' => 'media/svg/icons/Media/Equalizer.svg',
            'root' => true,
            'bullet' => 'dot',
            'submenu' => [
                [
                    'title' => 'Aging of Debit',
                    'page' => '/aging-of-debit'
                ],
                [
                    'title' => 'Inventory',
                    'page' => '/inventory'
                ],
            ],
        ],
        [
            'section' => 'reports'
        ],
        [
            'title' => 'Reports',
            'icon' => 'media/svg/icons/Media/Equalizer.svg',
            'root' => true,
            'bullet' => 'dot',
            'submenu' => [
                [
                    'title' => 'Sales Analysis & Comparative',
                    'page' => 'reports/sales-analysis-and-comparative'
                ],
                [
                    'title' => 'Sales & GP Budget',
                    'page' => 'reports/sales-and-gp-budget'
                ],
                [
                    'title' => 'Summary',
                    'page' => 'reports/summary'
                ],
            ]
        ],

    ]

];
