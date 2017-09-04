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
    // 默认mongodb
    'default' => [
        'uri'        => 'mongodb://admin:123456@172.18.107.241:28017,172.18.107.242:28017,172.18.107.243:28017/admin',
        'uriOptions' => [
            'readPreference' => \MongoDB\Driver\ReadPreference::RP_SECONDARY_PREFERRED,
        ],
        'driverOptions' => [],
    ],
    // member mongodb
    'member' => [
        'uri'        => 'mongodb://admin:123456@172.18.107.241:28017,172.18.107.242:28017,172.18.107.243:28017/admin',
        'uriOptions' => [
            'readPreference' => \MongoDB\Driver\ReadPreference::RP_SECONDARY_PREFERRED,
        ],
        'driverOptions' => [],
    ],
];
