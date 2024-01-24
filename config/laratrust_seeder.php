<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => false,

    'roles_structure' => [
        'super_admin' => [
            'user' => 'c,r,u,d',
            'category' => 'c,r,u,d',
            'store' => 'c,r,u,d',
            'product' => 'c,r,u,d',
            'tag' => 'c,r,u,d',
            'role' => 'c,r,u,d',
        ],
        'admin' => [
            'user' => 'c,r,u',
            'category' => 'c,r,u,d',
            'store' => 'c,r,u,d',
            'product' => 'c,r,u,d',
            'tag' => 'c,r,u,d',
            'role' => 'c,r,u,d',
        ]
    ],

    'modules_translations' => [
        'user' => [
            'ar' => 'مستخدم',
            'en' => 'User'
        ],
        'category' => [
            'ar' => 'قسم',
            'en' => 'Category'
        ],
        'store' => [
            'ar' => 'متجر',
            'en' => 'Store'
        ],
        'product' => [
            'ar' => 'منتج',
            'en' => 'Product'
        ],
        'tag' => [
            'ar' => 'علامة',
            'en' => 'Tag'
        ],
        'role' => [
            'ar' => 'دور',
            'en' => 'Role'
        ],
    ],

    'role_translations' => [
        'super_admin' =>
            [
                'ar' => ['display_name' => 'مدير التطبيق'],
                'en' => ['display_name' => 'Super Admin']
            ],
        'admin' =>
            [
                'ar' => ['display_name' => 'مدير'],
                'en' => ['display_name' => 'Admin']
            ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],

    'permission_translations' => [
        'c' =>
            [
                'ar' => 'إنشاء',
                'en' => 'Create'
            ],
        'r' =>
            [
                'ar' => 'قراءة',
                'en' => 'Read'
            ],
        'u' =>
            [
                'ar' => 'تحديث',
                'en' => 'Update'
            ],
        'd' =>
            [
                'ar' => 'حذف',
                'en' => 'Delete'
            ]
    ],
];
