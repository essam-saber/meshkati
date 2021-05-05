<?php
return [
    'actual_sales' => [
        'create',
        'read',
        'edit',
        'delete'
    ],
    'budget_sales' => [
        'create',
        'read',
        'edit',
        'delete'
    ],
    'aging' => [
        'create',
        'read',
        'edit',
        'delete'
    ],
//    'summary_report' => ['read'],
////    'sales_analysis_and_comparative_report' => ['read'],
////    'sales_and_gp_budget_report' => ['read'],
////    'ageing_of_debit_report' => ['create','read','delete','edit'],
    'dashboard' => ['read'],
    'reports' => ['read'],
    'inventory' => ['create', 'read','delete','edit'],
    'employees' => [
        'create',
        'read',
        'delete',
        'edit'
    ],
    'roles' => [
    'create',
    'read',
    'delete',
    'edit'
    ],
    'permissions' => [
        'create',
        'read',
        'delete',
        'edit'
    ]
];