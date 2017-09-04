<?php

declare(strict_types=1);

/*
 * This file is part of eelly package.
 *
 * (c) eelly.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$redisServer = [
    'parameters' => [
        'tcp://172.18.107.120:7000',
        'tcp://172.18.107.120:7001',
        'tcp://172.18.107.120:7002',
        'tcp://172.18.107.120:7003',
        'tcp://172.18.107.120:7004',
        'tcp://172.18.107.120:7005',
    ],
    'options' => [
        'connections' => [
            'tcp'  => 'Predis\Connection\PhpiredisStreamConnection',  // PHP stream resources
            'unix' => 'Predis\Connection\PhpiredisSocketConnection',  // ext-socket resources
        ],
        'cluster' => 'redis',
    ],
    'statsKey' => '_PHCR_MEMBER_STATS',
];

if (!extension_loaded('phpiredis')) {
    unset($redisServer['options']['connections']);
}

return [
    'frontend' => \Phalcon\Cache\Frontend\Igbinary::class,
    'backend'  => \Eelly\Cache\Backend\Predis::class,
    'options'  => [
        \Phalcon\Cache\Frontend\Igbinary::class => [
            'lifetime' => 300,
        ],
        \Eelly\Cache\Backend\Predis::class => $redisServer,
    ],
];
