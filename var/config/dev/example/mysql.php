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

// 一主多从

$redisMetaDataServer = [
    'parameters' => [
        'tcp://172.18.107.120:7000',
        'tcp://172.18.107.120:7001',
        'tcp://172.18.107.120:7002',
        'tcp://172.18.107.120:7003',
        'tcp://172.18.107.120:7004',
        'tcp://172.18.107.120:7005',
    ],
    'options' => [
        'cluster' => 'redis',
    ],
    'lifetime' => 172800,
    'statsKey' => '_PHCR_MODEL_METADATA_STATS',
];

return [
    'master' => [
        'host'     => '172.18.107.96',
        'username' => 'devmall',
        'password' => 'devmall',
        'dbname'   => 'member',
        'options'  => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            \PDO::ATTR_CASE               => \PDO::CASE_LOWER,
        ],
    ],
    'slave' => [
        'server_0' => [
            'host'     => '172.18.107.96',
            'username' => 'devmall',
            'password' => 'devmall',
            'dbname'   => 'member',
            'options'  => [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                \PDO::ATTR_CASE               => \PDO::CASE_LOWER,
            ],
        ],
        'server_1' => [
            'host'     => '172.18.107.96',
            'username' => 'devmall',
            'password' => 'devmall',
            'dbname'   => 'member',
            'options'  => [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                \PDO::ATTR_CASE               => \PDO::CASE_LOWER,
            ],
        ],
    ],
    'metaData' => [
        'adapter' => \Eelly\Mvc\Model\MetaData\Predis::class,
        'options' => [
            \Eelly\Mvc\Model\MetaData\Predis::class => $redisMetaDataServer,
        ],
    ],
];
