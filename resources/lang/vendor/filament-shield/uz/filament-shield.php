<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Nomi',
    'column.guard_name' => 'Guard nomi',
    'column.roles' => 'Rollar',
    'column.permissions' => 'Ruxsatlar',
    'column.updated_at' => 'Yangilangan',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Nomi',
    'field.guard_name' => 'Guard nomi',
    'field.permissions' => 'Ruxsatlar',
    'field.select_all.name' => 'Barchasini tanlash',
    'field.select_all.message' => 'Ushbu rol uchun <span class="text-primary font-medium">mavjud</span> bo‘lgan barcha ruxsatlarni yoqish',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Sozlamalar',
    'nav.role.label' => 'Rollar',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Rol',
    'resource.label.roles' => 'Rollar',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */

    'section' => 'Obyektlar',
    'resources' => 'Resurslar',
    'widgets' => 'Vidjetlar',
    'pages' => 'Sahifalar',
    'custom' => 'Maxsus ruxsatlar',

    /*
    |--------------------------------------------------------------------------
    | Messages
    |--------------------------------------------------------------------------
    */

    'forbidden' => 'Sizda kirish huquqi yo‘q',

    /*
    |--------------------------------------------------------------------------
    | Resource Permissions' Labels
    |--------------------------------------------------------------------------
    */

    'resource_permission_prefixes_labels' => [
        'view' => 'Ko‘rish',
        'view_any' => 'Har qandayini ko‘rishi mumkin',
        'create' => 'Yaratish',
        'update' => 'Yangilash',
        'delete' => 'O‘chirish',
        'delete_any' => 'Har qandayini o‘chirishi mumkin',
        'force_delete' => 'Majburan o‘chirish',
        'force_delete_any' => 'Har qandayini majburan o‘chirishi mumkin',
        'restore' => 'Tiklash',
        'reorder' => 'Tartibni o‘zgartirish',
        'restore_any' => 'Har qandayini tiklashi mumkin',
        'replicate' => 'Nusxa ko‘chirish',
    ],
];
