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

return [
    'adapter' => \Phalcon\Annotations\Adapter\Memory::class,
    'options' => [
        \Phalcon\Annotations\Adapter\Memory::class => [],
    ],
];

$redisAnnotationsServer = [
    'parameters' => [
        'tcp://172.18.107.120:7000',
        'tcp://172.18.107.120:7001',
        'tcp://172.18.107.120:7002',
        'tcp://172.18.107.120:7003',
        'tcp://172.18.107.120:7004',
        'tcp://172.18.107.120:7005',
    ],
    'options'  => ['cluster' => 'redis'],
    'statsKey' => '_PHCR_ANNOTATIONS_STATS',
];

return [
    'adapter' => \Eelly\Annotations\Adapter\Predis::class,
    'options' => [
        \Eelly\Annotations\Adapter\Predis::class => $redisAnnotationsServer,
     ],
];
