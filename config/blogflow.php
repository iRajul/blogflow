<?php

// config for irajul/Blogflow

return [
    'tables' => [
        'prefix' => 'blogflow_', // prefix for all blog tables
    ],
    'user' => [
        'model' => \App\Models\User::class,
        'foreign_key' => 'user_id',
        'columns' => [
            'name' => 'name',
        ],
    ],
    'featured_image' => [
        'thumbnail' => [
            'width' => 300,
            'height' => 300,
        ],
        'fallback_url' => 'https://images.unsplash.com/photo-1547586696-ea22b4d4235d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3270&q=80',
        'collection_name' => 'post_feature_image',
    ],
    'disk' => 'public',
];
