<?php

return [
    'Algolia' => [
        'file' => 'algolia',
        'description' => '',
        'events' => [
            'OnMODXInit' => [],
            'OnSiteSettingsRender' => [],

            'OnDocFormSave' => [],
            'OnDocPublished' => [],
            'OnDocUnPublished' => [],
            'OnResourceDuplicate' => [],
            'OnResourceDelete' => [],
            'OnResourceUndelete' => [],

            'pbOnAfterSave' => [],
            'pbOnAfterPublished' => [],
            'pbOnAfterUnPublished' => [],
            'pbOnAfterDuplicate' => [],
            'pbOnAfterDelete' => [],
        ],
    ],
];