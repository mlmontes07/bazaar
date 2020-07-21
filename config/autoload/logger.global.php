<?php
use Laminas\Log\Logger;
use Laminas\Log\Writer\Stream;

return [
    'AppLogger' => [
        'doNotLog' => [
            'mediaTypes' => [
                'application/octet-stream',
                'image/png',
                'image/jpeg',
                'application/pdf'
            ]
        ],
        'writers' => [
            'standard-file' => [
                'adapter' => Stream::class,
                'options' => [
                    'output' => '' // always set to empty to create log files for each day
                ],
                // options: EMERG, ALERT, CRIT, ERR, WARN, NOTICE, INFO, DEBUG
                'filter' => Logger::DEBUG,
                'enabled' => true
            ]
        ]
    ]
];