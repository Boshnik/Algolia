<?php

return [
    'debug' => [
        'xtype' => 'modx-combo-boolean',
        'value' => false,
        'area' => 'main',
    ],
    'app_id' => [
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'algolia',
    ],
    'api_key' => [
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'algolia',
    ],
    'index_name' => [
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'algolia',
    ],
    'searchable_fields' => [
        'xtype' => 'textfield',
        'value' => 'alias,pagetitle,longtitle,description,introtext',
        'area' => 'algolia',
    ],
    'fields_to_retrieve' => [
        'xtype' => 'textfield',
        'value' => 'alias,pagetitle,longtitle,description,introtext',
        'area' => 'algolia',
    ],
    'fields' => [
        'xtype' => 'textfield',
        'value' => 'alias,pagetitle,longtitle,description,introtext',
        'area' => 'resource',
    ],
    'class_key' => [
        'xtype' => 'algolia-combo-resource-type',
        'value' => 'modDocument',
        'area' => 'resource',
    ],
    'where' => [
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'resource',
    ]
];