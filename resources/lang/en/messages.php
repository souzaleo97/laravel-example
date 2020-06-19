<?php

return [
    'hidden_data' => 'Data omitted from the log',

    'routes' => [
        'error' => [
            '401' => 'Unauthorized.',
            '403' => 'Forbidden.',
            '404' => 'Not Found.',
            '405' => 'This route does not have this method.',
            '419' => 'Page Expired.',
            '429' => 'Too Many Requests.',
            '500' => 'Server Error.',
            '503' => 'Service Unavailable.',
            'other_code' => 'Error :code.'
        ]
    ]
];
